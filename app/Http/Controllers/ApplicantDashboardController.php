<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSubmittedSuccessfully;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApplicantDashboardController extends Controller implements HasMiddleware
{   
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', 'role:Applicant']),
        ];
    }

    /**
     * Display the applicant dashboard.
     */

    public function index() 
    {
        $applicant = Applicant::where('user_id', Auth::user()->id)->first();

        // Redirect to thank you page only if application is pending AND payment is verified
        if ($applicant && $applicant->status === 'Pending' && $applicant->payment_status === 'verified') {
            return redirect()->route('applicant.thankyou');
        }

        // Load regions
        $regions = DB::table('ref_psgc_region')
            ->select('PSGC_REG_CODE', 'PSGC_REG_DESC')
            ->get();

        // For rejected/refunded payments, allow access to form with pre-populated data
        if ($applicant && in_array($applicant->payment_status, ['rejected', 'refunded'])) {
            // Load the specific province, municipality, and barangay data
            $province = null;
            $municipality = null;
            $barangay = null;
            
            if ($applicant->region) {
                $province = DB::table('ref_psgc_province')
                    ->where('PSGC_PROV_CODE', $applicant->province)
                    ->first();
                    
                if ($applicant->province && $province) {
                    $municipality = DB::table('ref_psgc_municipality')
                        ->where('PSGC_MUNC_CODE', $applicant->municipality)
                        ->first();
                        
                    if ($applicant->municipality && $municipality) {
                        $barangay = DB::table('ref_psgc_barangay')
                            ->where('PSGC_BRGY_CODE', $applicant->barangay)
                            ->first();
                    }
                }
            }

            // Pass all data to the view
            return view('applicant.applicant-dashboard', compact('regions', 'applicant', 'province', 'municipality', 'barangay'));
        }

        // For new applicants or other cases
        return view('applicant.applicant-dashboard', compact('regions', 'applicant'));
    }

    public function store(Request $request)
    {
        Log::info('Raw request data:', $request->all());
        Log::info('Request headers:', $request->headers->all());
        Log::info('Request all data:', $request->all());
        Log::info('Request files:', $request->file() ? array_keys($request->file()) : ['no files']);

        // Check if this is a resubmission for rejected/refunded payment
        $existingApplicant = Applicant::where('user_id', Auth::user()->id)->first();
        $isResubmission = $existingApplicant && in_array($existingApplicant->payment_status, ['rejected', 'refunded']);

        // Validate the request data
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'sex' => 'required|string|max:10',
            'date' => 'required|date',
            'civilStatus' => 'required|string|max:20',
            'bloodType' => 'nullable|string|max:5',
            'citizenship' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'cellphone' => 'required|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'emergencyName' => 'required|string|max:255',
            'emergencyContact' => 'required|string|max:20',
            'emergencyRelationship' => 'required|string|max:100',
            'houseNumber' => 'required|string|max:255',
            'streetAddress' => 'required|string|max:255',
            'region' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'zipCode' => 'required|string|max:10',
            'hasLicense' => 'nullable|string|in:on,0',
            'licenseClass' => 'required_if:hasLicense,on|nullable|string|max:100',
            'licenseNumber' => 'required_if:hasLicense,on|nullable|string|max:100',
            'expirationDate' => 'required_if:hasLicense,on|nullable|date',
            'isStudent' => 'nullable|string',
            'gcashRefNumber' => 'required|string|max:100',
            'gcashAccountName' => 'required|string|max:255',
            'gcashAccountNumber' => 'required|string|regex:/^09[0-9]{9}$/', 
            'paymentProof' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $regionName = DB::table('ref_psgc_region')
                ->where('psgc_reg_code', $validatedData['region'])
                ->value('psgc_reg_code');

            $provinceName = DB::table('ref_psgc_province')
                ->where('psgc_prov_code', $validatedData['province'])
                ->value('psgc_prov_code');

            $municipalityName = DB::table('ref_psgc_municipality')
                ->where('psgc_munc_code', $validatedData['municipality'])
                ->value('psgc_munc_code');

            $barangayName = DB::table('ref_psgc_barangay')
                ->where('psgc_brgy_code', $validatedData['barangay'])
                ->value('psgc_brgy_code');

            // Handle file upload
                if ($request->hasFile('paymentProof')) {
                $file = $request->file('paymentProof');
                $filename = uniqid('receipt_') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/payment_proofs'), $filename);
                
                // Store ONLY the filename
                $paymentProofPath = $filename; // Just "receipt_123abc.png"
            }

            // Prepare data for insertion
            $data = [
                'first_name' => $validatedData['firstName'],
                'middle_name' => $validatedData['middleName'],
                'last_name' => $validatedData['lastName'],
                'suffix' => $validatedData['suffix'],
                'sex' => $validatedData['sex'],
                'birthdate' => $validatedData['date'],
                'civil_status' => $validatedData['civilStatus'],
                'blood_type' => $validatedData['bloodType'],
                'citizenship' => $validatedData['citizenship'],
                'email_address' => $validatedData['email'],
                'cellphone_no' => $validatedData['cellphone'],
                'telephone_no' => $validatedData['telephone'],
                'emergency_contact' => $validatedData['emergencyName'],
                'emergency_contact_number' => $validatedData['emergencyContact'],
                'relationship' => $validatedData['emergencyRelationship'],
                'house_building_number_name' => $validatedData['houseNumber'],
                'street_address' => $validatedData['streetAddress'],
                'zip_code' => $validatedData['zipCode'],
                'region' => $regionName,
                'province' => $provinceName,
                'municipality' => $municipalityName,
                'barangay' => $barangayName,
                'has_license' => $request->has('hasLicense') ? 1 : 0,
                'license_class' => $validatedData['licenseClass'] ?? null,
                'license_number' => $validatedData['licenseNumber'] ?? null,
                'license_expiration_date' => $validatedData['expirationDate'] ?? null,
                'reference_number' => $validatedData['gcashRefNumber'],
                'gcash_name' => $validatedData['gcashAccountName'],
                'gcash_number' => $validatedData['gcashAccountNumber'],
                'payment_proof_path' => $paymentProofPath,
                'status' => 'Pending',
                'payment_status' => 'pending', // Default status for new applicants
                'user_id' => Auth::user()->id,
                'is_student' => $request->has('isStudent') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Log::info('Prepared data for insertion:', $data);
            if ($isResubmission) {
                // Update existing applicant record
                $existingApplicant->update($data);
                $applicant = $existingApplicant;
                Log::info('Existing applicant updated for resubmission:', ['applicant_id' => $applicant->id]);
            } else {
                // Insert new data into the database using Eloquent to get the model instance
                $applicant = \App\Models\Applicant::create($data);
                Log::info('New applicant created:', ['applicant_id' => $applicant->id]);
            }

            Mail::to($validatedData['email'])->send(new ApplicationSubmittedSuccessfully($applicant));

            if ($applicant) {
                Log::info('Data successfully inserted into database');
                
                if ($request->ajax()) {
                    return response()->json([
                        'redirect' => route('applicant.thankyou')
                    ]);
                }
                
                return redirect()->route('applicant.thankyou')->with('success', 'Application submitted successfully!');
            } else {
                Log::error('Database insertion failed without error');
                
                if ($request->ajax()) {
                    return response()->json([
                        'error' => 'Failed to submit application. Please try again.'
                    ], 500);
                }
                
                return redirect()->back()
                    ->with('error', 'Failed to submit application. Please try again.')
                    ->withInput();
            }

        } catch (\Exception $e) {
            Log::error('Database insertion error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            
            // Handle validation errors specifically
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                if ($request->ajax()) {
                    return response()->json([
                        'message' => 'Validation failed.',
                        'errors' => $e->errors(),
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to submit application. Error: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to submit application. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function applicationSent()
    {
        $applicant = Applicant::where('user_id', Auth::user()->id)->first();
        
        // If payment was rejected, redirect back to form
        if ($applicant && in_array($applicant->payment_status, ['rejected', 'refunded'])) {
            return redirect()->route('applicant.dashboard');
        }
        
        return view('applicant.thankyou');
    }

    public function getProvinces($region_code)
    {
        $provinces = DB::table('ref_psgc_province')
            ->where('PSGC_REG_CODE', $region_code)
            ->select('PSGC_PROV_CODE', 'PSGC_PROV_DESC')
            ->get();

        return response()->json($provinces);
    }

    public function getMunicipalities($region_code, $province_code)
    {
        $municipalities = DB::table('ref_psgc_municipality')
            ->where('PSGC_REG_CODE', $region_code)
            ->where('PSGC_PROV_CODE', $province_code)
            ->select('PSGC_MUNC_CODE', 'PSGC_MUNC_DESC')
            ->get();

        return response()->json($municipalities);
    }

    public function getBarangays($region_code, $province_code, $municipality_code)
    {
        $barangays = DB::table('ref_psgc_barangay')
            ->where('PSGC_REG_CODE', $region_code)
            ->where('PSGC_PROV_CODE', $province_code)
            ->where('PSGC_MUNC_CODE', $municipality_code)
            ->select('PSGC_BRGY_CODE', 'PSGC_BRGY_DESC')
            ->get();

        return response()->json($barangays);
    }
    



}