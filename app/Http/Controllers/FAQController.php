<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class FAQController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view faqs', only: ['index']),
            new Middleware('permission:edit faqs', only: ['edit', 'update']),
            new Middleware('permission:create faqs', only: ['create', 'store']),
            new Middleware('permission:delete faqs', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = FAQ::with('user:id,first_name,last_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('question', 'like', '%' . $request->search . '%')
                          ->orWhere('answer', 'like', '%' . $request->search . '%')
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
                $faqs = $query->paginate($perPage);

                $transformedFAQs = $faqs->getCollection()->map(function ($faq) {
                    return [
                        'id' => $faq->id,
                        'question' => Str::limit($faq->question, 50),
                        'answer' => Str::limit($faq->answer, 50),
                        'author' => $faq->user->first_name ?? 'Unknown' . ' ' . $faq->user->last_name ?? '',
                        'status' => $faq->status ? 'Active' : 'Inactive',
                        'created_at' => $faq->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedFAQs,
                    'current_page' => $faqs->currentPage(),
                    'last_page' => $faqs->lastPage(),
                    'from' => $faqs->firstItem(),
                    'to' => $faqs->lastItem(),
                    'total' => $faqs->total(),
                ]);
            }

            return view('faqs.list');

        } catch (\Exception $e) {
            Log::error('FAQ index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load FAQs'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load FAQs. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('faqs.create');
        } catch (\Exception $e) {
            Log::error('FAQ create form error: ' . $e->getMessage());
            return redirect()->route('faqs.index')
                ->with('error', 'Failed to load FAQ creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateFAQRequest($request);

            $faq = FAQ::create([
                'question' => $validated['question'],
                'answer' => $validated['answer'],
                'status' => $validated['status'] ?? true,
                'user_id' => $request->user()->id,
            ]);

            return redirect()->route('faqs.index')
                ->with('success', 'FAQ added successfully');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('FAQ store error: ' . $e->getMessage());
            return redirect()->route('faqs.create')
                ->withInput()
                ->with('error', 'Failed to create FAQ. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            return view('faqs.edit', compact('faq'));

        } catch (ModelNotFoundException $e) {
            Log::warning("FAQ not found for editing: {$id}");
            return redirect()->route('faqs.index')
                ->with('error', 'FAQ not found.');

        } catch (\Exception $e) {
            Log::error("FAQ edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('faqs.index')
                ->with('error', 'Failed to load FAQ edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $validated = $this->validateFAQRequest($request);

            $faq->update([
                'question' => $validated['question'],
                'answer' => $validated['answer'],
                'status' => $validated['status'] ?? $faq->status,
            ]);

            return redirect()->route('faqs.index')
                ->with('success', 'FAQ updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("FAQ not found for update: {$id}");
            return redirect()->route('faqs.index')
                ->with('error', 'FAQ not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("FAQ update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('faqs.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update FAQ. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $faq = FAQ::findOrFail($request->id);
            $faq->delete();

            return response()->json([
                'status' => true,
                'message' => 'FAQ deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("FAQ not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'FAQ not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("FAQ deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete FAQ. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate FAQ request data
     */
    protected function validateFAQRequest(Request $request): array
    {
        return $request->validate([
            'question' => 'required|string|min:3|max:255',
            'answer' => 'required|string|min:10|max:5000',
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
            case 'question':
                $query->orderBy('question', $direction);
                break;
                
            case 'status':
                $query->orderBy('status', $direction);
                break;
                
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}