<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MembershipTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view membership types', only: ['index']),
            new Middleware('permission:edit membership types', only: ['edit', 'update']),
            new Middleware('permission:create membership types', only: ['create', 'store']),
            new Middleware('permission:delete membership types', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = MembershipType::query();

                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('type_name', 'like', "%$search%");
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'type_name':
                            $query->orderBy('type_name', $direction);
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
                $membershipTypes = $query->paginate($perPage);

                $transformedTypes = $membershipTypes->getCollection()->map(function ($type) {
                    return [
                        'id' => $type->id,
                        'type_name' => $type->type_name,
                        'created_at' => $type->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedTypes,
                    'current_page' => $membershipTypes->currentPage(),
                    'last_page' => $membershipTypes->lastPage(),
                    'from' => $membershipTypes->firstItem(),
                    'to' => $membershipTypes->lastItem(),
                    'total' => $membershipTypes->total(),
                ]);
            }

            return view('membership-types.list');

        } catch (QueryException $e) {
            Log::error('Database error in MembershipTypeController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve membership types. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load membership types. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in MembershipTypeController@index: ' . $e->getMessage());
            
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
            return view('membership-types.create');
            
        } catch (\Exception $e) {
            Log::error('Error loading membership type create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the membership type creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type_name' => [
                    'required',
                    'min:2',
                    'max:255',
                    'unique:membership_types,type_name',
                    'regex:/^[\pL\s\-]+$/u'
                ]
            ], [
                'type_name.regex' => 'Type name may only contain letters, spaces and hyphens'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $membershipType = new MembershipType();
            $membershipType->type_name = $request->type_name;
            $membershipType->user_id = $request->user()->id;
            $membershipType->save();

            return redirect()->route('membership-types.index')
                ->with('success', 'Membership type added successfully');

        } catch (ValidationException $e) {
            return redirect()->route('membership-types.create')
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error creating membership type: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create membership type. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error creating membership type: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while creating the membership type.');
        }
    }

    public function edit(string $id)
    {
        try {
            $membershipType = MembershipType::findOrFail($id);
            return view('membership-types.edit', ['membershipType' => $membershipType]);
            
        } catch (ModelNotFoundException $e) {
            Log::error('Membership type not found for editing: ' . $id);
            return redirect()->route('membership-types.index')->with('error', 'Membership type not found.');
            
        } catch (\Exception $e) {
            Log::error('Error loading membership type edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the membership type edit form.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $membershipType = MembershipType::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'type_name' => [
                    'required',
                    'min:2',
                    'max:255',
                    'unique:membership_types,type_name,' . $id,
                    'regex:/^[\pL\s\-]+$/u'
                ]
            ], [
                'type_name.regex' => 'Type name may only contain letters, spaces and hyphens'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $membershipType->type_name = $request->type_name;
            $membershipType->save();

            return redirect()->route('membership-types.index')
                ->with('success', 'Membership type updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('Membership type not found for updating: ' . $id);
            return redirect()->route('membership-types.index')->with('error', 'Membership type not found.');
            
        } catch (ValidationException $e) {
            return redirect()->route('membership-types.edit', $id)
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error updating membership type: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update membership type. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error updating membership type: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while updating the membership type.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $membershipType = MembershipType::findOrFail($id);

            $membershipType->delete();
            
            session()->flash('success', 'Membership type deleted successfully.');
            return response()->json(['status' => true]);

        } catch (ModelNotFoundException $e) {
            Log::error('Membership type not found for deletion: ' . $request->id);
            session()->flash('error', 'Membership type not found.');
            return response()->json(['status' => false], 404);
            
        } catch (QueryException $e) {
            Log::error('Database error deleting membership type: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete membership type. It may be in use.');
            return response()->json(['status' => false], 500);
            
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting membership type: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while deleting the membership type.');
            return response()->json(['status' => false], 500);
        }
    }
}