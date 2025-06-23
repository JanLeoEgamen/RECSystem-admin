<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
            $data = Event::with('user')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('view event registrations')) {
                        $buttons .= '<a href="'.route('events.registrations', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Registrations">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('edit events')) {
                        $buttons .= '<a href="'.route('events.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete events')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteEvent('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('is_published', function($row) {
                    return $row->is_published 
                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>';
                })
                ->editColumn('start_date', function($row) {
                    return $row->start_date->format('M d, Y h:i A');
                })
                ->editColumn('end_date', function($row) {
                    return $row->end_date->format('M d, Y h:i A');
                })
                ->addColumn('registrations_count', function($row) {
                    return $row->registrations()->count() . ($row->capacity ? '/'.$row->capacity : '');
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['action', 'is_published'])
                ->make(true);
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