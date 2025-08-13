<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\MembershipType;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
{
    private function getRegions()
    {
        try {
            return DB::table('ref_psgc_region')
                ->select('psgc_reg_code', 'psgc_reg_desc')
                ->orderBy('psgc_reg_desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Failed to fetch regions: ' . $e->getMessage());
            return collect();
        }
    }

    public function showApplicantCreateForm()
    {
        try {
            $regions = $this->getRegions();
            return view('applicants.create', compact('regions'));
        } catch (\Exception $e) {
            Log::error('Applicant create form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load applicant creation form. Please try again.');
        }
    }

    public function showApplicantEditForm($id)
    {
        try {
            $regions = $this->getRegions();
            $applicant = Applicant::findOrFail($id); // Using Eloquent for better error handling
            
            return view('applicants.edit', compact('regions', 'applicant'));
        } catch (ModelNotFoundException $e) {
            Log::warning("Applicant not found for editing: {$id}");
            return redirect()->route('applicants.index')->with('error', 'Applicant not found.');
        } catch (\Exception $e) {
            Log::error('Applicant edit form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load applicant edit form. Please try again.');
        }
    }

    public function showMemberCreateForm()
    {
        try {
            $regions = $this->getRegions();
            $applicants = Applicant::where('status', 'Pending')->get();
            $membershipTypes = MembershipType::all();
            $sections = Section::all();

            return view('members.create', compact('regions', 'applicants', 'membershipTypes', 'sections'));
        } catch (\Exception $e) {
            Log::error('Member create form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load member creation form. Please try again.');
        }
    }

    public function showMemberEditForm($id)
    {
        try {
            $regions = $this->getRegions();
            $member = DB::table('members')->find($id);
            
            if (!$member) {
                throw new ModelNotFoundException("Member not found: {$id}");
            }

            $membershipTypes = MembershipType::all(); // Using Eloquent instead of DB facade
            $sections = Section::all();
            $applicants = Applicant::all();

            return view('members.edit', compact('regions', 'member', 'membershipTypes', 'sections', 'applicants'));
        } catch (ModelNotFoundException $e) {
            Log::warning("Member not found for editing: {$id}");
            return redirect()->route('members.index')->with('error', 'Member not found.');
        } catch (\Exception $e) {
            Log::error('Member edit form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load member edit form. Please try again.');
        }
    }

    public function getProvinces($region_code)
    {
        try {
            $provinces = DB::table('ref_psgc_province')
                ->where('psgc_reg_code', $region_code)
                ->select('psgc_prov_code', 'psgc_prov_desc')
                ->orderBy('psgc_prov_desc')
                ->get();

            return response()->json($provinces);
        } catch (\Exception $e) {
            Log::error("Failed to fetch provinces for region {$region_code}: " . $e->getMessage());
            return response()->json(['error' => 'Failed to load provinces'], 500);
        }
    }

    public function getMunicipalities($region_code, $province_code)
    {
        try {
            $municipalities = DB::table('ref_psgc_municipality')
                ->where('psgc_reg_code', $region_code)
                ->where('psgc_prov_code', $province_code)
                ->select('psgc_munc_code', 'psgc_munc_desc')
                ->orderBy('psgc_munc_desc')
                ->get();

            return response()->json($municipalities);
        } catch (\Exception $e) {
            Log::error("Failed to fetch municipalities for region {$region_code} and province {$province_code}: " . $e->getMessage());
            return response()->json(['error' => 'Failed to load municipalities'], 500);
        }
    }

    public function getBarangays($region_code, $province_code, $municipality_code)
    {
        try {
            $barangays = DB::table('ref_psgc_barangay')
                ->where('psgc_reg_code', $region_code)
                ->where('psgc_prov_code', $province_code)
                ->where('psgc_munc_code', $municipality_code)
                ->select('psgc_brgy_code', 'psgc_brgy_desc')
                ->orderBy('psgc_brgy_desc')
                ->get();

            return response()->json($barangays);
        } catch (\Exception $e) {
            Log::error("Failed to fetch barangays for region {$region_code}, province {$province_code}, municipality {$municipality_code}: " . $e->getMessage());
            return response()->json(['error' => 'Failed to load barangays'], 500);
        }
    }
}