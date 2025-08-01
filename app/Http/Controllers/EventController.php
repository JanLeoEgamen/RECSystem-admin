<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view events', only: ['index']),
            new Middleware('permission:edit events', only: ['edit']),
            new Middleware('permission:create events', only: ['create']),
            new Middleware('permission:delete events', only: ['destroy']),
            new Middleware('permission:view event registrations', only: ['registrations']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Event::with(['user', 'registrations']);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('location', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%")
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
                    case 'title':
                        $query->orderBy('title', $direction);
                        break;
                        
                    case 'start_date':
                        $query->orderBy('start_date', $direction);
                        break;
                        
                    case 'is_published':
                        $query->orderBy('is_published', $direction === 'asc' ? 'asc' : 'desc');
                        break;
                        
                    case 'created':
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
            $events = $query->paginate($perPage);

            $transformedEvents = $events->getCollection()->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start_date' => $event->start_date->format('M d, Y h:i A'),
                    'end_date' => $event->end_date->format('M d, Y h:i A'),
                    'location' => $event->location,
                    'is_published' => $event->is_published,
                    'author' => $event->user->first_name . ' ' . $event->user->last_name,
                    'registrations_count' => $event->registrations->count() . ($event->capacity ? '/'.$event->capacity : ''),
                    'created_at' => $event->created_at->format('d M, Y'),
                    'can_view_registrations' => request()->user()->can('view event registrations')
                ];
            });

            return response()->json([
                'data' => $transformedEvents,
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem(),
                'total' => $events->total(),
            ]);
        }
        
        return view('events.list');
    }

    public function create()
    {
        $members = Member::all();
        return view('events.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required',
            'capacity' => 'nullable|integer|min:1',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('events.create')
                ->withInput()
                ->withErrors($validator);
        }

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_published' => $request->is_published ?? false,
            'user_id' => $request->user()->id,
        ]);

        $event->members()->sync($request->members);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully');
    }

    public function edit($id)
    {
        $event = Event::with('members')->findOrFail($id);
        $members = Member::all();
        return view('events.edit', compact('event', 'members'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required',
            'capacity' => 'nullable|integer|min:1',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('events.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_published' => $request->is_published ?? $event->is_published,
        ]);

        $event->members()->sync($request->members);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $event = Event::findOrFail($id);

        if ($event == null) {
            session()->flash('error', 'Event not found.');
            return response()->json(['status' => false]);
        }

        $event->delete();

        session()->flash('success', 'Event deleted successfully.');
        return response()->json(['status' => true]);
    }

    public function registrations($id)
    {
        $event = Event::with(['registrations.member'])->findOrFail($id);
        return view('events.registrations', compact('event'));
    }

    public function updateRegistrationStatus(Request $request, $eventId, $registrationId)
    {
        $registration = EventRegistration::where('event_id', $eventId)
            ->findOrFail($registrationId);
            
        $request->validate([
            'status' => 'required|in:registered,attended,cancelled',
            'notes' => 'nullable|string'
        ]);
        
        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);
        
        return redirect()->back()
            ->with('success', 'Registration status updated successfully');
    }

    public function destroyRegistration(Request $request, $eventId, $registrationId)
    {
        $registration = EventRegistration::where('event_id', $eventId)
            ->findOrFail($registrationId);
            
        $registration->delete();
        
        return redirect()->back()
            ->with('success', 'Registration deleted successfully');
    }
}