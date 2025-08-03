<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class BureauController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view bureaus', only: ['index']),
            new Middleware('permission:edit bureaus', only: ['edit']),
            new Middleware('permission:create bureaus', only: ['create']),
            new Middleware('permission:delete bureaus', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Bureau::query();

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('bureau_name', 'like', "%$search%");
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'bureau_name':
                        $query->orderBy('bureau_name', $direction);
                        break;
                        
                    case 'created':
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
            $bureaus = $query->paginate($perPage);

            $transformedBureaus = $bureaus->getCollection()->map(function ($bureau) {
                return [
                    'id' => $bureau->id,
                    'bureau_name' => $bureau->bureau_name,
                    'created_at' => $bureau->created_at->format('d M, Y'),
                    'can_edit' => request()->user()->can('edit bureaus'),
                    'can_delete' => request()->user()->can('delete bureaus'),
                ];
            });

            return response()->json([
                'data' => $transformedBureaus,
                'current_page' => $bureaus->currentPage(),
                'last_page' => $bureaus->lastPage(),
                'from' => $bureaus->firstItem(),
                'to' => $bureaus->lastItem(),
                'total' => $bureaus->total(),
            ]);
        }

        return view('bureaus.list');
    }

    public function create()
    {
        return view('bureaus.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bureau_name' => [
                'required',
                'min:2',
                'max:255',
                'unique:bureaus,bureau_name',
                'regex:/^[\pL\s\-]+$/u'
            ]
        ], [
            'bureau_name.regex' => 'Bureau name may only contain letters, spaces and hyphens'
        ]);

        if ($validator->fails()) {
            return redirect()->route('bureaus.create')
                ->withInput()
                ->withErrors($validator);
        }

        $bureau = new Bureau();
        $bureau->bureau_name = $request->bureau_name;
        $bureau->user_id = $request->user()->id;
        $bureau->save();

        return redirect()->route('bureaus.index')
            ->with('success', 'Bureau added successfully');
    }

    public function edit(string $id)
    {
        $bureau = Bureau::findOrFail($id);
        return view('bureaus.edit', ['bureau' => $bureau]);
    }

    public function update(Request $request, string $id)
    {
        $bureau = Bureau::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'bureau_name' => [
                'required',
                'min:2',
                'max:255',
                'unique:bureaus,bureau_name,' . $id,
                'regex:/^[\pL\s\-]+$/u'
            ]
        ], [
            'bureau_name.regex' => 'Bureau name may only contain letters, spaces and hyphens'
        ]);

        if ($validator->fails()) {
            return redirect()->route('bureaus.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $bureau->bureau_name = $request->bureau_name;
        $bureau->save();

        return redirect()->route('bureaus.index')
            ->with('success', 'Bureau updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $bureau = Bureau::findOrFail($id);

        if ($bureau == null) {
            session()->flash('error', 'Bureau not found.');
            return response()->json(['status' => false]);
        }

        $bureau->forceDelete();

        session()->flash('success', 'Bureau deleted successfully.');
        return response()->json(['status' => true]);
    }
}