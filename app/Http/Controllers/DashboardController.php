<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Applicant;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view admin dashboard', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $fullName = $user->first_name . ' ' . $user->last_name;

        //NEWLY ADDED LOGIC THAT DASHBOARD CARDS AND CHARTS WILL BE FILTERED BASED ON USER'S ACCESSIBLE SECTIONS
        if ($user->hasRole('superadmin')) {
        // Superadmin sees all members without filtering
        $memberQuery = Member::query();
        } else {
            // Regular users see only members in their accessible sections
            $sectionIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNotNull('section_id')
                ->pluck('section_id');

            $bureauIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNull('section_id')
                ->pluck('bureau_id');

            $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
            $accessibleSectionIds = $sectionIds->merge($bureauSectionIds)->unique();

            $memberQuery = Member::whereIn('section_id', $accessibleSectionIds);
        }

        $totalMembers = (clone $memberQuery)->count();

       $activeMembers = (clone $memberQuery)
            ->where('status', 'Active')
            ->where(function ($query) {
                $query->where('is_lifetime_member', true)
                    ->orWhere('membership_end', '>=', now());
            })->count();
        
        $inactiveMembers = (clone $memberQuery)
            ->where('status', 'Inactive')
            ->count();
            
        $expiredMembers = (clone $memberQuery)
            ->where('status', 'Active')
            ->where('is_lifetime_member', false)
            ->where('membership_end', '<', now())
            ->count();
        
        $expiredMembers = (clone $memberQuery)
            ->where('status', 'Active')
            ->where('is_lifetime_member', false)
            ->where('membership_end', '<', now())
            ->count();
        
        $expiringSoon = (clone $memberQuery)->where('is_lifetime_member', false)
            ->whereBetween('membership_end', [now(), now()->addDays(30)])
            ->count();

        $expiringSoonMembers = (clone $memberQuery)->where('is_lifetime_member', false)
            ->whereBetween('membership_end', [now(), now()->addDays(30)])
            ->orderBy('membership_end')
            ->take(5)
            ->get();

        $recentMembers = (clone $memberQuery)->latest()->take(5)->get();

        // Get recent applicants for the table
        $recentApplicants = Applicant::latest()->take(6)->get();

        $monthlyData = (clone $memberQuery)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $allMonthsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonthsData[$i] = $monthlyData[$i] ?? 0;
        }

        $monthlyActiveData = (clone $memberQuery)
            ->where(function ($query) {
                $query->where('is_lifetime_member', true)
                    ->orWhere('membership_end', '>=', now());
            })
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $allMonthsActiveData = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonthsActiveData[$i] = $monthlyActiveData[$i] ?? 0;
        }

        $monthlyInactiveData = (clone $memberQuery)
            ->where('status', 'Inactive')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $allMonthsInactiveData = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonthsInactiveData[$i] = $monthlyInactiveData[$i] ?? 0;
        }

        $monthlyExpiringData = (clone $memberQuery)
            ->where('is_lifetime_member', false)
            ->whereBetween('membership_end', [now(), now()->addDays(30)])
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $allMonthsExpiringData = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonthsExpiringData[$i] = $monthlyExpiringData[$i] ?? 0;
        }

        $membershipTypeCounts = (clone $memberQuery)
            ->with('membershipType')
            ->select('membership_type_id', DB::raw('count(*) as total'))
            ->groupBy('membership_type_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->membershipType->type_name ?? 'Unknown' => $item->total];
            })
            ->toArray();

        $sectionCounts = (clone $memberQuery)
            ->with('section')
            ->select('section_id', DB::raw('count(*) as total'))
            ->groupBy('section_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->section->section_name ?? 'Unassigned' => $item->total];
            })
            ->toArray();

        return view('dashboard', [
            'fullName' => $fullName,
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'inactiveMembers' => $inactiveMembers,
            'expiredMembers' => $expiredMembers,
            'expiringSoon' => $expiringSoon,
            'recentMembers' => $recentMembers,
            'recentApplicants' => $recentApplicants,
            'expiringSoonMembers' => $expiringSoonMembers,
            'monthlyData' => $allMonthsData,
            'monthlyActiveData' => $allMonthsActiveData,
            'monthlyInactiveData' => $allMonthsInactiveData,
            'monthlyExpiringData' => $allMonthsExpiringData,
            'membershipTypeCounts' => $membershipTypeCounts,
            'sectionCounts' => $sectionCounts,
        ]);
    }
}