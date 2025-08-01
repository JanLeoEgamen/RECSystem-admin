<?php

namespace App\Http\Controllers;

use App\Models\MainCarousel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainCarouselController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view main carousels', only: ['index']),
            new Middleware('permission:edit main carousels', only: ['edit']),
            new Middleware('permission:create main carousels', only: ['create']),
            new Middleware('permission:delete main carousels', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MainCarousel::with('user');

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
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $carousels = $query->paginate($perPage);

            $transformedCarousels = $carousels->getCollection()->map(function ($carousel) {
                return [
                    'id' => $carousel->id,
                    'title' => $carousel->title,
                    'content' => Str::limit($carousel->content, 50),
                    'image' => $carousel->image 
                        ? '<img src="'.asset('storage/'.$carousel->image).'" alt="Carousel Image" class="h-20 w-20 object-cover">'
                        : 'No Image',
                    'author' => $carousel->user->first_name . ' ' . $carousel->user->last_name,
                    'status' => $carousel->status 
                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>'
                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Inactive</span>',
                    'created_at' => $carousel->created_at->format('d M, Y'),
                ];
            });

            return response()->json([
                'data' => $transformedCarousels,
                'current_page' => $carousels->currentPage(),
                'last_page' => $carousels->lastPage(),
                'from' => $carousels->firstItem(),
                'to' => $carousels->lastItem(),
                'total' => $carousels->total(),
            ]);
        }

        return view('main-carousels.list');
    }

    public function create()
    {
        return view('main-carousels.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('main-carousels.create')->withInput()->withErrors($validator);
        }

        $mainCarousel = new MainCarousel();
        $mainCarousel->title = $request->title;
        $mainCarousel->content = $request->content;
        $mainCarousel->user_id = $request->user()->id;
        $mainCarousel->status = $request->status ?? true;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('main-carousels', 'public');
            $mainCarousel->image = $imagePath;
        }

        $mainCarousel->save();

        return redirect()->route('main-carousels.index')->with('success', 'Main carousel item added successfully');
    }

    public function edit(string $id)
    {
        $mainCarousel = MainCarousel::findOrFail($id);
        return view('main-carousels.edit', [
            'mainCarousel' => $mainCarousel
        ]);
    }

    public function update(Request $request, string $id)
    {
        $mainCarousel = MainCarousel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('main-carousels.edit', $id)->withInput()->withErrors($validator);
        }

        $mainCarousel->title = $request->title;
        $mainCarousel->content = $request->content;
        $mainCarousel->status = $request->status ?? $mainCarousel->status;

        if ($request->hasFile('image')) {
            if ($mainCarousel->image) {
                Storage::disk('public')->delete($mainCarousel->image);
            }
            
            $imagePath = $request->file('image')->store('main-carousels', 'public');
            $mainCarousel->image = $imagePath;
        }

        $mainCarousel->save();

        return redirect()->route('main-carousels.index')->with('success', 'Main carousel item updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $mainCarousel = MainCarousel::findOrFail($id);

        if ($mainCarousel == null) {
            session()->flash('error', 'Main carousel item not found.');
            return response()->json([
                'status' => false
            ]);
        }

        if ($mainCarousel->image) {
            Storage::disk('public')->delete($mainCarousel->image);
        }

        $mainCarousel->delete();

        session()->flash('success', 'Main carousel item deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}