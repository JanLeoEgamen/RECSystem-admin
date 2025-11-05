<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GlobalSearchController extends Controller
{
    /**
     * Predefined searchable routes with their display information
     */
    private array $searchableRoutes = [
        // Activity Logs
        'activity-logs' => [
            'index' => ['label' => 'View Activity Logs', 'route' => 'activity-logs.index'],
        ],

        // Announcements
        'announcements' => [
            'index' => ['label' => 'View Announcements', 'route' => 'announcements.index'],
            'create' => ['label' => 'Create Announcement', 'route' => 'announcements.create'],
        ],

        // Applicants
        'applicants' => [
            'index' => ['label' => 'View Applicants', 'route' => 'applicants.index'],
            'create' => ['label' => 'Create Applicant', 'route' => 'applicants.showApplicantCreateForm'],
            'approved' => ['label' => 'View Approved Applicants', 'route' => 'applicants.approved'],
            'rejected' => ['label' => 'View Rejected Applicants', 'route' => 'applicants.rejected'],
        ],

        // Articles
        'articles' => [
            'index' => ['label' => 'View Articles', 'route' => 'articles.index'],
            'create' => ['label' => 'Create Article', 'route' => 'articles.create'],
        ],

        // Back ups
        'backups' => [
            'index' => ['label' => 'View Back-ups Table', 'route' => 'backups.index'],
            'create' => ['label' => 'Create Back-up', 'route' => 'backups.create'],
        ],

        // Bureaus
        'bureaus' => [
            'index' => ['label' => 'View Bureaus', 'route' => 'bureaus.index'],
            'create' => ['label' => 'Create Bureau', 'route' => 'bureaus.create'],
        ],

        // Cashier
        'cashier' => [
            'index' => ['label' => 'View Cashier/Payments Table', 'route' => 'cashier.index'],
            'verified' => ['label' => 'View Verified Payments', 'route' => 'cashier.verified'],
            'rejected' => ['label' => 'View Rejected Payments', 'route' => 'cashier.rejected'],
        ],

        // Certificates
        'certificates' => [
            'index' => ['label' => 'View Certificates', 'route' => 'certificates.index'],
            'create' => ['label' => 'Create Certificate', 'route' => 'certificates.create'],
        ],

        // Communities
        'communities' => [
            'index' => ['label' => 'View Communities', 'route' => 'communities.index'],
            'create' => ['label' => 'Create Community', 'route' => 'communities.create'],
        ],

        // Dashboard
        'dashboard' => [
            'dashboard' => ['label' => 'View Dashboard', 'route' => 'dashboard'],
        ],

        // Documents
        'documents' => [
            'index' => ['label' => 'View Documents', 'route' => 'documents.index'],
            'create' => ['label' => 'Create Document', 'route' => 'documents.create'],
        ],

        // Email Templates
        'emails' => [
            'index' => ['label' => 'View Email Templates', 'route' => 'emails.index'],
            'create' => ['label' => 'Create Email Template', 'route' => 'emails.create'],
            'compose' => ['label' => 'Compose Email', 'route' => 'emails.compose'],
        ],

        // Event Announcements
        'event-announcements' => [
            'index' => ['label' => 'View Event Announcements', 'route' => 'event-announcements.index'],
            'create' => ['label' => 'Create Event Announcement', 'route' => 'event-announcements.create'],
        ],

        // FAQs
        'faqs' => [
            'index' => ['label' => 'View FAQs', 'route' => 'faqs.index'],
            'create' => ['label' => 'Create FAQ', 'route' => 'faqs.create'],
        ],

        // Licenses
        'licenses' => [
            'index' => ['label' => 'View Licensed Members', 'route' => 'licenses.index'],
            'unlicensed' => ['label' => 'View Unlicensed Members', 'route' => 'licenses.unlicensed'],
        ],

        // Main Carousels
        'main-carousels' => [
            'index' => ['label' => 'View Main Carousels', 'route' => 'main-carousels.index'],
            'create' => ['label' => 'Create Main Carousel', 'route' => 'main-carousels.create'],
        ],

        // Manuals
        'manual' => [
            'index' => ['label' => 'View List of Manuals', 'route' => 'manual.index'],
            'create' => ['label' => 'Create Manual', 'route' => 'manual.create'],
            'view' => ['label' => 'View Manual/Help Tab', 'route' => 'manual.view'],
        ],

        // Markees
        'markees' => [
            'index' => ['label' => 'View Marquees', 'route' => 'markees.index'],
            'create' => ['label' => 'Create Marquees', 'route' => 'markees.create'],
        ],

        // Members
        'members' => [
            'index' => ['label' => 'View Members', 'route' => 'members.index'],
            'create' => ['label' => 'Create Member', 'route' => 'members.showMemberCreateForm'],
        ],

        // Membership Types
        'membership-types' => [
            'index' => ['label' => 'View Membership Types', 'route' => 'membership-types.index'],
            'create' => ['label' => 'Create Membership Type', 'route' => 'membership-types.create'],
        ],

        // Payment Methods
        'payment-methods' => [
            'index' => ['label' => 'View Payment Methods Table', 'route' => 'payment-methods.index'],
            'create' => ['label' => 'Create Payment Method', 'route' => 'payment-methods.create'],
        ],

        // Permissions
        'permissions' => [
            'index' => ['label' => 'View Permissions', 'route' => 'permissions.index'],
            'create' => ['label' => 'Create Permission', 'route' => 'permissions.create'],
        ],

        // Profile
        'profile' => [
            'edit' => ['label' => 'Edit Profile', 'route' => 'profile.edit'],
        ],

        // Quizzes
        'quizzes' => [
            'index' => ['label' => 'View Exams/Quizzes', 'route' => 'quizzes.index'],
            'create' => ['label' => 'Create Exam/Quiz', 'route' => 'quizzes.create'],
        ],

        // Renewal
        'renew' => [
            'index' => ['label' => 'View Renewal Requests', 'route' => 'renew.index'],
            'history' => ['label' => 'View Renewal History', 'route' => 'renew.history'],
        ],

        // Reports
        'reports' => [
            'index' => ['label' => 'View Reports Dashboard', 'route' => 'reports.index'],
            'membership' => ['label' => 'Membership Reports', 'route' => 'reports.membership'],
            'applicants' => ['label' => 'Applicants Reports', 'route' => 'reports.applicants'],
            'licenses' => ['label' => 'Licenses Reports', 'route' => 'reports.licenses'],
            'custom' => ['label' => 'Custom Reports', 'route' => 'reports.custom'],
        ],

        // Roles
        'roles' => [
            'index' => ['label' => 'View Roles', 'route' => 'roles.index'],
            'create' => ['label' => 'Create Role', 'route' => 'roles.create'],
        ],

        // Sections
        'sections' => [
            'index' => ['label' => 'View Sections', 'route' => 'sections.index'],
            'create' => ['label' => 'Create Section', 'route' => 'sections.create'],
        ],

        // Supporters
        'supporters' => [
            'index' => ['label' => 'View Supporters', 'route' => 'supporters.index'],
            'create' => ['label' => 'Create Supporter', 'route' => 'supporters.create'],
        ],

        // Surveys
        'surveys' => [
            'index' => ['label' => 'View Surveys', 'route' => 'surveys.index'],
            'create' => ['label' => 'Create Survey', 'route' => 'surveys.create'],
        ],

        // User Logs
        'user-logs' => [
            'index' => ['label' => 'View User Logs', 'route' => 'login-logs.index'],
        ],

        // Users
        'users' => [
            'index' => ['label' => 'View Users Table', 'route' => 'users.index'],
            'create' => ['label' => 'Create Users', 'route' => 'users.create'],
        ],
    ];

    /**
     * Search for routes based on query
     */
    public function search(Request $request): JsonResponse
    {
        $query = strtolower(trim($request->get('q', '')));
        
        if (empty($query)) {
            return response()->json([]);
        }

        $results = [];

        foreach ($this->searchableRoutes as $category => $actions) {
            // Check if category matches the query
            if (str_contains(strtolower($category), $query)) {
                foreach ($actions as $action => $config) {
                    try {
                        $url = $this->generateUrl($config['route'], $config['needs_param'] ?? false);
                        
                        $results[] = [
                            'label' => $config['label'],
                            'route' => $config['route'],
                            'url' => $url,
                            'category' => $category,
                            'action' => $action
                        ];
                    } catch (\Exception $e) {
                        // Skip if route generation fails
                        continue;
                    }
                }
            } else {
                // Check individual action labels for partial matches
                foreach ($actions as $action => $config) {
                    $searchText = strtolower($config['label'] . ' ' . $category);
                    
                    if (str_contains($searchText, $query)) {
                        try {
                            $url = $this->generateUrl($config['route'], $config['needs_param'] ?? false);
                            
                            $results[] = [
                                'label' => $config['label'],
                                'route' => $config['route'],
                                'url' => $url,
                                'category' => $category,
                                'action' => $action
                            ];
                        } catch (\Exception $e) {
                            // Skip if route generation fails
                            continue;
                        }
                    }
                }
            }
        }

        // Limit results and sort by relevance
        $results = collect($results)
            ->unique('route')
            ->sortBy(function ($item) use ($query) {
                // Prioritize exact matches in category name
                if (str_contains(strtolower($item['category']), $query)) {
                    return 0;
                }
                // Then prioritize matches at the beginning of labels
                if (str_starts_with(strtolower($item['label']), $query)) {
                    return 1;
                }
                return 2;
            })
            ->take(10)
            ->values();

        return response()->json($results);
    }

    /**
     * Generate URL for route with optional parameter
     */
    private function generateUrl(string $routeName, bool $needsParam = false): string
    {
        if ($needsParam) {
            // Use placeholder ID for edit routes
            return route($routeName, ['id' => 1]);
        }
        
        return route($routeName);
    }

    /**
     * Get all searchable categories (for autocomplete suggestions)
     */
    public function getCategories(): JsonResponse
    {
        $categories = collect($this->searchableRoutes)
            ->keys()
            ->map(function ($category) {
                return [
                    'name' => $category,
                    'display' => ucwords(str_replace(['-', '_'], ' ', $category))
                ];
            });

        return response()->json($categories);
    }
}