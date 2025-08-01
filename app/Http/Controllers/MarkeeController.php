<?php

namespace App\Http\Controllers;

use App\Models\Markee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MarkeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view markees', only: ['index']),
            new Middleware('permission:edit markees', only: ['edit']),
            new Middleware('permission:create markees', only: ['create']),
            new Middleware('permission:delete markees', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Markee::with('user');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('header', 'like', "%$search%")
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
                    case 'header':
                        $query->orderBy('header', $direction);
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
            $markees = $query->paginate($perPage);

            $transformedMarkees = $markees->getCollection()->map(function ($markee) {
                return [
                    'id' => $markee->id,
                    'header' => $markee->header,
                    'content' => Str::limit($markee->content, 50),
                    'author' => $markee->user->first_name . ' ' . $markee->user->last_name,
                    'status' => $markee->status ? 'Active' : 'Inactive',
                    'created_at' => $markee->created_at->format('d M, Y'),
                ];
            });

            return response()->json([
                'data' => $transformedMarkees,
                'current_page' => $markees->currentPage(),
                'last_page' => $markees->lastPage(),
                'from' => $markees->firstItem(),
                'to' => $markees->lastItem(),
                'total' => $markees->total(),
            ]);
        }

        return view('markees.list');
    }

    public function create()
    {
        return view('markees.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('markees.create')
                ->withInput()
                ->withErrors($validator);
        }

        $markee = new Markee();
        $markee->header = $request->header;
        $markee->content = $request->content;
        $markee->user_id = $request->user()->id;
        $markee->status = $request->status ?? true;
        $markee->save();

        return redirect()->route('markees.index')
            ->with('success', 'Markee added successfully');
    }

    public function edit(string $id)
    {
        $markee = Markee::findOrFail($id);
        return view('markees.edit', [
            'markee' => $markee
        ]);
    } 

    public function update(Request $request, string $id)
    {
        $markee = Markee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'header' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('markees.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $markee->header = $request->header;
        $markee->content = $request->content;
        $markee->status = $request->status ?? $markee->status;
        $markee->save();

        return redirect()->route('markees.index')
            ->with('success', 'Markee updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $markee = Markee::findOrFail($id);

        if ($markee == null) {
            session()->flash('error', 'Markee not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $markee->delete();

        session()->flash('success', 'Markee deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

}
