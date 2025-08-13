<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view sections', only: ['index']),
            new Middleware('permission:edit sections', only: ['edit', 'update']),
            new Middleware('permission:create sections', only: ['create', 'store']),
            new Middleware('permission:delete sections', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Section::with('bureau:id,bureau_name');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('section_name', 'like', '%'.$request->search.'%')
                          ->orWhereHas('bureau', function($q) use ($request) {
                              $q->where('bureau_name', 'like', '%'.$request->search.'%');
                          });
                    });
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
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

        } catch (\Exception $e) {
            Log::error('Section index error: '.$e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load sections'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load sections. Please try again.');
        }
    }

    public function create()
    {
        try {
            $bureaus = Bureau::orderBy('bureau_name')->get(['id', 'bureau_name']);
            return view('sections.create', compact('bureaus'));
        } catch (\Exception $e) {
            Log::error('Section create form error: '.$e->getMessage());
            return redirect()->route('sections.index')
                ->with('error', 'Failed to load section creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateSectionRequest($request);

            Section::create([
                'section_name' => $validated['section_name'],
                'bureau_id' => $validated['bureau_id'],
                'user_id' => $request->user()->id,
            ]);

            return redirect()->route('sections.index')
                ->with('success', 'Section added successfully');

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Section store error: '.$e->getMessage());
            return redirect()->route('sections.create')
                ->withInput()
                ->with('error', 'Failed to create section. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $section = Section::findOrFail($id);
            $bureaus = Bureau::orderBy('bureau_name')->get(['id', 'bureau_name']);
            
            return view('sections.edit', compact('section', 'bureaus'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Section not found for editing: {$id}");
            return redirect()->route('sections.index')
                ->with('error', 'Section not found.');
        } catch (\Exception $e) {
            Log::error("Section edit form error for ID {$id}: ".$e->getMessage());
            return redirect()->route('sections.index')
                ->with('error', 'Failed to load section edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $section = Section::findOrFail($id);
            $validated = $this->validateSectionRequest($request, $id);

            $section->update([
                'section_name' => $validated['section_name'],
                'bureau_id' => $validated['bureau_id'],
            ]);

            return redirect()->route('sections.index')
                ->with('success', 'Section updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Section not found for update: {$id}");
            return redirect()->route('sections.index')
                ->with('error', 'Section not found.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error("Section update error for ID {$id}: ".$e->getMessage());
            return redirect()->route('sections.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update section. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $section = Section::findOrFail($request->id);
            $section->delete();

            return response()->json([
                'status' => true,
                'message' => 'Section deleted successfully'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Section not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Section not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Section deletion error for ID {$request->id}: ".$e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete section'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function validateSectionRequest(Request $request, $sectionId = null): array
    {
        $rules = [
            'section_name' => [
                'required',
                'min:2',
                'max:255',
                'unique:sections,section_name,'.$sectionId,
                'regex:/^[\pL\s\-]+$/u'
            ],
            'bureau_id' => 'required|exists:bureaus,id'
        ];

        $messages = [
            'section_name.regex' => 'Section name may only contain letters, spaces and hyphens'
        ];

        return $request->validate($rules, $messages);
    }

    protected function applySorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'section_name':
                $query->orderBy('section_name', $direction);
                break;
                
            case 'bureau_name':
                $query->join('bureaus', 'sections.bureau_id', '=', 'bureaus.id')
                    ->orderBy('bureaus.bureau_name', $direction)
                    ->select('sections.*');
                break;
                
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}