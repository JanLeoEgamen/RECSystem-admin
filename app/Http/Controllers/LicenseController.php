<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LicenseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view licenses', only: ['index', 'unlicensed']),
            new Middleware('permission:edit licenses', only: ['edit', 'update']),
            new Middleware('permission:delete licenses', only: ['destroy']),
            new Middleware('permission:view licenses', only: ['index', 'unlicensed', 'show']),

        ];
    }

    /**
     * Display a listing of licensed members.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Member::with(['membershipType', 'section.bureau'])
                ->whereNotNull('license_number')
                ->whereNotNull('license_class');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('callsign', 'like', "%$search%")
                    ->orWhere('license_number', 'like', "%$search%")
                    ->orWhere('license_class', 'like', "%$search%")
                    ->orWhereHas('section.bureau', function($q) use ($search) {
                        $q->where('bureau_name', 'like', "%$search%");
                    });
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'name':
                        $query->orderBy('last_name', $direction)
                            ->orderBy('first_name', $direction);
                        break;
                        
                    case 'callsign':
                        $query->orderBy('callsign', $direction);
                        break;
                        
                    case 'expiry':
                        $query->orderBy('license_expiration_date', $direction);
                        break;
                        
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $members = $query->paginate($perPage);

            $transformedMembers = $members->getCollection()->map(function ($member) {
                $expiry = $member->license_expiration_date ? \Carbon\Carbon::parse($member->license_expiration_date) : null;
                $now = now();
                
                $validity = 'N/A';
                if ($expiry) {
                    if ($now->gt($expiry)) {
                        $validity = '<span class="text-red-600">Expired ' . $expiry->format('M d, Y') . '</span>';
                    } else {
                        $validity = '<span class="text-green-600">Valid until ' . $expiry->format('M d, Y') . '</span>';
                    }
                }

                return [
                    'id' => $member->id,
                    'name' => $member->first_name . ' ' . $member->last_name,
                    'callsign' => $member->callsign,
                    'license_class' => $member->license_class,
                    'membership_type' => $member->membershipType->type_name ?? 'N/A',
                    'bureau' => $member->section->bureau->bureau_name ?? 'N/A',
                    'section' => $member->section->section_name ?? 'N/A',
                    'license_validity' => $validity,
                    'can_view' => request()->user()->can('view licenses'),
                    'can_edit' => request()->user()->can('edit licenses'),
                    'can_delete' => request()->user()->can('delete licenses'),
                ];
            });

            return response()->json([
                'data' => $transformedMembers,
                'current_page' => $members->currentPage(),
                'last_page' => $members->lastPage(),
                'from' => $members->firstItem(),
                'to' => $members->lastItem(),
                'total' => $members->total(),
            ]);
        }

        return view('licenses.list');
    }

    /**
     * Display a listing of unlicensed members.
     */
    public function unlicensed(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::with(['membershipType', 'section.bureau'])
                ->where(function($query) {
                    $query->whereNull('license_number')
                        ->orWhereNull('license_class');
                })
                ->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('bureau', function($row) {
                    return $row->section->bureau->bureau_name ?? 'N/A';
                })
                ->addColumn('section', function($row) {
                    return $row->section->section_name ?? 'N/A';
                })
                ->addColumn('membership_type', function($row) {
                    return $row->membershipType->type_name ?? 'N/A';
                })
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('edit licenses')) {
                        $buttons .= '<a href="'.route('licenses.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('licenses.unlicensed');
    }
    /**
     * Display the specified license details.
     */
    public function show(string $id)
    {
        $member = Member::with(['membershipType', 'section.bureau'])->findOrFail($id);
        return view('licenses.show', ['member' => $member]);
    }
    /**
     * Show the form for editing license information.
     */
    public function edit(string $id)
    {
        $member = Member::with(['membershipType', 'section.bureau'])->findOrFail($id);
            // Convert license_expiration_date to Carbon instance if it exists
    if ($member->license_expiration_date) {
        $member->license_expiration_date = \Carbon\Carbon::parse($member->license_expiration_date);
    }

        return view('licenses.edit', ['member' => $member]);
    }

    /**
     * Update the license information.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'license_class' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:members,license_number,'.$id,
            'license_expiration_date' => 'required|date',
            'callsign' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('licenses.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $member->license_class = $request->license_class;
        $member->license_number = $request->license_number;
        $member->license_expiration_date = $request->license_expiration_date;
        $member->callsign = $request->callsign;
        $member->save();

        return redirect()->route('licenses.index')
            ->with('success', 'License information updated successfully');
    }

    /**
     * Remove license information from a member.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $member = Member::findOrFail($id);

        $member->license_class = null;
        $member->license_number = null;
        $member->license_expiration_date = null;
        $member->callsign = null;
        $member->save();

        return response()->json([
            'status' => true,
            'message' => 'License information removed successfully'
        ]);
    }
}