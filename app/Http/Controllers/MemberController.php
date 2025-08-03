<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Applicant;
use App\Models\MembershipType;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view members', only: ['index', 'show']),
            new Middleware('permission:edit members', only: ['edit']),    
            new Middleware('permission:create members', only: ['create']),
            new Middleware('permission:delete members', only: ['destroy']),
            new Middleware('permission:renew members', only: ['showRenewalForm', 'processRenewal']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = $request->user(); 
            
            $query = Member::with(['membershipType', 'section'])
                ->when(!$user->can('view all members'), function($query) use ($user) {
                    $sectionIds = DB::table('user_bureau_section')
                        ->where('user_id', $user->id)
                        ->whereNotNull('section_id')
                        ->pluck('section_id');
                    
                    $bureauIds = DB::table('user_bureau_section')
                        ->where('user_id', $user->id)
                        ->whereNull('section_id')
                        ->pluck('bureau_id');
                    
                    $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
                    
                    $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
                    
                    $query->whereIn('section_id', $allSectionIds);
                });

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('rec_number', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhereHas('membershipType', function($q) use ($search) {
                        $q->where('type_name', 'like', "%$search%");
                    });
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'last_name':
                        $query->orderBy('last_name', $direction)
                            ->orderBy('first_name', $direction);
                        break;
                        
                    case 'rec_number':
                        $query->orderBy('rec_number', $direction);
                        break;
                        
                    case 'membership_start':
                        $query->orderBy('membership_start', $direction);
                        break;
                        
                    case 'membership_end':
                        $query->orderBy('membership_end', $direction);
                        break;
                        
                    case 'status':
                        $query->orderBy('status', $direction)
                            ->orderBy('is_lifetime_member', $direction === 'asc' ? 'desc' : 'asc');
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
                return [
                    'id' => $member->id,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'email_address' => $member->email_address,
                    'cellphone_no' => $member->cellphone_no,
                    'rec_number' => $member->rec_number,
                    'membership_type' => $member->membershipType->type_name ?? 'N/A',
                    'membership_start' => $member->membership_start ? Carbon::parse($member->membership_start)->format('d M, Y') : '',
                    'membership_end' => $member->membership_end ? Carbon::parse($member->membership_end)->format('d M, Y') : '',
                    'status' => $member->status,
                    'is_lifetime_member' => $member->is_lifetime_member,
                    'street_address' => $member->street_address,
                    'can_view' => request()->user()->can('view members'),
                    'can_edit' => request()->user()->can('edit members'),
                    'can_renew' => request()->user()->can('renew members'),
                    'can_delete' => request()->user()->can('delete members'),
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
        
        return view('members.list');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applicants = Applicant::whereDoesntHave('member')->get();
        $membershipTypes = MembershipType::all();
        $sections = Section::all();
        
        return view('members.create', [
            'applicants' => $applicants,
            'membershipTypes' => $membershipTypes,
            'sections' => $sections
        ]);
    }

    public function show(string $id)
    {
        $member = Member::with(['membershipType', 'section'])->findOrFail($id);

        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $member->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $member->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $member->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $member->barangay)->value('psgc_brgy_desc');

        return view('members.view', [
            'member' => $member,
            'regionName' => $regionName,
            'provinceName' => $provinceName,
            'municipalityName' => $municipalityName,
            'barangayName' => $barangayName,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'applicant_id' => 'required|exists:applicants,id',
            'rec_number' => 'required|unique:members,rec_number',
            'membership_type_id' => 'required|exists:membership_types,id',
            'section_id' => 'nullable|exists:sections,id',
            
            // Personal Information
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'middle_name' => 'nullable',
            'suffix' => 'nullable',
            'sex' => 'required',
            'birthdate' => 'required|date',
            'civil_status' => 'required',
            'citizenship' => 'required',
            'blood_type' => 'nullable',
            
            // Contact Information
            'cellphone_no' => 'required',
            'telephone_no' => 'nullable',
            'email_address' => 'required|email',
            
            // Emergency Contact
            'emergency_contact' => 'required',
            'emergency_contact_number' => 'required',
            'relationship' => 'required',
            
            // Membership Information
            'membership_start' => 'required|date',
            'membership_end' => 'required_if:is_lifetime_member,0|date|after:membership_start',
            'is_lifetime_member' => 'boolean',
            'last_renewal_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',

            // License Information
            'license_class' => 'nullable',
            'callsign' => 'nullable',
            'license_number' => 'nullable',
            'license_expiration_date' => 'nullable|date',
            
            // Address Information
            'house_building_number_name' => 'required',
            'street_address' => 'required',
            'zip_code' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('members.showMemberCreateForm')->withInput()->withErrors($validator);
        }

        $member = new Member();
        $member->status = 'Active'; // Default status for new members
        $this->saveMemberData($member, $request);

        return redirect()->route('members.index')->with('success', 'Member added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);
        $membershipTypes = MembershipType::all();
        $sections = Section::all();
        
        return view('members.edit', [
            'member' => $member,
            'membershipTypes' => $membershipTypes,
            'sections' => $sections
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'rec_number' => 'required|unique:members,rec_number,'.$id,
            'membership_type_id' => 'required|exists:membership_types,id',
            'section_id' => 'nullable|exists:sections,id',
            
            // Personal Information
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'middle_name' => 'nullable',
            'suffix' => 'nullable',
            'sex' => 'required',
            'birthdate' => 'required|date',
            'civil_status' => 'required',
            'citizenship' => 'required',
            'blood_type' => 'nullable',
            
            // Contact Information
            'cellphone_no' => 'required',
            'telephone_no' => 'nullable',
            'email_address' => 'required|email',
            
            // Emergency Contact
            'emergency_contact' => 'required',
            'emergency_contact_number' => 'required',
            'relationship' => 'required',
            
            // Membership Information
            'membership_start' => 'required|date',
            'membership_end' => 'required_if:is_lifetime_member,0|date|after:membership_start',
            'is_lifetime_member' => 'boolean',
            'last_renewal_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',

            // License Information
            'license_class' => 'nullable',
            'license_number' => 'nullable',
            'callsign' => 'nullable',
            'license_expiration_date' => 'nullable|date',
            
            // Address Information
            'house_building_number_name' => 'required',
            'street_address' => 'required',
            'zip_code' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('members.edit', $id)->withInput()->withErrors($validator);
        }

        $this->saveMemberData($member, $request);

        return redirect()->route('members.index')->with('success', 'Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $member = Member::find($id);

        if (!$member) {
            session()->flash('error', 'Member not found.');
            return response()->json(['status' => false]);
        }

        $member->status = 'Inactive';
        $member->save();

        session()->flash('success', 'Member status set to inactive successfully.');
        return response()->json(['status' => true]);
    }


    /**
     * Save member data (shared between store and update)
     */
    private function saveMemberData($member, $request)
    {
        // Personal Information
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->middle_name = $request->middle_name;
        $member->suffix = $request->suffix;
        $member->sex = $request->sex;
        $member->birthdate = $request->birthdate;
        $member->civil_status = $request->civil_status;
        $member->citizenship = $request->citizenship;
        $member->blood_type = $request->blood_type;

        // Contact Information
        $member->cellphone_no = $request->cellphone_no;
        $member->telephone_no = $request->telephone_no;
        $member->email_address = $request->email_address;

        // Emergency Contact
        $member->emergency_contact = $request->emergency_contact;
        $member->emergency_contact_number = $request->emergency_contact_number;
        $member->relationship = $request->relationship;

        // Membership Information
        $member->rec_number = $request->rec_number;
        $member->membership_type_id = $request->membership_type_id;
        $member->section_id = $request->section_id;
        $member->membership_start = $request->membership_start;
        $member->membership_end = $request->is_lifetime_member ? null : $request->membership_end;
        $member->is_lifetime_member = $request->is_lifetime_member ?? false;
        $member->last_renewal_date = $request->last_renewal_date ?? now();
        $member->status = $request->status;

        // License Information
        $member->license_class = $request->license_class;
        $member->license_number = $request->license_number;
        $member->callsign = $request->callsign;
        $member->license_expiration_date = $request->license_expiration_date;

        // Address Information
        $member->house_building_number_name = $request->house_building_number_name;
        $member->street_address = $request->street_address;
        $member->zip_code = $request->zip_code;
        $member->region = $request->region;
        $member->province = $request->province;
        $member->municipality = $request->municipality;
        $member->barangay = $request->barangay;

        // Only set applicant_id on create
        if (!$member->exists && $request->applicant_id) {
            $member->applicant_id = $request->applicant_id;
        }

        $member->save();
    }


    public function membershipValidity(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::with(['membershipType'])
                ->select('id', 'first_name', 'last_name', 'membership_end', 'is_lifetime_member', 'membership_type_id');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('status', function($row) {
                    if ($row->is_lifetime_member) {
                        return '<span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Lifetime</span>';
                    }
                    
                    $now = now();
                    $end = Carbon::parse($row->membership_end);
                    
                    if ($now->gt($end)) {
                        return '<span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Expired</span>';
                    } else {
                        return '<span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">Active</span>';
                    }
                })
                ->addColumn('days_left', function($row) {
                    if ($row->is_lifetime_member) {
                        return '∞';
                    }
                    
                    $now = now();
                    $end = Carbon::parse($row->membership_end);
                    
                    if ($now->gt($end)) {
                        return 'Expired ' . $now->diffInDays($end) . ' days ago';
                    } else {
                        return $now->diffInDays($end) . ' days';
                    }
                })
                ->editColumn('membershipType.name', function($row) {
                    return $row->membershipType->name;
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        
        return view('members.validity');
    }

    public function showRenewalForm(Member $member)
    {
        return view('members.renew', [
            'member' => $member,
            // Calculate default values for the form
            'default_years' => 1,
            'default_months' => 0,
            'default_days' => 0
        ]);
    }

    public function processRenewal(Request $request, Member $member)
    {
        // Validate request input
        $validated = $request->validate([
            'years' => 'required|integer|min:0',
            'months' => 'required|integer|min:0|max:11',
            'days' => 'required|integer|min:0|max:31',
        ]);




        // Cast values to integers to ensure Carbon receives correct types
        $years = (int) $validated['years'];
        $months = (int) $validated['months'];
        $days = (int) $validated['days'];

        // Check if at least one duration is provided
        $totalDays = ($years * 365) + ($months * 30) + $days;
        if ($totalDays <= 0) {
            return redirect()->back()
                ->with('error', 'Please specify a valid renewal duration.')
                ->withInput();
        }

        // Determine the base start date: future expiration or today
        $startDate = $member->membership_end && Carbon::parse($member->membership_end)->isFuture()
            ? Carbon::parse($member->membership_end)
            : now();

        // Compute the new expiration date
        $newExpiration = $startDate->copy()
            ->addYears($years)
            ->addMonths($months)
            ->addDays($days);

        // Update the member record
        $member->update([
            'is_lifetime_member' => false,
            'membership_end' => $newExpiration,
            'last_renewal_date' => now()
        ]);

        return redirect()->route('members.index', $member->id)
            ->with('success', 'Membership successfully renewed until ' . $newExpiration->format('M d, Y'));
    }

    public function getApplicantData($id)
    {
        $applicant = Applicant::find($id);
        
        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }

        return response()->json([
            // Personal Info
            'first_name' => $applicant->first_name,
            'middle_name' => $applicant->middle_name,
            'last_name' => $applicant->last_name,
            'suffix' => $applicant->suffix,
            'sex' => $applicant->sex,
            'birthdate' => $applicant->birthdate,
            'civil_status' => $applicant->civil_status,
            'citizenship' => $applicant->citizenship,
            'blood_type' => $applicant->blood_type,

            // Contact
            'cellphone_no' => $applicant->cellphone_no,
            'telephone_no' => $applicant->telephone_no,
            'email_address' => $applicant->email_address,

            // Emergency
            'emergency_contact' => $applicant->emergency_contact,
            'emergency_contact_number' => $applicant->emergency_contact_number,
            'relationship' => $applicant->relationship,

            // License  
            'license_class' => $applicant->license_class,
            'license_number' => $applicant->license_number,
            'callsign' => $applicant->callsign,
            'license_expiration_date' => $applicant->license_expiration_date,

            // Address
            'house_building_number_name' => $applicant->house_building_number_name,
            'street_address' => $applicant->street_address,
            'zip_code' => $applicant->zip_code,
            'region' => $applicant->region,
            'province' => $applicant->province,
            'municipality' => $applicant->municipality,
            'barangay' => $applicant->barangay,
        ]);
    }

    public function active(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::where('status', 'Active')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('email_address', fn($row) => $row->email_address)
                ->addColumn('cellphone_no', fn($row) => $row->cellphone_no)
                ->addColumn('membership_start', function($row) {
                    return $row->membership_start ? \Carbon\Carbon::parse($row->membership_start)->format('M d, Y') : '';
                })
                ->addColumn('membership_end', function($row) {
                    return $row->membership_end ? \Carbon\Carbon::parse($row->membership_end)->format('M d, Y') : '';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('members.edit', $row->id) . '" 
                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition"
                        title="Edit Member">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('members.active');
    }

    public function inactive(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::where('status', 'Inactive')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('email_address', fn($row) => $row->email_address)
                ->addColumn('cellphone_no', fn($row) => $row->cellphone_no)
                ->addColumn('membership_start', function($row) {
                    return $row->membership_start ? \Carbon\Carbon::parse($row->membership_start)->format('M d, Y') : '';
                })
                ->addColumn('membership_end', function($row) {
                    return $row->membership_end ? \Carbon\Carbon::parse($row->membership_end)->format('M d, Y') : '';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('members.edit', $row->id) . '" 
                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition"
                        title="Edit Member">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('members.inactive');
    }

    public function deactivate(Request $request)
    {
        $member = Member::findOrFail($request->id);
        $member->status = 'inactive';
        $member->save();

        return response()->json(['status' => true, 'message' => 'Member deactivated.']);
    }

    public function reactivate(Request $request)
    {
        $member = Member::findOrFail($request->id);
        $member->status = 'active';
        $member->save();

        return response()->json(['status' => true, 'message' => 'Member reactivated.']);
    }

}