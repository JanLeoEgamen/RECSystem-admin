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
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with(['roles', 'assignedBureaus', 'assignedSections']);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            }

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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        $bureaus = Bureau::orderBy('bureau_name', 'ASC')->get();
        $sections = Section::with('bureau')->orderBy('section_name', 'ASC')->get();
        
        return view('users.create', [
            'roles' => $roles,
            'bureaus' => $bureaus,
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
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
                $section = Section::find($sectionId);
                $sectionAssignments[$sectionId] = ['bureau_id' => $section->bureau_id];
            }
            $user->assignedSections()->sync($sectionAssignments);
        }

        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
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
                $section = Section::find($sectionId);
                $sectionAssignments[$sectionId] = ['bureau_id' => $section->bureau_id];
            }
        }
        $user->assignedSections()->sync($sectionAssignments);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);

        if ($user == null) {
            session()->flash('error', 'User not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $user->forceDelete();

        session()->flash('success', 'User deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}