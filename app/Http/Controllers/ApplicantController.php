<?php

namespace App\Http\Controllers;

use App\Mail\ApplicantApprovedMail;
use App\Mail\ApplicantRejectedMail;
use App\Models\Applicant;
use App\Models\Member;
use App\Models\MemberActivityLog;
use App\Models\MembershipType;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ApplicantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return[
            new Middleware('permission:view applicants', only: ['index', 'show']),
            new Middleware('permission:edit applicants', only: ['edit']),    
            new Middleware('permission:create applicants', only: ['create']),
            new Middleware('permission:delete applicants', only: ['destroy']),
            new Middleware('permission:assess applicants', only: ['assess']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
            if ($request->ajax()) {
                $query = Applicant::where('status', 'Pending')->where('is_student', false);

                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('middle_name', 'like', "%$search%")
                        ->orWhere('cellphone_no', 'like', "%$search%")
                        ->orWhere('email_address', 'like', "%$search%");
                    });
                }

                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'full_name':
                            $query->orderBy('last_name', $direction)
                                ->orderBy('first_name', $direction)
                                ->orderBy('middle_name', $direction);
                            break;
                            
                        case 'sex':
                            $query->orderBy('sex', $direction);
                            break;
                            
                        case 'birthdate':
                            $query->orderBy('birthdate', $direction);
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
                $applicants = $query->paginate($perPage);

                $transformedApplicants = $applicants->getCollection()->map(function ($applicant) {
                    $fullName = $applicant->first_name . ' ' . $applicant->last_name;
                    if ($applicant->middle_name) {
                        $fullName .= ' ' . $applicant->middle_name;
                    }
                    if ($applicant->suffix) {
                        $fullName .= ' ' . $applicant->suffix;
                    }

                    return [
                        'id' => $applicant->id,
                        'full_name' => $fullName,
                        'sex' => $applicant->sex,
                        'birthdate' => $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('d M, Y') : '',
                        'cellphone_no' => $applicant->cellphone_no,
                        'created_at' => $applicant->created_at->format('d M, Y'),
                        'can_view' => request()->user()->can('view applicants'),
                        'can_edit' => request()->user()->can('edit applicants'),
                        'can_delete' => request()->user()->can('delete applicants'),
                        'can_assess' => request()->user()->can('assess applicants'),
                    ];
                });

                return response()->json([
                    'data' => $transformedApplicants,
                    'current_page' => $applicants->currentPage(),
                    'last_page' => $applicants->lastPage(),
                    'from' => $applicants->firstItem(),
                    'to' => $applicants->lastItem(),
                    'total' => $applicants->total(),
                ]);
            }
            
            return view('applicants.list');
        }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('applicants.create');
    // }


    public function show(string $id)
    {
        $applicant = Applicant::findOrFail($id);

        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $applicant->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $applicant->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $applicant->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $applicant->barangay)->value('psgc_brgy_desc');

        return view('applicants.view', [
            'applicant' => $applicant,
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
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'sex' => 'required',
            'birthdate' => 'required|date',
            'civil_status' => 'required',
            'citizenship' => 'required',
            'email_address' => 'required|email',
            'cellphone_no' => 'required',
            'emergency_contact' => 'required',
            'emergency_contact_number' => 'required',
            'relationship' => 'required',
            'house_building_number_name' => 'required',
            'street_address' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'zip_code' => 'required',
            'gcash_name' => 'required|string|max:255',
            'gcash_number' => 'required|string|regex:/^09[0-9]{9}$/',
        ]);

        // if ($validator->fails()) {
        //     return redirect()->route('applicants.create')->withInput()->withErrors($validator);
        // }

        $applicant = new Applicant();
        $applicant->status = 'Pending';
        $this->saveApplicantData($applicant, $request);

        return redirect()->route('applicants.index')->with('success', 'Applicant added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('applicants.edit', ['applicant' => $applicant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $applicant = Applicant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'sex' => 'required',
            'birthdate' => 'required|date',
            'civil_status' => 'required',
            'citizenship' => 'required',
            'email_address' => 'required|email',
            'cellphone_no' => 'required',
            'emergency_contact' => 'required',
            'emergency_contact_number' => 'required',
            'relationship' => 'required',
            'house_building_number_name' => 'required',
            'street_address' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'zip_code' => 'required',
            'gcash_name' => 'required|string|max:255',
            'gcash_number' => 'required|string|regex:/^09[0-9]{9}$/',
        ]);

        if ($validator->fails()) {
            return redirect()->route('applicants.edit', $id)->withInput()->withErrors($validator);
        }

        $this->saveApplicantData($applicant, $request);

        return redirect()->route('applicants.index')->with('success', 'Applicant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $applicant = Applicant::findOrFail($id);

        if ($applicant == null) {
            session()->flash('error', 'Applicant not found.');
            return response()->json(['status' => false]);
        }

        $applicant->delete();

        session()->flash('success', 'Applicant deleted successfully.');
        return response()->json(['status' => true]);
    }


    /**
     * Show the assessment form.
     */
    public function assess(string $id)
    {
        $applicant = Applicant::findOrFail($id);
        $membershipTypes = MembershipType::all();
        $sections = Section::all();

        // Get the names from reference tables using the stored codes
        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $applicant->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $applicant->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $applicant->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $applicant->barangay)->value('psgc_brgy_desc');

        
        return view('applicants.assess', [
            'applicant' => $applicant,
            'membershipTypes' => $membershipTypes,
            'sections' => $sections,
            'regionName' => $regionName,
            'provinceName' => $provinceName,
            'municipalityName' => $municipalityName,
            'barangayName' => $barangayName,
        ]);
    }

    /**
     * Approve applicant and create member record.
     */
    public function approve(Request $request, string $id)
    {
        $applicant = Applicant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'rec_number' => 'required|unique:members,rec_number',
            'membership_type_id' => 'required|exists:membership_types,id',
            'section_id' => 'nullable|exists:sections,id',
            'membership_start' => 'required|date',
            'membership_end' => 'required_if:is_lifetime_member,0|date|after:membership_start',
            'is_lifetime_member' => 'boolean',
            'license_class' => 'nullable',
            'license_number' => 'nullable',
            'callsign' => 'nullable',
            'license_expiration_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('applicants.assess', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        // Create member from applicant
        $member = new Member();
        $member->fill($applicant->toArray()); // Copy all applicant data
        
        // Add membership specific fields
        $member->rec_number = $request->rec_number;
        $member->membership_type_id = $request->membership_type_id;
        $member->section_id = $request->section_id;
        $member->membership_start = $request->membership_start;
        $member->membership_end = $request->is_lifetime_member ? null : $request->membership_end;
        $member->is_lifetime_member = $request->is_lifetime_member ?? false;
        $member->last_renewal_date = now();
        $member->license_class = $request->license_class;
        $member->license_number = $request->license_number;
        $member->callsign = $request->callsign;
        $member->license_expiration_date = $request->license_expiration_date;
        $member->status = "Active";
        $member->applicant_id = $applicant->id;
        
        $member->save();

        $applicant->status = 'Approved';
        $applicant->save(); 

        $user = User::where('email', $applicant->email_address)->first();

        if ($user) {
            if (!$user->hasRole('Member')) {
                $user->assignRole('Member');
            }

            if ($user->hasRole('Applicant')) {
                $user->removeRole('Applicant');
            }
        }
        
        logApplicantToMemberConversion(
            $applicant,
            $member,
            auth()->user(), 
            [
                'membership_start' => $member->membership_start,
                'is_lifetime' => $member->is_lifetime_member
            ]
        );

   
        MemberActivityLog::where('applicant_id', $applicant->id)
            ->update(['member_id' => $member->id]);


        if ($user) {
            logMemberActivity(
                $member,
                'role_change',
                'updated',
                "Applicant role converted to Member",
                [
                    'old_roles' => ['Applicant'],
                    'new_roles' => $user->getRoleNames()->toArray()
                ]
            );
        }

        // Send email
        Mail::to($applicant->email_address)->send(new ApplicantApprovedMail($member));

        return redirect()->route('applicants.index')
                        ->with('success', 'Applicant approved and member created successfully');
    }

    /**
     * Save applicant data (shared between store and update)
     */
    private function saveApplicantData($applicant, $request)
    {
        // Personal Information
        $applicant->first_name = $request->first_name;
        $applicant->last_name = $request->last_name;
        $applicant->middle_name = $request->middle_name;
        $applicant->suffix = $request->suffix;
        $applicant->sex = $request->sex;
        $applicant->birthdate = $request->birthdate;
        $applicant->civil_status = $request->civil_status;
        $applicant->citizenship = $request->citizenship;
        $applicant->blood_type = $request->blood_type;

        // Contact Information
        $applicant->cellphone_no = $request->cellphone_no;
        $applicant->telephone_no = $request->telephone_no;
        $applicant->email_address = $request->email_address;

        // Emergency Contact
        $applicant->emergency_contact = $request->emergency_contact;
        $applicant->emergency_contact_number = $request->emergency_contact_number;
        $applicant->relationship = $request->relationship;

        // License Information
        $applicant->license_class = $request->license_class;
        $applicant->license_number = $request->license_number;
        $applicant->callsign = $request->callsign;
        $applicant->license_expiration_date = $request->license_expiration_date;

        // Address Information
        $applicant->house_building_number_name = $request->house_building_number_name;
        $applicant->street_address = $request->street_address;
        $applicant->zip_code = $request->zip_code;
        $applicant->region = $request->region;
        $applicant->province = $request->province;
        $applicant->municipality = $request->municipality;
        $applicant->barangay = $request->barangay;

        $applicant->save();
    }

    public function reject(string $id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->update(['status' => 'Rejected']);

        Mail::to($applicant->email_address)->send(new ApplicantRejectedMail($applicant));
        
        return redirect()->route('applicants.index')
                        ->with('success', 'Applicant has been rejected');
    }

    /**
     * Display a listing of rejected applicants.
     */
    public function rejected(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('status', 'Rejected');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%");
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'full_name':
                        $query->orderBy('last_name', $direction)
                            ->orderBy('first_name', $direction)
                            ->orderBy('middle_name', $direction);
                        break;
                        
                    case 'sex':
                        $query->orderBy('sex', $direction);
                        break;
                        
                    case 'birthdate':
                        $query->orderBy('birthdate', $direction);
                        break;
                        
                    case 'created':
                    case 'created_at':
                        $query->orderBy('created_at', $direction);
                        break;

                    case 'updated':
                    case 'updated_at':
                        $query->orderBy('updated_at', $direction);
                        break;
                        
                    default:
                        $query->orderBy('updated_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('updated_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $applicants = $query->paginate($perPage);

            $transformedApplicants = $applicants->getCollection()->map(function ($applicant) {
                $fullName = $applicant->first_name . ' ' . $applicant->last_name;
                if ($applicant->middle_name) {
                    $fullName .= ' ' . $applicant->middle_name;
                }
                if ($applicant->suffix) {
                    $fullName .= ' ' . $applicant->suffix;
                }

                return [
                    'id' => $applicant->id,
                    'full_name' => $fullName,
                    'sex' => $applicant->sex,
                    'birthdate' => $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('d M, Y') : '',
                    'cellphone_no' => $applicant->cellphone_no,
                    'updated_at' => $applicant->updated_at->format('d M, Y'),
                    'can_view' => request()->user()->can('view applicants'),
                    'can_edit' => request()->user()->can('edit applicants'),
                ];
            });

            return response()->json([
                'data' => $transformedApplicants,
                'current_page' => $applicants->currentPage(),
                'last_page' => $applicants->lastPage(),
                'from' => $applicants->firstItem(),
                'to' => $applicants->lastItem(),
                'total' => $applicants->total(),
            ]);
        }
        
        return view('applicants.rejected');
    }


    public function approved(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('status', 'Approved');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%");
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'full_name':
                        $query->orderBy('last_name', $direction)
                            ->orderBy('first_name', $direction)
                            ->orderBy('middle_name', $direction);
                        break;
                        
                    case 'sex':
                        $query->orderBy('sex', $direction);
                        break;
                        
                    case 'birthdate':
                        $query->orderBy('birthdate', $direction);
                        break;
                        
                    case 'created':
                    case 'created_at':
                        $query->orderBy('created_at', $direction);
                        break;

                    case 'updated':
                    case 'updated_at':
                        $query->orderBy('updated_at', $direction);
                        break;
                        
                    default:
                        $query->orderBy('updated_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('updated_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $applicants = $query->paginate($perPage);

            $transformedApplicants = $applicants->getCollection()->map(function ($applicant) {
                $fullName = $applicant->first_name . ' ' . $applicant->last_name;
                if ($applicant->middle_name) {
                    $fullName .= ' ' . $applicant->middle_name;
                }
                if ($applicant->suffix) {
                    $fullName .= ' ' . $applicant->suffix;
                }

                return [
                    'id' => $applicant->id,
                    'full_name' => $fullName,
                    'sex' => $applicant->sex,
                    'birthdate' => $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('d M, Y') : '',
                    'cellphone_no' => $applicant->cellphone_no,
                    'updated_at' => $applicant->updated_at->format('d M, Y'),
                    'can_view' => request()->user()->can('view applicants'),
                ];
            });

            return response()->json([
                'data' => $transformedApplicants,
                'current_page' => $applicants->currentPage(),
                'last_page' => $applicants->lastPage(),
                'from' => $applicants->firstItem(),
                'to' => $applicants->lastItem(),
                'total' => $applicants->total(),
            ]);
        }
        
        return view('applicants.approved');
    }

    /**
     * Restore a rejected applicant.
     */
    public function restore(Request $request)
    {
        $id = $request->id;
        $applicant = Applicant::findOrFail($id);
    
        // Validate the applicant is currently rejected
        if (strtolower($applicant->status) !== 'rejected') {
            session()->flash('error', 'Only rejected applicants can be restored');
            return response()->json([
                'status' => false,
                'message' => 'Only rejected applicants can be restored'
            ]);

        }
    
        $applicant->status = 'pending';
        $applicant->save();
    
        session()->flash('success', 'Applicant restored to pending status successfully');
        return response()->json([
            'status' => true,
            'message' => 'Applicant restored to pending status successfully'
        ]);

    }

    
}