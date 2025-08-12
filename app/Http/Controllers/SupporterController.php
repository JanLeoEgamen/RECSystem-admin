<?php

namespace App\Http\Controllers;

use App\Models\Supporter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SupporterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view supporters', only: ['index']),
            new Middleware('permission:edit supporters', only: ['edit', 'update']),
            new Middleware('permission:create supporters', only: ['create', 'store']),
            new Middleware('permission:delete supporters', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Supporter::with('user');

                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('supporter_name', 'like', "%$search%")
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
                        case 'supporter_name':
                            $query->orderBy('supporter_name', $direction);
                            break;
                            
                        case 'status':
                            $query->orderBy('status', $direction === 'asc' ? 'asc' : 'desc');
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
                $supporters = $query->paginate($perPage);

                $transformedSupporters = $supporters->getCollection()->map(function ($supporter) {
                    return [
                        'id' => $supporter->id,
                        'supporter_name' => $supporter->supporter_name,
                        'image_url' => $supporter->image 
                            ? asset('images/'.$supporter->image)
                            : null,
                        'author' => $supporter->user->first_name . ' ' . $supporter->user->last_name,
                        'status' => $supporter->status ? 'Active' : 'Inactive',
                        'created_at' => $supporter->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedSupporters,
                    'current_page' => $supporters->currentPage(),
                    'last_page' => $supporters->lastPage(),
                    'from' => $supporters->firstItem(),
                    'to' => $supporters->lastItem(),
                    'total' => $supporters->total(),
                ]);
            }
            
            return view('supporters.list');

        } catch (QueryException $e) {
            Log::error('Database error in SupporterController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve supporters. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load supporters. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in SupporterController@index: ' . $e->getMessage());
            
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
            return view('supporters.create');
            
        } catch (\Exception $e) {
            Log::error('Error loading supporter create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the supporter creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'supporter_name' => 'required|min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $supporter = new Supporter();
            $supporter->supporter_name = $request->supporter_name;
            $supporter->user_id = $request->user()->id;
            $supporter->status = $request->status ?? true;

            if ($request->hasFile('image')) {
                try {
                    $imagePath = $request->file('image')->store('supporters', 'public');
                    $supporter->image = $imagePath;
                } catch (FileException $e) {
                    Log::error('File upload error: ' . $e->getMessage());
                    throw new \Exception('Failed to upload supporter image.');
                }
            }

            $supporter->save();

            return redirect()->route('supporters.index')
                ->with('success', 'Supporter added successfully');

        } catch (ValidationException $e) {
            return redirect()->route('supporters.create')
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error creating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create supporter. Please try again.');
            
        } catch (FileException $e) {
            Log::error('File upload error creating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to upload supporter image. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error creating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while creating the supporter.');
        }
    }

    public function edit(string $id)
    {
        try {
            $supporter = Supporter::findOrFail($id);
            return view('supporters.edit', [
                'supporter' => $supporter
            ]);
            
        } catch (ModelNotFoundException $e) {
            Log::error('Supporter not found for editing: ' . $id);
            return redirect()->route('supporters.index')->with('error', 'Supporter not found.');
            
        } catch (\Exception $e) {
            Log::error('Error loading supporter edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the supporter edit form.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $supporter = Supporter::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'supporter_name' => 'required|min:3',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $supporter->supporter_name = $request->supporter_name;
            $supporter->status = $request->status ?? $supporter->status;

            if ($request->hasFile('image')) {
                try {
                    // Delete old image if exists
                    if ($supporter->image) {
                        Storage::disk('public')->delete($supporter->image);
                    }
                    
                    $imagePath = $request->file('image')->store('supporters', 'public');
                    $supporter->image = $imagePath;
                } catch (FileException $e) {
                    Log::error('File upload error updating supporter: ' . $e->getMessage());
                    throw new \Exception('Failed to upload supporter image.');
                }
            }

            $supporter->save();

            return redirect()->route('supporters.index')
                ->with('success', 'Supporter updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('Supporter not found for updating: ' . $id);
            return redirect()->route('supporters.index')->with('error', 'Supporter not found.');
            
        } catch (ValidationException $e) {
            return redirect()->route('supporters.edit', $id)
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error updating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update supporter. Please try again.');
            
        } catch (FileException $e) {
            Log::error('File upload error updating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to upload supporter image. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error updating supporter: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while updating the supporter.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $supporter = Supporter::findOrFail($id);

            // Delete image if exists
            if ($supporter->image) {
                Storage::disk('public')->delete($supporter->image);
            }

            $supporter->delete();
            
            session()->flash('success', 'Supporter deleted successfully.');
            return response()->json([
                'status' => true
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('Supporter not found for deletion: ' . $request->id);
            session()->flash('error', 'Supporter not found.');
            return response()->json([
                'status' => false
            ], 404);
            
        } catch (QueryException $e) {
            Log::error('Database error deleting supporter: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete supporter. Please try again.');
            return response()->json([
                'status' => false
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting supporter: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while deleting the supporter.');
            return response()->json([
                'status' => false
            ], 500);
        }
    }
}