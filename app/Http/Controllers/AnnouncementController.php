<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
            $query = Announcement::with('user');

            if ($request->has('search') && $request->search != '') {
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

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'title':
                        $query->orderBy('title', $direction);
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
            $announcements = $query->paginate($perPage);

            $transformedAnnouncements = $announcements->getCollection()->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'is_published' => $announcement->is_published,
                    'author' => $announcement->user->first_name . ' ' . $announcement->user->last_name,
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