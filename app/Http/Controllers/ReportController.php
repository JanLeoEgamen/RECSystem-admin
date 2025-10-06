<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Applicant;
use App\Models\Bureau;
use App\Models\MembershipType;
use App\Models\Section;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Dompdf\Exception as DompdfException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view reports', only: ['index']),
            new Middleware('permission:view membership reports', only: ['membership']),
            new Middleware('permission:view applicant reports', only: ['applicants']),
            new Middleware('permission:view license reports', only: ['licenses']),
            new Middleware('permission:generate membership reports', only: ['membership']),
            new Middleware('permission:generate applicant reports', only: ['applicants']),
            new Middleware('permission:generate license reports', only: ['licenses']),
            new Middleware('permission:view custom reports', only: ['custom', 'customExport']),
            new Middleware('permission:generate custom reports', only: ['customExport']),
        ];
    }

    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get accessible section IDs based on user permissions
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Build queries with permission filtering
            $memberQuery = Member::query();
            $applicantQuery = Applicant::query();
            $sectionQuery = Section::query();
            
            if (!$user->can('view all members')) {
                $memberQuery->whereIn('section_id', $accessibleSectionIds);
                $applicantQuery->whereHas('member', function($q) use ($accessibleSectionIds) {
                    $q->whereIn('section_id', $accessibleSectionIds);
                });
                $sectionQuery->whereIn('id', $accessibleSectionIds);
            }

            $totalMembers = $memberQuery->count();
            $totalBureaus = Bureau::count(); // Bureaus are accessible to all
            $totalApplicants = $applicantQuery->count();
            $totalSections = $sectionQuery->count();

            // Get bureaus with their accessible sections
            $bureausWithSections = Bureau::with(['sections' => function($query) use ($user, $accessibleSectionIds) {
                if (!$user->can('view all members')) {
                    $query->whereIn('id', $accessibleSectionIds);
                }
            }])->get();

            // Filter out bureaus that have no accessible sections for limited users
            if (!$user->can('view all members')) {
                $bureausWithSections = $bureausWithSections->filter(function($bureau) {
                    return $bureau->sections && $bureau->sections->count() > 0;
                });
            }

            return view('reports.index', [
                'totalMembers' => $totalMembers,
                'totalBureaus' => $totalBureaus,
                'totalApplicants' => $totalApplicants,
                'totalSections' => $totalSections,
                'bureausWithSections' => $bureausWithSections,
            ]);

        } catch (QueryException $e) {
            Log::error('Database error in ReportController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not retrieve report data. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in ReportController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function membership(Request $request)
    {
        try {
            $user = Auth::user();
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Build base queries
            $memberQuery = Member::query();
            $bureauQuery = Bureau::query();
            
            if (!$user->can('view all members')) {
                $memberQuery->whereIn('section_id', $accessibleSectionIds);
            }

            // Summary statistics
            $totalMembers = $memberQuery->count();
            $activeMembers = $memberQuery->clone()->where('status', 'active')->count();
            $inactiveMembers = $totalMembers - $activeMembers;
            
            // Get bureaus with their sections and member counts
            $bureaus = $bureauQuery->with(['sections' => function($query) use ($user, $accessibleSectionIds) {
                    $query->withCount(['members as active_members_count' => function($q) {
                            $q->where('status', 'active');
                        }])
                        ->withCount(['members as inactive_members_count' => function($q) {
                            $q->where('status', 'inactive');
                        }])
                        ->withCount('members as total_members_count')
                        ->orderBy('section_name');
                        
                    if (!$user->can('view all members')) {
                        $query->whereIn('id', $accessibleSectionIds);
                    }
                }])
                ->withCount(['members as active_members_count' => function($q) use ($accessibleSectionIds, $user) {
                    $q->where('status', 'active');
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                }])
                ->withCount(['members as inactive_members_count' => function($q) use ($accessibleSectionIds, $user) {
                    $q->where('status', 'inactive');
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                }])
                ->withCount(['members as total_members_count' => function($q) use ($accessibleSectionIds, $user) {
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                }])
                ->withCount('sections')
                ->orderBy('bureau_name')
                ->get();

            // Calculate total sections count
            $totalSections = $bureaus->sum(function($bureau) {
                return $bureau->sections ? $bureau->sections->count() : 0;
            });

            // Get all members with their relationships
            $members = $memberQuery->with(['section.bureau', 'membershipType'])
                            ->orderBy('last_name')
                            ->orderBy('first_name')
                            ->get();

            // PDF Export
            if ($request->has('export') && $request->export === 'pdf') {
                try {
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->set('isHtml5ParserEnabled', true);
                    
                    $dompdf = new Dompdf($options);
                    $html = view('reports.membership-pdf', [
                        'totalMembers' => $totalMembers,
                        'activeMembers' => $activeMembers,
                        'inactiveMembers' => $inactiveMembers,
                        'bureaus' => $bureaus,
                        'members' => $members,
                        'totalSections' => $totalSections,
                    ])->render();
                    
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    
                    return $dompdf->stream("membership_report_".now()->format('Y-m-d').".pdf");

                } catch (DompdfException $e) {
                    Log::error('PDF generation failed in membership report: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to generate PDF. Please try again.');
                }
            }

            return view('reports.membership', [
                'totalMembers' => $totalMembers,
                'activeMembers' => $activeMembers,
                'inactiveMembers' => $inactiveMembers,
                'bureaus' => $bureaus,
                'members' => $members,
                'totalSections' => $totalSections,
            ]);

        } catch (QueryException $e) {
            Log::error('Database error in membership report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not retrieve membership data. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in membership report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while generating the membership report.');
        }
    }

    public function applicants(Request $request)
    {
        try {
            $user = Auth::user();
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Build base query
            $applicantQuery = Applicant::query();
            
            if (!$user->can('view all members')) {
                $applicantQuery->whereHas('member', function($q) use ($accessibleSectionIds) {
                    $q->whereIn('section_id', $accessibleSectionIds);
                });
            }

            // Total counts
            $totalApplicants = $applicantQuery->count();
            $approvedApplicants = $applicantQuery->clone()->where('status', 'approved')->count();
            $pendingApplicants = $applicantQuery->clone()->where('status', 'pending')->count();
            $rejectedApplicants = $applicantQuery->clone()->where('status', 'rejected')->count();

            // Get applicants grouped by status
            $approved = $applicantQuery->clone()->where('status', 'approved')
                ->with(['member.section.bureau', 'member.membershipType'])
                ->orderBy('created_at', 'desc')
                ->get();

            $pending = $applicantQuery->clone()->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            $rejected = $applicantQuery->clone()->where('status', 'rejected')
                ->orderBy('created_at', 'desc')
                ->get();

            // PDF Export
            if ($request->has('export') && $request->export === 'pdf') {
                try {
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->set('isHtml5ParserEnabled', true);
                    
                    $dompdf = new Dompdf($options);
                    $html = view('reports.applicants-pdf', [
                        'totalApplicants' => $totalApplicants,
                        'approvedApplicants' => $approvedApplicants,
                        'pendingApplicants' => $pendingApplicants,
                        'rejectedApplicants' => $rejectedApplicants,
                        'approved' => $approved,
                        'pending' => $pending,
                        'rejected' => $rejected,
                    ])->render();
                    
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    
                    return $dompdf->stream("applicants_report_".now()->format('Y-m-d').".pdf");

                } catch (DompdfException $e) {
                    Log::error('PDF generation failed in applicants report: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to generate PDF. Please try again.');
                }
            }

            return view('reports.applicants', [
                'totalApplicants' => $totalApplicants,
                'approvedApplicants' => $approvedApplicants,
                'pendingApplicants' => $pendingApplicants,
                'rejectedApplicants' => $rejectedApplicants,
                'approved' => $approved,
                'pending' => $pending,
                'rejected' => $rejected,
            ]);

        } catch (QueryException $e) {
            Log::error('Database error in applicants report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not retrieve applicant data. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in applicants report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while generating the applicant report.');
        }
    }

    public function licenses(Request $request)
    {
        try {
            $user = Auth::user();
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Build base query
            $memberQuery = Member::query();
            
            if (!$user->can('view all members')) {
                $memberQuery->whereIn('section_id', $accessibleSectionIds);
            }

            // Summary statistics
            $totalMembers = $memberQuery->count();
            $licensedMembers = $memberQuery->clone()->whereNotNull('license_number')->count();
            $unlicensedMembers = $totalMembers - $licensedMembers;
            
            $activeLicenses = $memberQuery->clone()->where('license_expiration_date', '>', now())->count();
            $expiredLicenses = $memberQuery->clone()->where('license_expiration_date', '<', now())->count();
            $nearExpiry = $memberQuery->clone()->whereBetween('license_expiration_date', [now(), now()->addDays(60)])->count();

            // Get bureaus with their sections and grouped licensed members
            $bureaus = Bureau::with(['sections' => function($query) use ($user, $accessibleSectionIds) {
                $query->withCount([
                    'members as total_members_count',
                    'members as licensed_members_count' => function($q) {
                        $q->whereNotNull('license_number');
                    },
                    'members as unlicensed_members_count' => function($q) {
                        $q->whereNull('license_number');
                    },
                    'members as active_licenses_count' => function($q) {
                        $q->where('license_expiration_date', '>', now());
                    },
                    'members as expired_licenses_count' => function($q) {
                        $q->where('license_expiration_date', '<', now());
                    },
                    'members as near_expiry_count' => function($q) {
                        $q->whereBetween('license_expiration_date', [now(), now()->addDays(60)]);
                    }
                ])
                ->with(['members' => function($q) {
                    $q->orderBy('license_class')
                    ->orderBy('last_name')
                    ->orderBy('first_name');
                }])
                ->orderBy('section_name');
                
                if (!$user->can('view all members')) {
                    $query->whereIn('id', $accessibleSectionIds);
                }
            }])
            ->withCount([
                'members as bureau_members_count' => function($q) use ($accessibleSectionIds, $user) {
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                },
                'members as bureau_licensed_count' => function($q) use ($accessibleSectionIds, $user) {
                    $q->whereNotNull('license_number');
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                },
                'members as bureau_unlicensed_count' => function($q) use ($accessibleSectionIds, $user) {
                    $q->whereNull('license_number');
                    if (!$user->can('view all members')) {
                        $q->whereIn('section_id', $accessibleSectionIds);
                    }
                }
            ])
            ->orderBy('bureau_name')
            ->get();

            // Group licensed members by class in each section
            $bureaus->each(function($bureau) {
                $bureau->sections->each(function($section) {
                    $section->groupedLicensedMembers = $section->members
                        ->where('license_number', '!=', null)
                        ->groupBy('license_class');
                });
            });

            // PDF Export
            if ($request->has('export') && $request->export === 'pdf') {
                try {
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->set('isHtml5ParserEnabled', true);
                    
                    $dompdf = new Dompdf($options);
                    $html = view('reports.licenses-pdf', [
                        'totalMembers' => $totalMembers,
                        'licensedMembers' => $licensedMembers,
                        'unlicensedMembers' => $unlicensedMembers,
                        'activeLicenses' => $activeLicenses,
                        'expiredLicenses' => $expiredLicenses,
                        'nearExpiry' => $nearExpiry,
                        'bureaus' => $bureaus,
                    ])->render();
                    
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    
                    return $dompdf->stream("license_report_".now()->format('Y-m-d').".pdf");

                } catch (DompdfException $e) {
                    Log::error('PDF generation failed in license report: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to generate PDF. Please try again.');
                }
            }

            return view('reports.licenses', [
                'totalMembers' => $totalMembers,
                'licensedMembers' => $licensedMembers,
                'unlicensedMembers' => $unlicensedMembers,
                'activeLicenses' => $activeLicenses,
                'expiredLicenses' => $expiredLicenses,
                'nearExpiry' => $nearExpiry,
                'bureaus' => $bureaus,
            ]);

        } catch (QueryException $e) {
            Log::error('Database error in license report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not retrieve license data. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Unexpected error in license report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while generating the license report.');
        }
    }

    public function custom(Request $request)
    {
        try {
            $user = Auth::user();
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Get bureaus and sections based on user permissions
            $bureauQuery = Bureau::query();
            $sectionQuery = Section::query();
            
            if (!$user->can('view all members')) {
                $sectionQuery->whereIn('id', $accessibleSectionIds);
                $bureauQuery->whereHas('sections', function($q) use ($accessibleSectionIds) {
                    $q->whereIn('id', $accessibleSectionIds);
                });
            }
            
            $bureaus = $bureauQuery->orderBy('bureau_name')->get();
            $sections = $sectionQuery->orderBy('section_name')->get();
            $membershipTypes = MembershipType::orderBy('type_name')->get();
            
            // Get filter values from request if any
            $filters = $request->only([
                'status', 'bureau_id', 'section_id', 'membership_type_id', 
                'license_class', 'sex', 'civil_status', 'date_from', 'date_to',
                'is_lifetime_member'
            ]);
            
            return view('reports.custom', compact('bureaus', 'sections', 'membershipTypes', 'filters'));
            
        } catch (\Exception $e) {
            Log::error('Error in custom report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the custom report page.');
        }
    }

    public function customExport(Request $request)
    {
        try {
            $user = Auth::user();
            $accessibleSectionIds = $this->getAccessibleSectionIds($user);
            
            // Build query based on filters
            $query = Member::with(['section.bureau', 'membershipType']);
            
            // Apply permission filtering
            if (!$user->can('view all members')) {
                $query->whereIn('section_id', $accessibleSectionIds);
            }
            
            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('bureau_id')) {
                $query->whereHas('section.bureau', function($q) use ($request) {
                    $q->where('id', $request->bureau_id);
                });
            }
            
            if ($request->filled('section_id')) {
                $query->where('section_id', $request->section_id);
            }
            
            if ($request->filled('membership_type_id')) {
                $query->where('membership_type_id', $request->membership_type_id);
            }
            
            if ($request->filled('license_class')) {
                $query->where('license_class', $request->license_class);
            }
            
            if ($request->filled('sex')) {
                $query->where('sex', $request->sex);
            }
            
            if ($request->filled('civil_status')) {
                $query->where('civil_status', $request->civil_status);
            }
            
            if ($request->filled('is_lifetime_member')) {
                $query->where('is_lifetime_member', $request->is_lifetime_member);
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Get filtered members
            $members = $query->orderBy('last_name')->orderBy('first_name')->get();
            
            // Get filter values for display
            $filters = $request->all();
            
            // Generate PDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            
            $dompdf = new Dompdf($options);
            $html = view('reports.custom-pdf', compact('members', 'filters'))->render();
            
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            
            return $dompdf->stream("custom_report_".now()->format('Y-m-d').".pdf");

        } catch (\Exception $e) {
            Log::error('PDF generation failed in custom report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }

    /**
     * Get accessible section IDs for the current user
     */
    private function getAccessibleSectionIds($user)
    {
        if ($user->can('view all members')) {
            return Section::pluck('id');
        }
        
        $sectionIds = DB::table('user_bureau_section')
            ->where('user_id', $user->id)
            ->whereNotNull('section_id')
            ->pluck('section_id');
        
        $bureauIds = DB::table('user_bureau_section')
            ->where('user_id', $user->id)
            ->whereNull('section_id')
            ->pluck('bureau_id');
        
        $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
        
        return $sectionIds->merge($bureauSectionIds)->unique();
    }
}