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

class StudentApplicantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return[
            new Middleware('permission:view student applicants', only: ['index', 'show']),
            new Middleware('permission:assess student applicants', only: ['assess']),
        ];
    }

    /**
     * Display a listing of student applicants.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('status', 'Pending')
                            ->where('is_student', true);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%")
                    ->orWhere('student_number', 'like', "%$search%")
                    ->orWhere('school', 'like', "%$search%");
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

                    case 'school':
                        $query->orderBy('school', $direction);
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
                    'school' => $applicant->school ?? 'N/A',
                    'student_number' => $applicant->student_number ?? 'N/A',
                    'created_at' => $applicant->created_at->format('d M, Y'),
                    'can_view' => request()->user()->can('view student applicants'),
                    'can_assess' => request()->user()->can('assess student applicants'),
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
        
        return view('student-applicants.list');
    }

    /**
     * Display the specified student applicant.
     */
    public function show(string $id)
    {
        $applicant = Applicant::where('is_student', true)->findOrFail($id);

        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $applicant->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $applicant->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $applicant->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $applicant->barangay)->value('psgc_brgy_desc');

        return view('student-applicants.view', [
            'applicant' => $applicant,
            'regionName' => $regionName,
            'provinceName' => $provinceName,
            'municipalityName' => $municipalityName,
            'barangayName' => $barangayName,
        ]);
    }

    /**
     * Show the assessment form for student applicant.
     */
    public function assess(string $id)
    {
        $applicant = Applicant::where('is_student', true)->findOrFail($id);
        $membershipTypes = MembershipType::all();
        $sections = Section::whereHas('bureau', function($query) {
            $query->whereIn('bureau_name', ['Student']);
        })->get();
        
        // Get the names from reference tables using the stored codes
        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $applicant->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $applicant->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $applicant->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $applicant->barangay)->value('psgc_brgy_desc');

        
        return view('student-applicants.assess', [
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
     * Approve student applicant and create member record.
     */
    public function approve(Request $request, string $id)
    {
        $applicant = Applicant::where('is_student', true)->findOrFail($id);

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
            return redirect()->route('student-applicants.assess', $id)
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
                'is_lifetime' => $member->is_lifetime_member,
                'student_applicant' => true
            ]
        );

   
        MemberActivityLog::where('applicant_id', $applicant->id)
            ->update(['member_id' => $member->id]);


        if ($user) {
            logMemberActivity(
                $member,
                'role_change',
                'updated',
                "Student applicant role converted to Member",
                [
                    'old_roles' => ['Applicant'],
                    'new_roles' => $user->getRoleNames()->toArray()
                ]
            );
        }

        // Send email
        Mail::to($applicant->email_address)->send(new ApplicantApprovedMail($member));

        return redirect()->route('student-applicants.index')
                        ->with('success', 'Student applicant approved and member created successfully');
    }

    /**
     * Reject student applicant.
     */
    public function reject(string $id)
    {
        $applicant = Applicant::where('is_student', true)->findOrFail($id);
        $applicant->update(['status' => 'Rejected']);

        Mail::to($applicant->email_address)->send(new ApplicantRejectedMail($applicant));
        
        return redirect()->route('student-applicants.index')
                        ->with('success', 'Student applicant has been rejected');
    }

    /**
     * Display a listing of rejected student applicants.
     */
    public function rejected(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('status', 'Rejected')
                            ->where('is_student', true);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%")
                    ->orWhere('student_number', 'like', "%$search%")
                    ->orWhere('school', 'like', "%$search%");
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

                    case 'school':
                        $query->orderBy('school', $direction);
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
                    'school' => $applicant->school ?? 'N/A',
                    'student_number' => $applicant->student_number ?? 'N/A',
                    'updated_at' => $applicant->updated_at->format('d M, Y'),
                    'can_view' => request()->user()->can('view student applicants'),
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
        
        return view('student-applicants.rejected');
    }

    /**
     * Restore a rejected student applicant.
     */
    public function restore(Request $request)
    {
        $id = $request->id;
        $applicant = Applicant::where('is_student', true)->findOrFail($id);
    
        // Validate the applicant is currently rejected
        if (strtolower($applicant->status) !== 'rejected') {
            session()->flash('error', 'Only rejected student applicants can be restored');
            return response()->json([
                'status' => false,
                'message' => 'Only rejected student applicants can be restored'
            ]);
        }
    
        $applicant->status = 'pending';
        $applicant->save();
    
        session()->flash('success', 'Student applicant restored to pending status successfully');
        return response()->json([
            'status' => true,
            'message' => 'Student applicant restored to pending status successfully'
        ]);
    }

    /**
     * Display a listing of approved student applicants.
     */
    public function approved(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('status', 'Approved')
                            ->where('is_student', true);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('cellphone_no', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%")
                    ->orWhere('student_number', 'like', "%$search%")
                    ->orWhere('school', 'like', "%$search%");
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

                    case 'school':
                        $query->orderBy('school', $direction);
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
                    'school' => $applicant->school ?? 'N/A',
                    'student_number' => $applicant->student_number ?? 'N/A',
                    'updated_at' => $applicant->updated_at->format('d M, Y'),
                    'can_view' => request()->user()->can('view student applicants'),
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
        
        return view('student-applicants.approved');
    }
}