<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only: ['index']),
            new Middleware('permission:edit articles', only: ['edit', 'update']),
            new Middleware('permission:create articles', only: ['create', 'store']),
            new Middleware('permission:delete articles', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Article::with('user:id,first_name,last_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%$search%")
                          ->orWhere('author', 'like', "%$search%")
                          ->orWhere('content', 'like', "%$search%")
                          ->orWhereHas('user', function($q) use ($search) {
                              $q->where('first_name', 'like', "%$search%")
                                ->orWhere('last_name', 'like', "%$search%");
                          });
                    });
                }

                // Sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $articles = $query->paginate($perPage);

                $transformedArticles = $articles->getCollection()->map(function ($article) {
                    return [
                        'id' => $article->id,
                        'title' => $article->title,
                        'image_url' => $article->image 
                        ? asset('images/'.$article->image)
                        : null,
                        'author' => $article->author,
                        'uploaded_by' => trim($article->user->first_name ?? 'Unknown') . ' ' . trim($article->user->last_name ?? ''),
                        'status' => $article->status ? 'Active' : 'Inactive',
                        'created_at' => $article->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedArticles,
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                    'from' => $articles->firstItem(),
                    'to' => $articles->lastItem(),
                    'total' => $articles->total(),
                ]);
            }

            return view('articles.list');

        } catch (\Exception $e) {
            Log::error('Article index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load articles'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load articles. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('articles.create');
        } catch (\Exception $e) {
            Log::error('Article create form error: ' . $e->getMessage());
            return redirect()->route('articles.index')
                ->with('error', 'Failed to load article creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateArticleRequest($request);

            $article = new Article();
            $article->title = $validated['title'];
            $article->content = $validated['content'];
            $article->author = $validated['author'];
            $article->user_id = $request->user()->id;
            $article->status = $validated['status'] ?? true;
            
            if ($request->hasFile('image')) {
                $article->image = $this->storeArticleImage($request->file('image'));
            }

            $article->save();

            return redirect()->route('articles.index')
                ->with('success', 'Article added successfully');

        } catch (ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions

        } catch (\Exception $e) {
            Log::error('Article store error: ' . $e->getMessage());
            return redirect()->route('articles.create')
                ->withInput()
                ->with('error', 'Failed to create article. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $article = Article::findOrFail($id);
            return view('articles.edit', compact('article'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Article not found for editing: {$id}");
            return redirect()->route('articles.index')
                ->with('error', 'Article not found.');

        } catch (\Exception $e) {
            Log::error("Article edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('articles.index')
                ->with('error', 'Failed to load article edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $article = Article::findOrFail($id);
            $validated = $this->validateArticleRequest($request);

            $article->title = $validated['title'];
            $article->author = $validated['author'];
            $article->content = $validated['content'];
            $article->status = $validated['status'] ?? $article->status;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                $this->deleteArticleImage($article->image);
                $article->image = $this->storeArticleImage($request->file('image'));
            }

            $article->save();

            return redirect()->route('articles.index')
                ->with('success', 'Article updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Article not found for update: {$id}");
            return redirect()->route('articles.index')
                ->with('error', 'Article not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Article update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('articles.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update article. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $article = Article::findOrFail($request->id);
            
            // Delete associated image
            $this->deleteArticleImage($article->image);
            
            $article->delete();

            return response()->json([
                'status' => true,
                'message' => 'Article deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Article not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Article not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Article deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete article. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate article request data
     */
    protected function validateArticleRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'status' => 'sometimes|boolean',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            case 'title':
                $query->orderBy('title', $direction);
                break;
                
            case 'author':
                $query->orderBy('author', $direction);
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

    /**
     * Store article image and return path
     */
    protected function storeArticleImage($imageFile): string
    {
        return $imageFile->store('articles', 'public');
    }

    /**
     * Delete article image if exists
     */
    protected function deleteArticleImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}