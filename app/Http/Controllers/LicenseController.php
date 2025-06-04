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
            $data = Member::with(['membershipType', 'section.bureau'])
                ->whereNotNull('license_number')
                ->whereNotNull('license_class')
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
                }
                )->addColumn('membership_type', function($row) {
                    return $row->membershipType->type_name ?? 'N/A';
                })
                ->addColumn('license_validity', function($row) {
                    if (!$row->license_expiration_date) {
                        return 'N/A';
                    }
                    
                    $now = now();
                    $expiry = \Carbon\Carbon::parse($row->license_expiration_date);
                    
                    if ($now->gt($expiry)) {
                        return '<span class="text-red-600">Expired ' . $expiry->format('M d, Y') . '</span>';
                    } else {
                        return '<span class="text-green-600">Valid until ' . $expiry->format('M d, Y') . '</span>';
                    }
                })
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    // Add view button
                    if (request()->user()->can('view licenses')) {
                        $buttons .= '<a href="'.route('licenses.show', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>';
                    }
                    
                    // Rest of your buttons remain the same
                    if (request()->user()->can('edit licenses')) {
                        $buttons .= '<a href="'.route('licenses.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete licenses')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteLicense('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->rawColumns(['action', 'license_validity'])
                ->make(true);
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