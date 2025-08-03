<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view sections', only: ['index']),
            new Middleware('permission:edit sections', only: ['edit']),
            new Middleware('permission:create sections', only: ['create']),
            new Middleware('permission:delete sections', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Section::with('bureau');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('section_name', 'like', "%$search%")
                      ->orWhereHas('bureau', function($q) use ($search) {
                          $q->where('bureau_name', 'like', "%$search%");
                      });
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'section_name':
                        $query->orderBy('section_name', $direction);
                        break;
                        
                    case 'bureau_name':
                        $query->join('bureaus', 'sections.bureau_id', '=', 'bureaus.id')
                              ->orderBy('bureaus.bureau_name', $direction)
                              ->select('sections.*');
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
            $sections = $query->paginate($perPage);

            $transformedSections = $sections->getCollection()->map(function ($section) {
                return [
                    'id' => $section->id,
                    'section_name' => $section->section_name,
                    'bureau_name' => $section->bureau->bureau_name ?? 'N/A',
                    'created_at' => $section->created_at->format('d M, Y'),
                    'can_edit' => request()->user()->can('edit sections'),
                    'can_delete' => request()->user()->can('delete sections'),
                ];
            });

            return response()->json([
                'data' => $transformedSections,
                'current_page' => $sections->currentPage(),
                'last_page' => $sections->lastPage(),
                'from' => $sections->firstItem(),
                'to' => $sections->lastItem(),
                'total' => $sections->total(),
            ]);
        }

        return view('sections.list');
    }

    public function create()
    {
        $bureaus = Bureau::orderBy('bureau_name', 'ASC')->get();
        return view('sections.create', ['bureaus' => $bureaus]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => [
                'required',
                'min:2',
                'max:255',
                'unique:sections,section_name',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'bureau_id' => 'required|exists:bureaus,id'
        ], [
            'section_name.regex' => 'Section name may only contain letters, spaces and hyphens'
        ]);

        if ($validator->fails()) {
            return redirect()->route('sections.create')
                ->withInput()
                ->withErrors($validator);
        }

        $section = new Section();
        $section->section_name = $request->section_name;
        $section->bureau_id = $request->bureau_id;
        $section->user_id = $request->user()->id;
        $section->save();

        return redirect()->route('sections.index')
            ->with('success', 'Section added successfully');
    }

    public function edit(string $id)
    {
        $section = Section::findOrFail($id);
        $bureaus = Bureau::orderBy('bureau_name', 'ASC')->get();
        return view('sections.edit', [
            'section' => $section,
            'bureaus' => $bureaus
        ]);
    }

    public function update(Request $request, string $id)
    {
        $section = Section::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section_name' => [
                'required',
                'min:2',
                'max:255',
                'unique:sections,section_name,' . $id,
                'regex:/^[\pL\s\-]+$/u'
            ],
            'bureau_id' => 'required|exists:bureaus,id'
        ], [
            'section_name.regex' => 'Section name may only contain letters, spaces and hyphens'
        ]);

        if ($validator->fails()) {
            return redirect()->route('sections.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $section->section_name = $request->section_name;
        $section->bureau_id = $request->bureau_id;
        $section->save();

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $section = Section::findOrFail($id);

        if ($section == null) {
            session()->flash('error', 'Section not found.');
            return response()->json(['status' => false]);
        }

        $section->forceDelete();

        session()->flash('success', 'Section deleted successfully.');
        return response()->json(['status' => true]);
    }
}