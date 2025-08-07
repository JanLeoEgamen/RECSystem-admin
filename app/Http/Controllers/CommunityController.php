<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CommunityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view communities', only: ['index']),
            new Middleware('permission:edit communities', only: ['edit', 'update']),
            new Middleware('permission:create communities', only: ['create', 'store']),
            new Middleware('permission:delete communities', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Community::with('user:id,first_name,last_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('content', 'like', '%' . $request->search . '%')
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
                $communities = $query->paginate($perPage);

                $transformedCommunities = $communities->getCollection()->map(function ($community) {
                    return [
                        'id' => $community->id,
                        'content' => Str::limit($community->content, 50),
                        'image_url' => $community->image 
                        ? asset('images/'.$community->image)
                        : null,
                        'author' => ($community->user->first_name ?? 'Unknown') . ' ' . ($community->user->last_name ?? ''),
                        'status' => $community->status ? 'Active' : 'Inactive',
                        'created_at' => $community->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedCommunities,
                    'current_page' => $communities->currentPage(),
                    'last_page' => $communities->lastPage(),
                    'from' => $communities->firstItem(),
                    'to' => $communities->lastItem(),
                    'total' => $communities->total(),
                ]);
            }

            return view('communities.list');

        } catch (\Exception $e) {
            Log::error('Community index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load communities'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load communities. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('communities.create');
        } catch (\Exception $e) {
            Log::error('Community create form error: ' . $e->getMessage());
            return redirect()->route('communities.index')
                ->with('error', 'Failed to load community creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateCommunityRequest($request);

            $community = new Community();
            $community->content = $validated['content'];
            $community->user_id = $request->user()->id;
            $community->status = $validated['status'] ?? true;

            if ($request->hasFile('image')) {
                $community->image = $this->storeCommunityImage($request->file('image'));
            }

            $community->save();

            return redirect()->route('communities.index')
                ->with('success', 'Community content added successfully');

        } catch (ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions

        } catch (\Exception $e) {
            Log::error('Community store error: ' . $e->getMessage());
            return redirect()->route('communities.create')
                ->withInput()
                ->with('error', 'Failed to create community content. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $community = Community::findOrFail($id);
            return view('communities.edit', compact('community'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Community content not found for editing: {$id}");
            return redirect()->route('communities.index')
                ->with('error', 'Community content not found.');

        } catch (\Exception $e) {
            Log::error("Community edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('communities.index')
                ->with('error', 'Failed to load community edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $community = Community::findOrFail($id);
            $validated = $this->validateCommunityRequest($request, false);

            $community->content = $validated['content'];
            $community->status = $validated['status'] ?? $community->status;

            if ($request->hasFile('image')) {
                $this->deleteCommunityImage($community->image);
                $community->image = $this->storeCommunityImage($request->file('image'));
            }

            $community->save();

            return redirect()->route('communities.index')
                ->with('success', 'Community content updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Community content not found for update: {$id}");
            return redirect()->route('communities.index')
                ->with('error', 'Community content not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Community update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('communities.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update community content. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $community = Community::findOrFail($request->id);
            
            // Delete associated image
            $this->deleteCommunityImage($community->image);
            
            $community->delete();

            return response()->json([
                'status' => true,
                'message' => 'Community content deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Community content not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Community content not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Community deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete community content. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate community request data
     */
    protected function validateCommunityRequest(Request $request, bool $requireImage = true): array
    {
        $rules = [
            'content' => 'required|string|min:10|max:5000',
            'status' => 'sometimes|boolean',
            'image' => ($requireImage ? 'required|' : 'sometimes|') . 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        return $request->validate($rules);
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
            case 'content':
                $query->orderBy('content', $direction);
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
     * Store community image and return path
     */
    protected function storeCommunityImage($imageFile): string
    {
        return $imageFile->store('communities', 'public');
    }

    /**
     * Delete community image if exists
     */
    protected function deleteCommunityImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}