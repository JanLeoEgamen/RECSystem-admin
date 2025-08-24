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
        $totalMembers = (clone $memberQuery)->count();

        $activeMembers = (clone $memberQuery)->where('status', 'Active')
            ->where(function ($query) {
                $query->where('is_lifetime_member', true)
                    ->orWhere('membership_end', '>=', now());
            })->count();

        $inactiveMembers = $totalMembers - $activeMembers;

        $expiringSoon = (clone $memberQuery)->where('is_lifetime_member', false)
            ->whereBetween('membership_end', [now(), now()->addDays(30)])
            ->count();

        $expiringSoonMembers = (clone $memberQuery)->where('is_lifetime_member', false)
            ->whereBetween('membership_end', [now(), now()->addDays(30)])
            ->orderBy('membership_end')
            ->take(5)
            ->get();

        $recentMembers = (clone $memberQuery)->latest()->take(5)->get();

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
            
        $pendingApplicants = Applicant::where('status', 'Pending')->count();
        $approvedThisMonth = Applicant::where('status', 'Approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        $applicantsThisWeek = [];
        $applicantsLastWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $day = now()->startOfWeek()->addDays($i);
            $applicantsThisWeek[] = Applicant::whereDate('created_at', $day)->count();
        }

        for ($i = 0; $i < 7; $i++) {
            $day = now()->subWeek()->startOfWeek()->addDays($i);
            $applicantsLastWeek[] = Applicant::whereDate('created_at', $day)->count();
        }

        $applicantGrowthRate = 0;
            if (count($applicantsLastWeek) > 0 && $applicantsLastWeek[6] > 0) {
                $applicantGrowthRate = (($applicantsThisWeek[6] - $applicantsLastWeek[6]) / $applicantsLastWeek[6]) * 100;
            } else if (count($applicantsLastWeek) > 0 && $applicantsLastWeek[6] == 0 && $applicantsThisWeek[6] > 0) {

                $applicantGrowthRate = 100;
            }

        $lastMonthApproved = Applicant::where('status', 'Approved')
            ->whereMonth('updated_at', now()->subMonth()->month)
            ->whereYear('updated_at', now()->subMonth()->year)
            ->count();

        $approvalGrowthRate = 0;
            if ($lastMonthApproved > 0) {
                $approvalGrowthRate = (($approvedThisMonth - $lastMonthApproved) / $lastMonthApproved) * 100;
            } else if ($lastMonthApproved == 0 && $approvedThisMonth > 0) {
                $approvalGrowthRate = 100;
            }   


        return view('dashboard', [
            'fullName' => $fullName,
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'inactiveMembers' => $inactiveMembers,
            'expiringSoon' => $expiringSoon,
            'recentMembers' => $recentMembers,
            'expiringSoonMembers' => $expiringSoonMembers,
            'monthlyData' => $allMonthsData,
            'monthlyActiveData' => $allMonthsActiveData,
            'monthlyInactiveData' => $allMonthsInactiveData,
            'monthlyExpiringData' => $allMonthsExpiringData,
            'membershipTypeCounts' => $membershipTypeCounts,
            'sectionCounts' => $sectionCounts,
            'pendingApplicants' => $pendingApplicants,
            'approvedThisMonth' => $approvedThisMonth,
            'applicantsThisWeek' => $applicantsThisWeek,
            'applicantsLastWeek' => $applicantsLastWeek,
            'applicantGrowthRate' => $applicantGrowthRate,
            'approvalGrowthRate' => $approvalGrowthRate,
        ]);
    }
}