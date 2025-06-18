<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ApplicantDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified']),
        ];
    }

    /**
     * Display the applicant dashboard.
     */
    public function index()
    {
        $regions = DB::table('ref_psgc_region')->select('psgc_reg_code', 'psgc_reg_desc')->get();
        return view('applicant.dashboard', compact('regions'));
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