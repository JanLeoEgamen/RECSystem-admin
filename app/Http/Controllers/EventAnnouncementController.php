<?php

namespace App\Http\Controllers;

use App\Models\EventAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class EventAnnouncementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view event announcements', only: ['index']),
            new Middleware('permission:edit event announcements', only: ['edit', 'update']),
            new Middleware('permission:create event announcements', only: ['create', 'store']),
            new Middleware('permission:delete event announcements', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = EventAnnouncement::with('user:id,first_name,last_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('event_name', 'like', '%' . $request->search . '%')
                          ->orWhere('caption', 'like', '%' . $request->search . '%')
                          ->orWhere('year', 'like', '%' . $request->search . '%')
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
                $announcements = $query->paginate($perPage);

                $transformedAnnouncements = $announcements->getCollection()->map(function ($announcement) {
                    return [
                        'id' => $announcement->id,
                        'event_name' => $announcement->event_name,
                        'event_date' => Carbon::parse($announcement->event_date)->format('M d, Y'),
                        'image_url' => $announcement->image
                            ? asset('images/'.$announcement->image)
                            : null,

                        'author' => $announcement->user->first_name ?? 'Unknown' . ' ' . $announcement->user->last_name ?? '',
                        'status' => $announcement->status ? 'Active' : 'Inactive',
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

            return view('event-announcements.list');

        } catch (\Exception $e) {
            Log::error('Event announcement index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load event announcements'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load event announcements. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('event-announcements.create');
        } catch (\Exception $e) {
            Log::error('Event announcement create form error: ' . $e->getMessage());
            return redirect()->route('event-announcements.index')
                ->with('error', 'Failed to load event announcement creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateEventAnnouncementRequest($request);

            $eventAnnouncement = new EventAnnouncement();
            $eventAnnouncement->event_name = $validated['event_name'];
            $eventAnnouncement->event_date = Carbon::parse($validated['event_date']);
            $eventAnnouncement->year = $validated['year'];
            $eventAnnouncement->caption = $validated['caption'];
            $eventAnnouncement->user_id = $request->user()->id;
            $eventAnnouncement->status = $validated['status'] ?? true;

            if ($request->hasFile('image')) {
                $eventAnnouncement->image = $this->storeEventImage($request->file('image'));
            }

            $eventAnnouncement->save();

            return redirect()->route('event-announcements.index')
                ->with('success', 'Event announcement added successfully');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('Event announcement store error: ' . $e->getMessage());
            return redirect()->route('event-announcements.create')
                ->withInput()
                ->with('error', 'Failed to create event announcement. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $eventAnnouncement = EventAnnouncement::findOrFail($id);
            
            // Ensure event_date is a Carbon instance
            if (!$eventAnnouncement->event_date instanceof Carbon) {
                $eventAnnouncement->event_date = Carbon::parse($eventAnnouncement->event_date);
            }

            return view('event-announcements.edit', compact('eventAnnouncement'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Event announcement not found for editing: {$id}");
            return redirect()->route('event-announcements.index')
                ->with('error', 'Event announcement not found.');

        } catch (\Exception $e) {
            Log::error("Event announcement edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('event-announcements.index')
                ->with('error', 'Failed to load event announcement edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $eventAnnouncement = EventAnnouncement::findOrFail($id);
            $validated = $this->validateEventAnnouncementRequest($request, false);

            $eventAnnouncement->event_name = $validated['event_name'];
            $eventAnnouncement->event_date = Carbon::parse($validated['event_date']);
            $eventAnnouncement->year = $validated['year'];
            $eventAnnouncement->caption = $validated['caption'];
            $eventAnnouncement->status = $validated['status'] ?? $eventAnnouncement->status;

            if ($request->hasFile('image')) {
                $this->deleteEventImage($eventAnnouncement->image);
                $eventAnnouncement->image = $this->storeEventImage($request->file('image'));
            }

            $eventAnnouncement->save();

            return redirect()->route('event-announcements.index')
                ->with('success', 'Event announcement updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Event announcement not found for update: {$id}");
            return redirect()->route('event-announcements.index')
                ->with('error', 'Event announcement not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Event announcement update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('event-announcements.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update event announcement. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $eventAnnouncement = EventAnnouncement::findOrFail($request->id);
            
            // Delete associated image
            $this->deleteEventImage($eventAnnouncement->image);
            
            $eventAnnouncement->delete();

            return response()->json([
                'status' => true,
                'message' => 'Event announcement deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Event announcement not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Event announcement not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Event announcement deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete event announcement. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate event announcement request data
     */
    protected function validateEventAnnouncementRequest(Request $request, bool $requireImage = true): array
    {
        $rules = [
            'event_name' => 'required|string|min:3|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'year' => 'required|integer|digits:4|min:' . (date('Y') - 1) . '|max:' . (date('Y') + 5),
            'caption' => 'required|string|min:10|max:1000',
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
            case 'event_name':
                $query->orderBy('event_name', $direction);
                break;
                
            case 'event_date':
                $query->orderBy('event_date', $direction);
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
     * Store event image and return path
     */
    protected function storeEventImage($imageFile): string
    {
        return $imageFile->store('event-announcements', 'public');
    }

    /**
     * Delete event image if exists
     */
    protected function deleteEventImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}