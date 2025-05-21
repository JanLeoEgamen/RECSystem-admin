<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    private function getRegions()
    {
        return DB::table('ref_psgc_region')->select('psgc_reg_code', 'psgc_reg_desc')->get();
    }

    public function showApplicantCreateForm()
    {
        $regions = $this->getRegions();
        return view('applicants.create', compact('regions'));
    }

    public function showApplicantEditForm($id)
    {
        $regions = $this->getRegions();
        $applicant = DB::table('applicants')->where('id', $id)->first();
        // You can also load applicant data here if needed
        return view('applicants.edit', compact('regions', 'applicant'));
    }

    public function showMemberCreateForm()
    {
        $regions = $this->getRegions();
        return view('members.create', compact('regions'));
    }

    public function showMemberEditForm($id)
    {
        $regions = $this->getRegions();
        $member = DB::table('members')->where('id', $id)->first();
        $membershipTypes = DB::table('membership_types')->get();
        $sections = DB::table('sections')->get();
        
        // You can also load member data here if needed
        return view('members.edit', compact('regions', 'member', 'membershipTypes', 'sections'));
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
