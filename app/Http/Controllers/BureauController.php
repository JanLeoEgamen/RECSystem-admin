<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BureauController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view bureaus', only: ['index']),
            new Middleware('permission:edit bureaus', only: ['edit', 'update']),
            new Middleware('permission:create bureaus', only: ['create', 'store']),
            new Middleware('permission:delete bureaus', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Bureau::query();

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where('bureau_name', 'like', '%' . $request->search . '%');
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $bureaus = $query->paginate($perPage);

                $transformedBureaus = $bureaus->getCollection()->map(function ($bureau) {
                    return [
                        'id' => $bureau->id,
                        'bureau_name' => $bureau->bureau_name,
                        'created_at' => $bureau->created_at->format('d M, Y'),
                        'can_edit' => request()->user()->can('edit bureaus'),
                        'can_delete' => request()->user()->can('delete bureaus'),
                    ];
                });

                return response()->json([
                    'data' => $transformedBureaus,
                    'current_page' => $bureaus->currentPage(),
                    'last_page' => $bureaus->lastPage(),
                    'from' => $bureaus->firstItem(),
                    'to' => $bureaus->lastItem(),
                    'total' => $bureaus->total(),
                ]);
            }

            return view('bureaus.list');

        } catch (\Exception $e) {
            Log::error('Bureau index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load bureaus'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load bureaus. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('bureaus.create');
        } catch (\Exception $e) {
            Log::error('Bureau create form error: ' . $e->getMessage());
            return redirect()->route('bureaus.index')
                ->with('error', 'Failed to load bureau creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateBureauRequest($request);

            $bureau = Bureau::create([
                'bureau_name' => $validated['bureau_name'],
                'user_id' => $request->user()->id,
            ]);

            return redirect()->route('bureaus.index')
                ->with('success', 'Bureau added successfully');

        } catch (ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions

        } catch (\Exception $e) {
            Log::error('Bureau store error: ' . $e->getMessage());
            return redirect()->route('bureaus.create')
                ->withInput()
                ->with('error', 'Failed to create bureau. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $bureau = Bureau::findOrFail($id);
            return view('bureaus.edit', compact('bureau'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Bureau not found for editing: {$id}");
            return redirect()->route('bureaus.index')
                ->with('error', 'Bureau not found.');

        } catch (\Exception $e) {
            Log::error("Bureau edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('bureaus.index')
                ->with('error', 'Failed to load bureau edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $bureau = Bureau::findOrFail($id);
            $validated = $this->validateBureauRequest($request, $bureau->id);

            $bureau->update([
                'bureau_name' => $validated['bureau_name'],
            ]);

            return redirect()->route('bureaus.index')
                ->with('success', 'Bureau updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Bureau not found for update: {$id}");
            return redirect()->route('bureaus.index')
                ->with('error', 'Bureau not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Bureau update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('bureaus.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update bureau. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $bureau = Bureau::findOrFail($request->id);
            $bureau->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Bureau deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Bureau not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Bureau not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Bureau deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete bureau. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate bureau request data
     */
    protected function validateBureauRequest(Request $request, $id = null): array
    {
        $rules = [
            'bureau_name' => [
                'required',
                'min:2',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
                'unique:bureaus,bureau_name' . ($id ? ",{$id}" : '')
            ]
        ];

        $messages = [
            'bureau_name.regex' => 'Bureau name may only contain letters, spaces and hyphens'
        ];

        return $request->validate($rules, $messages);
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
            case 'bureau_name':
                $query->orderBy('bureau_name', $direction);
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