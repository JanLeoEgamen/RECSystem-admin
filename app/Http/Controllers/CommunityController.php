<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CommunityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view communities', only: ['index']),
            new Middleware('permission:edit communities', only: ['edit']),
            new Middleware('permission:create communities', only: ['create']),
            new Middleware('permission:delete communities', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Community::with('user');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('content', 'like', "%$search%")
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
                    case 'content':
                        $query->orderBy('content', $direction);
                        break;
                        
                    case 'status':
                        $query->orderBy('status', $direction === 'asc' ? 'asc' : 'desc');
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
            $communities = $query->paginate($perPage);

            $transformedCommunities = $communities->getCollection()->map(function ($community) {
                return [
                    'id' => $community->id,
                    'content' => Str::limit($community->content, 50),
                    'image_url' => $community->image 
                        ? asset('images/'.$community->image)
                        : null,
                    'author' => $community->user->first_name . ' ' . $community->user->last_name,
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
    }

    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('communities.create')->withInput()->withErrors($validator);
        }

        $community = new Community();
        $community->content = $request->content;
        $community->user_id = $request->user()->id;
        $community->status = $request->status ?? true;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('communities', 'public');
            $community->image = $imagePath;
        }

        $community->save();

        return redirect()->route('communities.index')->with('success', 'Community content added successfully');
    }

    public function edit(string $id)
    {
        $community = Community::findOrFail($id);
        return view('communities.edit', [
            'community' => $community
        ]);
    }

    public function update(Request $request, string $id)
    {
        $community = Community::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'content' => 'required|min:10',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('communities.edit', $id)->withInput()->withErrors($validator);
        }

        $community->content = $request->content;
        $community->status = $request->status ?? $community->status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            
            $imagePath = $request->file('image')->store('communities', 'public');
            $community->image = $imagePath;
        }

        $community->save();

        return redirect()->route('communities.index')->with('success', 'Community content updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $community = Community::findOrFail($id);

        if ($community == null) {
            session()->flash('error', 'Community content not found.');
            return response()->json([
                'status' => false
            ]);
        }

        // Delete image if exists
        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }

        $community->delete();

        session()->flash('success', 'Community content deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}