<?php

namespace App\Http\Controllers;

use App\Models\EventAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventAnnouncementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view event announcements', only: ['index']),
            new Middleware('permission:edit event announcements', only: ['edit']),
            new Middleware('permission:create event announcements', only: ['create']),
            new Middleware('permission:delete event announcements', only: ['destroy']),
        ];
    }

    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = EventAnnouncement::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('event_name', 'like', "%$search%")
                  ->orWhere('caption', 'like', "%$search%")
                  ->orWhere('year', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                  });
            });
        }

        if ($request->has('sort') && $request->has('direction')) {
            $sort = $request->sort;
            $direction = $request->direction;
            
            switch ($sort) {
                case 'event_name':
                    $query->orderBy('event_name', $direction);
                    break;
                    
                case 'event_date':
                    $query->orderByRaw('STR_TO_DATE(event_date, "%Y-%m-%d") ' . $direction);
                    break;

                    
                case 'status':
                    $query->orderBy('status', $direction === 'asc' ? 'asc' : 'desc');
                    break;
                    
                case 'created_at':
                    $query->orderBy('created_at', $direction);
                    break;
                    
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

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
                'author' => $announcement->user->first_name . ' ' . $announcement->user->last_name,
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
}

    public function create()
    {
        return view('event-announcements.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|min:3',
            'event_date' => 'required|date',
            'year' => 'required|numeric',
            'caption' => 'required|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event-announcements.create')->withInput()->withErrors($validator);
        }

        $eventAnnouncement = new EventAnnouncement();
        $eventAnnouncement->event_name = $request->event_name;
        $eventAnnouncement->event_date = \Carbon\Carbon::parse($request->event_date);
        $eventAnnouncement->year = $request->year;
        $eventAnnouncement->caption = $request->caption;
        $eventAnnouncement->user_id = $request->user()->id;
        $eventAnnouncement->status = $request->status ?? true;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event-announcements', 'public');
            $eventAnnouncement->image = $imagePath;
        }

        $eventAnnouncement->save();

        return redirect()->route('event-announcements.index')->with('success', 'Event announcement added successfully');
    }

    public function edit(string $id)
    {
        
        $eventAnnouncement = EventAnnouncement::findOrFail($id);
            // Convert event_date to Carbon instance if it's a string
        if (is_string($eventAnnouncement->event_date)) {
            $eventAnnouncement->event_date = \Carbon\Carbon::parse($eventAnnouncement->event_date);
        }

        return view('event-announcements.edit', [
            'eventAnnouncement' => $eventAnnouncement
        ]);
    }

    public function update(Request $request, string $id)
    {
        $eventAnnouncement = EventAnnouncement::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|min:3',
            'event_date' => 'required|date',
            'year' => 'required|numeric',
            'caption' => 'required|min:10',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event-announcements.edit', $id)->withInput()->withErrors($validator);
        }

        $eventAnnouncement->event_name = $request->event_name;
        $eventAnnouncement->event_date = \Carbon\Carbon::parse($request->event_date);
        $eventAnnouncement->year = $request->year;
        $eventAnnouncement->caption = $request->caption;
        $eventAnnouncement->status = $request->status ?? $eventAnnouncement->status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($eventAnnouncement->image) {
                Storage::disk('public')->delete($eventAnnouncement->image);
            }
            
            $imagePath = $request->file('image')->store('event-announcements', 'public');
            $eventAnnouncement->image = $imagePath;
        }

        $eventAnnouncement->save();

        return redirect()->route('event-announcements.index')->with('success', 'Event announcement updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $eventAnnouncement = EventAnnouncement::findOrFail($id);

        if ($eventAnnouncement == null) {
            session()->flash('error', 'Event announcement not found.');
            return response()->json([
                'status' => false
            ]);
        }

        // Delete image if exists
        if ($eventAnnouncement->image) {
            Storage::disk('public')->delete($eventAnnouncement->image);
        }

        $eventAnnouncement->delete();

        session()->flash('success', 'Event announcement deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

}
