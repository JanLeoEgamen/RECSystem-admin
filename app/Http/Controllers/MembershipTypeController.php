<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class MembershipTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view membership types', only: ['index']),
            new Middleware('permission:edit membership types', only: ['edit']),
            new Middleware('permission:create membership types', only: ['create']),
            new Middleware('permission:delete membership types', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MembershipType::query();

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('type_name', 'like', "%$search%");
                });
            }

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
    }

    public function create()
    {
        return view('membership-types.create');
    }

    public function store(Request $request)
    {
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
            return redirect()->route('membership-types.create')
                ->withInput()
                ->withErrors($validator);
        }

        $membershipType = new MembershipType();
        $membershipType->type_name = $request->type_name;
        $membershipType->user_id = $request->user()->id;
        $membershipType->save();

        return redirect()->route('membership-types.index')
            ->with('success', 'Membership type added successfully');
    }

    public function edit(string $id)
    {
        $membershipType = MembershipType::findOrFail($id);
        return view('membership-types.edit', ['membershipType' => $membershipType]);
    }

    public function update(Request $request, string $id)
    {
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
            return redirect()->route('membership-types.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $membershipType->type_name = $request->type_name;
        $membershipType->save();

        return redirect()->route('membership-types.index')
            ->with('success', 'Membership type updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $membershipType = MembershipType::findOrFail($id);

        if ($membershipType == null) {
            session()->flash('error', 'Membership type not found.');
            return response()->json(['status' => false]);
        }

        $membershipType->delete();

        session()->flash('success', 'Membership type deleted successfully.');
        return response()->json(['status' => true]);
    }

}
