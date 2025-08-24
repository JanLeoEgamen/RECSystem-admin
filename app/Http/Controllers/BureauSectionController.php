<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BureauSectionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view bureaus and sections', only: ['index']),
            new Middleware('permission:edit bureaus and sections', only: ['edit', 'update']),
            new Middleware('permission:create bureaus and sections', only: ['create', 'store']),
            new Middleware('permission:delete bureaus and sections', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Bureau::with(['sections', 'user']);

                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('bureau_name', 'like', "%$search%")
                          ->orWhereHas('sections', function ($q2) use ($search) {
                              $q2->where('section_name', 'like', "%$search%");
                          });
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'bureau_name':
                            $query->orderBy('bureau_name', $direction);
                            break;
                        case 'section_name':
                            $query->whereHas('sections', function ($q) use ($direction) {
                                $q->orderBy('section_name', $direction);
                            });
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
                        'sections_count' => $bureau->sections->count(),
                        'created_at' => $bureau->created_at->format('d M, Y'),
                        'sections' => $bureau->sections->map(function ($section) {
                            return [
                                'id' => $section->id,
                                'section_name' => $section->section_name,
                                'created_at' => $section->created_at->format('d M, Y'),
                            ];
                        })
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

            return view('bureau-section.list');

        } catch (QueryException $e) {
            Log::error('Database error in BureauSectionController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve bureaus and sections. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load bureaus and sections. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in BureauSectionController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An unexpected error occurred.'
                ], 500);
            }
            
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function create()
    {
        try {
            $bureaus = Bureau::all();
            return view('bureau-section.create', compact('bureaus'));
            
        } catch (\Exception $e) {
            Log::error('Error loading bureau/section create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the bureau/section creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:bureau,section',
                'bureau_name' => 'required_if:type,bureau|min:2|max:255|unique:bureaus,bureau_name',
                'section_name' => 'required_if:type,section|min:2|max:255',
                'bureau_id' => 'required_if:type,section|exists:bureaus,id'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            if ($request->type === 'bureau') {
                $bureau = new Bureau();
                $bureau->bureau_name = $request->bureau_name;
                $bureau->user_id = $request->user()->id;
                $bureau->save();
                
                $message = 'Bureau added successfully';
            } else {
                $section = new Section();
                $section->section_name = $request->section_name;
                $section->bureau_id = $request->bureau_id;
                $section->user_id = $request->user()->id;
                $section->save();
                
                $message = 'Section added successfully';
            }

            return redirect()->route('bureau-section.index')
                ->with('success', $message);

        } catch (ValidationException $e) {
            return redirect()->route('bureau-section.create')
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error creating bureau/section: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create bureau/section. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error creating bureau/section: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while creating the bureau/section.');
        }
    }

    public function edit(string $id, string $type)
    {
        try {
            if ($type === 'bureau') {
                $item = Bureau::findOrFail($id);
                $bureaus = Bureau::all();
                return view('bureau-section.edit', ['item' => $item, 'type' => 'bureau', 'bureaus' => $bureaus]);
            } else {
                $item = Section::findOrFail($id);
                $bureaus = Bureau::all();
                return view('bureau-section.edit', ['item' => $item, 'type' => 'section', 'bureaus' => $bureaus]);
            }
            
        } catch (ModelNotFoundException $e) {
            Log::error('Bureau/Section not found for editing: ' . $id);
            return redirect()->route('bureau-section.index')->with('error', 'Bureau/Section not found.');
            
        } catch (\Exception $e) {
            Log::error('Error loading bureau/section edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the bureau/section edit form.');
        }
    }

    public function update(Request $request, string $id, string $type)
    {
        try {
            if ($type === 'bureau') {
                $bureau = Bureau::findOrFail($id);

                $validator = Validator::make($request->all(), [
                    'bureau_name' => [
                        'required',
                        'min:2',
                        'max:255',
                        'unique:bureaus,bureau_name,' . $id,
                    ]
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $bureau->bureau_name = $request->bureau_name;
                $bureau->save();

                $message = 'Bureau updated successfully';
            } else {
                $section = Section::findOrFail($id);

                $validator = Validator::make($request->all(), [
                    'section_name' => [
                        'required',
                        'min:2',
                        'max:255',
                    ],
                    'bureau_id' => 'required|exists:bureaus,id'
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $section->section_name = $request->section_name;
                $section->bureau_id = $request->bureau_id;
                $section->save();

                $message = 'Section updated successfully';
            }

            return redirect()->route('bureau-section.index')
                ->with('success', $message);

        } catch (ModelNotFoundException $e) {
            Log::error('Bureau/Section not found for updating: ' . $id);
            return redirect()->route('bureau-section.index')->with('error', 'Bureau/Section not found.');
            
        } catch (ValidationException $e) {
            return redirect()->route('bureau-section.edit', ['id' => $id, 'type' => $type])
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error updating bureau/section: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update bureau/section. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error updating bureau/section: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while updating the bureau/section.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $type = $request->type;

            if ($type === 'bureau') {
                $item = Bureau::findOrFail($id);
            } else {
                $item = Section::findOrFail($id);
            }

            $item->delete();
            
            session()->flash('success', ucfirst($type) . ' deleted successfully.');
            return response()->json(['status' => true]);

        } catch (ModelNotFoundException $e) {
            Log::error('Bureau/Section not found for deletion: ' . $request->id);
            session()->flash('error', ucfirst($request->type) . ' not found.');
            return response()->json(['status' => false], 404);
            
        } catch (QueryException $e) {
            Log::error('Database error deleting bureau/section: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete ' . $request->type . '. It may be in use.');
            return response()->json(['status' => false], 500);
            
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting bureau/section: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while deleting the ' . $request->type . '.');
            return response()->json(['status' => false], 500);
        }
    }
}