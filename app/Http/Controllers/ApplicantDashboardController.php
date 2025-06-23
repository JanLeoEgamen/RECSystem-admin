<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSubmittedSuccessfully;
use App\Models\Applicant;
use Illuminate\Http\Request;
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
        $applicant = Applicant::where('user_id', auth()->id())->first();

        // Redirect if applicant is still pending
        if ($applicant && $applicant->status === 'Pending') {
            return redirect()->route('applicant.thankyou');
        }

        // Load regions only if the applicant is approved
        $regions = DB::table('ref_psgc_region')
            ->select('psgc_reg_code', 'psgc_reg_desc')
            ->get();

        return view('applicant.applicant-dashboard', compact('regions'));
    }

    public function store(Request $request)
    {
        Log::info('Raw request data:', $request->all());

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
            'hasLicense' => 'nullable|string',
            'licenseClass' => 'required_if:hasLicense,on|nullable|string|max:100',
            'licenseNumber' => 'required_if:hasLicense,on|nullable|string|max:100',
            'expirationDate' => 'required_if:hasLicense,on|nullable|date',
            'isStudent' => 'nullable|string',
            'gcashRefNumber' => 'required|string|max:100',
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
                'payment_proof_path' => $paymentProofPath,
                'status' => 'Pending',
                'payment_status' => 'pending', // Default status for new applicants
                'user_id' => auth()->user()->id ?? 1, // Replace 1 with appropriate fallback or make this dynamic
                'is_student' => $request->has('isStudent') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Log::info('Prepared data for insertion:', $data);

            // Insert data into the database using Eloquent to get the model instance
            $applicant = \App\Models\Applicant::create($data);

            Mail::to($validatedData['email'])->send(new ApplicationSubmittedSuccessfully($applicant));

            if ($applicant) {
                Log::info('Data successfully inserted into database');
                return redirect()->route('applicant.thankyou')->with('success', 'Application submitted successfully!');
            } else {
                Log::error('Database insertion failed without error');
                return redirect()->back()
                    ->with('error', 'Failed to submit application. Please try again.')
                    ->withInput();
            }

        } catch (\Exception $e) {
            Log::error('Database insertion error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Failed to submit application. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function applicationSent()
    {
        return view('applicant.thankyou');
    }

    public function getProvinces($region_code)
    {
        $provinces = DB::table('ref_psgc_province')
            ->where('psgc_reg_code', $region_code)
            ->select('psgc_prov_code', 'psgc_prov_desc')
            ->get();

        return response()->json($provinces);
    }

    public function getMunicipalities($region_code, $province_code)
    {
        $municipalities = DB::table('ref_psgc_municipality')
            ->where('psgc_reg_code', $region_code)
            ->where('psgc_prov_code', $province_code)
            ->select('psgc_munc_code', 'psgc_munc_desc')
            ->get();

        return response()->json($municipalities);
    }

    public function getBarangays($region_code, $province_code, $municipality_code)
    {
        $barangays = DB::table('ref_psgc_barangay')
            ->where('psgc_reg_code', $region_code)
            ->where('psgc_prov_code', $province_code)
            ->where('psgc_munc_code', $municipality_code)
            ->select('psgc_brgy_code', 'psgc_brgy_desc')
            ->get();

        return response()->json($barangays);
    }
    



}