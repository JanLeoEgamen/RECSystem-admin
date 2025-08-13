<?php

namespace App\Http\Controllers;

use App\Models\Markee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class MarkeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view markees', only: ['index']),
            new Middleware('permission:edit markees', only: ['edit', 'update']),
            new Middleware('permission:create markees', only: ['create', 'store']),
            new Middleware('permission:delete markees', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Markee::with('user:id,first_name,last_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('header', 'like', '%' . $request->search . '%')
                          ->orWhere('content', 'like', '%' . $request->search . '%')
                          ->orWhereHas('user', function($q) use ($request) {
                              $q->where('first_name', 'like', '%' . $request->search . '%')
                                ->orWhere('last_name', 'like', '%' . $request->search . '%');
                          });
                    });
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $markees = $query->paginate($perPage);

                $transformedMarkees = $markees->getCollection()->map(function ($markee) {
                    return [
                        'id' => $markee->id,
                        'header' => $markee->header,
                        'content' => Str::limit($markee->content, 50),
                        'author' => $markee->user->first_name ?? 'Unknown' . ' ' . $markee->user->last_name ?? '',
                        'status' => $markee->status ? 'Active' : 'Inactive',
                        'created_at' => $markee->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedMarkees,
                    'current_page' => $markees->currentPage(),
                    'last_page' => $markees->lastPage(),
                    'from' => $markees->firstItem(),
                    'to' => $markees->lastItem(),
                    'total' => $markees->total(),
                ]);
            }

            return view('markees.list');

        } catch (\Exception $e) {
            Log::error('Markee index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load markees'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load markees. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('markees.create');
        } catch (\Exception $e) {
            Log::error('Markee create form error: ' . $e->getMessage());
            return redirect()->route('markees.index')
                ->with('error', 'Failed to load markee creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateMarkeeRequest($request);

            $markee = Markee::create([
                'header' => $validated['header'],
                'content' => $validated['content'],
                'status' => $validated['status'] ?? true,
                'user_id' => $request->user()->id,
            ]);

            return redirect()->route('markees.index')
                ->with('success', 'Markee added successfully');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('Markee store error: ' . $e->getMessage());
            return redirect()->route('markees.create')
                ->withInput()
                ->with('error', 'Failed to create markee. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $markee = Markee::findOrFail($id);
            return view('markees.edit', compact('markee'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Markee not found for editing: {$id}");
            return redirect()->route('markees.index')
                ->with('error', 'Markee not found.');

        } catch (\Exception $e) {
            Log::error("Markee edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('markees.index')
                ->with('error', 'Failed to load markee edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $markee = Markee::findOrFail($id);
            $validated = $this->validateMarkeeRequest($request);

            $markee->update([
                'header' => $validated['header'],
                'content' => $validated['content'],
                'status' => $validated['status'] ?? $markee->status,
            ]);

            return redirect()->route('markees.index')
                ->with('success', 'Markee updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Markee not found for update: {$id}");
            return redirect()->route('markees.index')
                ->with('error', 'Markee not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Markee update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('markees.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update markee. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $markee = Markee::findOrFail($request->id);
            $markee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Markee deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Markee not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Markee not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Markee deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete markee. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate markee request data
     */
    protected function validateMarkeeRequest(Request $request): array
    {
        return $request->validate([
            'header' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10|max:5000',
            'status' => 'sometimes|boolean',
        ]);
    }

    /**
     * Apply sorting to the query
     */
    protected function applySorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'header':
                $query->orderBy('header', $direction);
                break;
                
            case 'status':
                $query->orderBy('status', $direction);
                break;
                
            case 'created':
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}