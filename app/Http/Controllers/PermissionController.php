<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit', 'update']),
            new Middleware('permission:create permissions', only: ['create', 'store']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Permission::query();

                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'name':
                            $query->orderBy('name', $direction);
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
                $permissions = $query->paginate($perPage);

                $transformedPermissions = $permissions->getCollection()->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'created_at' => $permission->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedPermissions,
                    'current_page' => $permissions->currentPage(),
                    'last_page' => $permissions->lastPage(),
                    'from' => $permissions->firstItem(),
                    'to' => $permissions->lastItem(),
                    'total' => $permissions->total(),
                ]);
            }

            return view('permissions.list');

        } catch (QueryException $e) {
            Log::error('Database error in PermissionController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve permissions. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load permissions. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in PermissionController@index: ' . $e->getMessage());
            
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
            return view('permissions.create');
            
        } catch (\Exception $e) {
            Log::error('Error loading permission create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the permission creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions|min:3'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully');

        } catch (ValidationException $e) {
            return redirect()->route('permissions.create')
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error creating permission: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create permission. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error creating permission: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while creating the permission.');
        }
    }

    public function edit($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            return view('permissions.edit', [
                'permission' => $permission
            ]);
            
        } catch (ModelNotFoundException $e) {
            Log::error('Permission not found for editing: ' . $id);
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
            
        } catch (\Exception $e) {
            Log::error('Error loading permission edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load the permission edit form.');
        }
    }

    public function update($id, Request $request)
    {
        try {
            $permission = Permission::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $permission->name = $request->name;
            $permission->save();
            
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('Permission not found for updating: ' . $id);
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
            
        } catch (ValidationException $e) {
            return redirect()->route('permissions.edit', $id)
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error updating permission: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update permission. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error updating permission: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while updating the permission.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $permission = Permission::findOrFail($id);

            $permission->delete();
            
            session()->flash('success', 'Permission deleted successfully');
            return response()->json([
                'status' => true
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('Permission not found for deletion: ' . $request->id);
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => false
            ], 404);
            
        } catch (QueryException $e) {
            Log::error('Database error deleting permission: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete permission. It may be in use.');
            return response()->json([
                'status' => false
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting permission: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while deleting the permission.');
            return response()->json([
                'status' => false
            ], 500);
        }
    }
}