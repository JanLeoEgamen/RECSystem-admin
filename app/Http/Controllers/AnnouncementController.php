<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view announcements', only: ['index']),
            new Middleware('permission:edit announcements', only: ['edit']),
            new Middleware('permission:create announcements', only: ['create']),
            new Middleware('permission:delete announcements', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Announcement::with('user')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('edit announcements')) {
                        $buttons .= '<a href="'.route('announcements.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete announcements')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteAnnouncement('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
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
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d M, y');
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['action', 'is_published'])
                ->make(true);
        }
        
        return view('announcements.list');
    }

    public function create()
    {
        $members = Member::all();
        return view('announcements.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('announcements.create')
                ->withInput()
                ->withErrors($validator);
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $request->is_published ?? false,
            'user_id' => $request->user()->id,
        ]);

        $announcement->members()->sync($request->members);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    public function edit($id)
    {
        $announcement = Announcement::with('members')->findOrFail($id);
        $members = Member::all();
        return view('announcements.edit', compact('announcement', 'members'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('announcements.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $request->is_published ?? $announcement->is_published,
        ]);

        $announcement->members()->sync($request->members);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $announcement = Announcement::findOrFail($id);

        if ($announcement == null) {
            session()->flash('error', 'Announcement not found.');
            return response()->json(['status' => false]);
        }

        $announcement->delete();

        session()->flash('success', 'Announcement deleted successfully.');
        return response()->json(['status' => true]);
    }
}