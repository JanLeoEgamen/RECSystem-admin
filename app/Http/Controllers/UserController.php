<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit', 'update']),
            new Middleware('permission:create users', only: ['create', 'store']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = User::with(['roles', 'assignedBureaus', 'assignedSections']);

                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'name':
                            $query->orderBy('first_name', $direction)
                                ->orderBy('last_name', $direction);
                            break;
                            
                        case 'email':
                            $query->orderBy('email', $direction);
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
                $users = $query->paginate($perPage);

                $transformedUsers = $users->getCollection()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'email' => $user->email,
                        'roles' => $user->roles->pluck('name')->implode(', '),
                        'is_superadmin' => $user->hasRole('superadmin'), // Add this line
                        'assignments' => collect([
                            ...$user->assignedBureaus->map(fn($b) => 'Bureau: ' . $b->bureau_name),
                            ...$user->assignedSections->map(fn($s) => 'Section: ' . $s->section_name . ' (' . $s->bureau->bureau_name . ')'),
                        ])->implode('<br>'),
                        'created' => $user->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedUsers,
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                    'total' => $users->total(),
                ]);
            }

            return view('users.list');

        } catch (QueryException $e) {
            Log::error('Database error in UserController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve users. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load users. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in UserController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An unexpected error occurred.'
                ], 500);
            }
            
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $roles = Role::orderBy('name', 'ASC')->get();
            $bureaus = Bureau::orderBy('bureau_name', 'ASC')->get();
            $sections = Section::with('bureau')->orderBy('section_name', 'ASC')->get();
            
            return view('users.create', [
                'roles' => $roles,
                'bureaus' => $bureaus,
                'sections' => $sections
            ]);
            
        } catch (QueryException $e) {
            Log::error('Database error loading user create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load user creation form. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error loading user create form: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while loading the form.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:5|same:confirm_password',
                'confirm_password' => 'required',
            ]);
            
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->birthdate = $request->birthdate;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->syncRoles($request->role);

            if ($request->has('bureaus')) {
                $bureauAssignments = [];
                foreach ($request->bureaus as $bureauId) {
                    $bureauAssignments[$bureauId] = ['section_id' => null];
                }
                $user->assignedBureaus()->sync($bureauAssignments);
            }

            if ($request->has('sections')) {
                $sectionAssignments = [];
                foreach ($request->sections as $sectionId) {
                    $section = Section::findOrFail($sectionId);
                    $sectionAssignments[$sectionId] = ['bureau_id' => $section->bureau_id];
                }
                $user->assignedSections()->sync($sectionAssignments);
            }

            return redirect()->route('users.index')
                ->with('success', 'User added successfully');

        } catch (ValidationException $e) {
            return redirect()->route('users.create')
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (ModelNotFoundException $e) {
            Log::error('Section not found during user creation: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Invalid section selected. Please try again.');
            
        } catch (QueryException $e) {
            Log::error('Database error creating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create user. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error creating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while creating the user.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::orderBy('name', 'ASC')->get();
            $bureaus = Bureau::orderBy('bureau_name', 'ASC')->get();
            $sections = Section::with('bureau')->orderBy('section_name', 'ASC')->get();
            $hasRoles = $user->roles->pluck('id');
            
            return view('users.edit', [
                'user' => $user,
                'roles' => $roles,
                'hasRoles' => $hasRoles,
                'bureaus' => $bureaus,
                'sections' => $sections
            ]);
            
        } catch (ModelNotFoundException $e) {
            Log::error('User not found for editing: ' . $id);
            return redirect()->route('users.index')->with('error', 'User not found.');
            
        } catch (QueryException $e) {
            Log::error('Database error loading user edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load user edit form. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error loading user edit form: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while loading the form.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$id.',id'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            
            // Check if user is changing from superadmin role
            $currentRole = $user->roles->first()->name ?? '';
            $newRole = $request->role;
            
            // Superadmin role change validation
            if ($currentRole === 'superadmin' && $newRole !== 'superadmin') {
                // Check if this is the last superadmin
                $superadminCount = User::role('superadmin')->count();
                if ($superadminCount <= 1) {
                    return redirect()->route('users.edit', $id)
                        ->withInput()
                        ->with('error', 'Cannot remove superadmin role. This is the last superadmin user.');
                }
            }
            
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->birthdate = $request->birthdate;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles($request->role);

            $bureauAssignments = [];
            if ($request->has('bureaus')) {
                foreach ($request->bureaus as $bureauId) {
                    $bureauAssignments[$bureauId] = ['section_id' => null];
                }
            }
            $user->assignedBureaus()->sync($bureauAssignments);

            $sectionAssignments = [];
            if ($request->has('sections')) {
                foreach ($request->sections as $sectionId) {
                    $section = Section::findOrFail($sectionId);
                    $sectionAssignments[$sectionId] = ['bureau_id' => $section->bureau_id];
                }
            }
            $user->assignedSections()->sync($sectionAssignments);

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::error('User or section not found during update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'User or section not found. Please try again.');
            
        } catch (ValidationException $e) {
            return redirect()->route('users.edit', $id)
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Please correct the errors below.');
                
        } catch (QueryException $e) {
            Log::error('Database error updating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update user. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error updating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected error occurred while updating the user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::findOrFail($id);

            // Check if the user has the superadmin role
            if ($user->hasRole('superadmin')) {
                session()->flash('error', 'Superadmin users cannot be deleted.');
                return response()->json([
                    'status' => false,
                    'message' => 'Superadmin users cannot be deleted.'
                ], 403); // Forbidden status code
            }

            $user->forceDelete();
            
            session()->flash('success', 'User deleted successfully.');
            return response()->json([
                'status' => true
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('User not found for deletion: ' . $request->id);
            session()->flash('error', 'User not found.');
            return response()->json([
                'status' => false
            ], 404);
            
        } catch (QueryException $e) {
            Log::error('Database error deleting user: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete user. Please try again.');
            return response()->json([
                'status' => false
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting user: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while deleting the user.');
            return response()->json([
                'status' => false
            ], 500);
        }
    }

}