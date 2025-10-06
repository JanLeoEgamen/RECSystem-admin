<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Member;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view announcements', only: ['index']),
            new Middleware('permission:edit announcements', only: ['edit', 'update']),
            new Middleware('permission:create announcements', only: ['create', 'store']),
            new Middleware('permission:delete announcements', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Announcement::with('user');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%$search%")
                          ->orWhere('content', 'like', "%$search%")
                          ->orWhereHas('user', function($q) use ($search) {
                              $q->where('first_name', 'like', "%$search%")
                                ->orWhere('last_name', 'like', "%$search%");
                          });
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $this->applySorting($query, $request->sort, $request->direction);
                } else {
                    $query->orderBy('created_at', 'desc');
                }

                // Pagination
                $perPage = $request->input('perPage', 10);
                $announcements = $query->paginate($perPage);

                $transformedAnnouncements = $announcements->getCollection()->map(function ($announcement) {
                    return [
                        'id' => $announcement->id,
                        'title' => $announcement->title,
                        'is_published' => $announcement->is_published,
                        'author' => ($announcement->user->first_name ?? 'Unknown') . ' ' . ($announcement->user->last_name ?? ''),
                        'created_at' => $announcement->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedAnnouncements,
                    'current_page' => $announcements->currentPage(),
                    'last_page' => $announcements->lastPage(),
                    'from' => $announcements->firstItem(),
                    'to' => $announcements->lastItem(),
                    'total' => $announcements->total(),
                ]);
            }
            
            return view('announcements.list');
        } catch (\Exception $e) {
            Log::error('Announcement index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load announcements'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load announcements. Please try again.');
        }
    }

public function create()
{
    try {
        $user = auth()->user();
        
        // Get members based on user's bureau/section access
        $query = Member::with(['section']);
        
        if (!$user->can('view all members')) {
            $sectionIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNotNull('section_id')
                ->pluck('section_id');
            
            $bureauIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNull('section_id')
                ->pluck('bureau_id');
            
            $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
            
            $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
            
            $query->whereIn('section_id', $allSectionIds);
        }

        $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
        
        // Get sections for filter dropdown
        $sectionsQuery = Section::with('bureau');
        if (!$user->can('view all members')) {
            $sectionsQuery->whereIn('id', $allSectionIds);
        }
        $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);

        return view('announcements.create', compact('members', 'sections'));

    } catch (\Exception $e) {
        Log::error('Announcement create form error: ' . $e->getMessage());
        return redirect()->route('announcements.index')
            ->with('error', 'Failed to load announcement creation form. Please try again.');
    }
}

    public function store(Request $request)
    {
        try {
            $validated = $this->validateAnnouncement($request);

            $announcement = Announcement::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'is_published' => $validated['is_published'] ?? false,
                'user_id' => $request->user()->id,
            ]);

            $announcement->members()->sync($validated['members']);

            return redirect()->route('announcements.index')
                ->with('success', 'Announcement created successfully');

        } catch (ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions

        } catch (\Exception $e) {
            Log::error('Announcement store error: ' . $e->getMessage());
            return redirect()->route('announcements.create')
                ->withInput()
                ->with('error', 'Failed to create announcement. Please try again.');
        }
    }

public function edit($id)
{
    try {
        $user = auth()->user();
        $announcement = Announcement::with('members:id')->findOrFail($id);
        
        // Get members based on user's bureau/section access (same logic as create method)
        $query = Member::with(['section']);
        
        if (!$user->can('view all members')) {
            $sectionIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNotNull('section_id')
                ->pluck('section_id');
            
            $bureauIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNull('section_id')
                ->pluck('bureau_id');
            
            $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
            
            $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
            
            $query->whereIn('section_id', $allSectionIds);
        }

        $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
        
        // Get sections for filter dropdown
        $sectionsQuery = Section::with('bureau');
        if (!$user->can('view all members')) {
            $sectionsQuery->whereIn('id', $allSectionIds);
        }
        $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);
        
        return view('announcements.edit', compact('announcement', 'members', 'sections'));

    } catch (ModelNotFoundException $e) {
        Log::warning("Announcement not found for editing: {$id}");
        return redirect()->route('announcements.index')
            ->with('error', 'Announcement not found.');

    } catch (\Exception $e) {
        Log::error('Announcement edit form error: ' . $e->getMessage());
        return redirect()->route('announcements.index')
            ->with('error', 'Failed to load announcement edit form. Please try again.');
    }
}

    public function update(Request $request, $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $validated = $this->validateAnnouncement($request);

            $announcement->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'is_published' => $validated['is_published'] ?? $announcement->is_published,
            ]);

            $announcement->members()->sync($validated['members']);

            return redirect()->route('announcements.index')
                ->with('success', 'Announcement updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Announcement not found for update: {$id}");
            return redirect()->route('announcements.index')
                ->with('error', 'Announcement not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Announcement update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('announcements.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update announcement. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $announcement = Announcement::findOrFail($request->id);
            $announcement->delete();

            return response()->json([
                'status' => true,
                'message' => 'Announcement deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Announcement not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Announcement not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Announcement deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete announcement. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate announcement request data
     */
    protected function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);
    }

    /**
     * Apply sorting to the query
     */
    protected function applySorting($query, string $sort, string $direction): void
    {
        $validDirections = ['asc', 'desc'];
        $direction = in_array(strtolower($direction), $validDirections) ? $direction : 'desc';

        switch ($sort) {
            case 'title':
                $query->orderBy('title', $direction);
                break;
                
            case 'is_published':
                $query->orderBy('is_published', $direction);
                break;
                
            case 'created':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}