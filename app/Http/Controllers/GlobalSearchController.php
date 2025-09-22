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
        // Event Announcements
        'event-announcements' => [
            'index' => ['label' => 'View Event Announcements', 'route' => 'event-announcements.index'],
            'create' => ['label' => 'Create Event Announcement', 'route' => 'event-announcements.create'],
            'edit' => ['label' => 'Edit Event Announcement', 'route' => 'event-announcements.edit', 'needs_param' => true],
        ],
        
        // Communities
        'communities' => [
            'index' => ['label' => 'View Communities', 'route' => 'communities.index'],
            'create' => ['label' => 'Create Community', 'route' => 'communities.create'],
            'edit' => ['label' => 'Edit Community', 'route' => 'communities.edit', 'needs_param' => true],
        ],
        
        // Supporters
        'supporters' => [
            'index' => ['label' => 'View Supporters', 'route' => 'supporters.index'],
            'create' => ['label' => 'Create Supporter', 'route' => 'supporters.create'],
            'edit' => ['label' => 'Edit Supporter', 'route' => 'supporters.edit', 'needs_param' => true],
        ],
        
        // FAQs
        'faqs' => [
            'index' => ['label' => 'View FAQs', 'route' => 'faqs.index'],
            'create' => ['label' => 'Create FAQ', 'route' => 'faqs.create'],
            'edit' => ['label' => 'Edit FAQ', 'route' => 'faqs.edit', 'needs_param' => true],
        ],
        
        // Articles
        'articles' => [
            'index' => ['label' => 'View Articles', 'route' => 'articles.index'],
            'create' => ['label' => 'Create Article', 'route' => 'articles.create'],
            'edit' => ['label' => 'Edit Article', 'route' => 'articles.edit', 'needs_param' => true],
        ],
        
        // Markees
        'markees' => [
            'index' => ['label' => 'View Markees', 'route' => 'markees.index'],
            'create' => ['label' => 'Create Markee', 'route' => 'markees.create'],
            'edit' => ['label' => 'Edit Markee', 'route' => 'markees.edit', 'needs_param' => true],
        ],
        
        // Membership Types
        'membership-types' => [
            'index' => ['label' => 'View Membership Types', 'route' => 'membership-types.index'],
            'create' => ['label' => 'Create Membership Type', 'route' => 'membership-types.create'],
            'edit' => ['label' => 'Edit Membership Type', 'route' => 'membership-types.edit', 'needs_param' => true],
        ],
        
        // Bureaus
        'bureaus' => [
            'index' => ['label' => 'View Bureaus', 'route' => 'bureaus.index'],
            'create' => ['label' => 'Create Bureau', 'route' => 'bureaus.create'],
            'edit' => ['label' => 'Edit Bureau', 'route' => 'bureaus.edit', 'needs_param' => true],
        ],
        
        // Sections
        'sections' => [
            'index' => ['label' => 'View Sections', 'route' => 'sections.index'],
            'create' => ['label' => 'Create Section', 'route' => 'sections.create'],
            'edit' => ['label' => 'Edit Section', 'route' => 'sections.edit', 'needs_param' => true],
        ],
        
        // Profile
        'profile' => [
            'edit' => ['label' => 'Edit Profile', 'route' => 'profile.edit'],
        ],
        
        // Permissions
        'permissions' => [
            'index' => ['label' => 'View Permissions', 'route' => 'permissions.index'],
            'create' => ['label' => 'Create Permission', 'route' => 'permissions.create'],
            'edit' => ['label' => 'Edit Permission', 'route' => 'permissions.edit', 'needs_param' => true],
        ],
        
        // Roles
        'roles' => [
            'index' => ['label' => 'View Roles', 'route' => 'roles.index'],
            'create' => ['label' => 'Create Role', 'route' => 'roles.create'],
            'edit' => ['label' => 'Edit Role', 'route' => 'roles.edit', 'needs_param' => true],
        ],
        
        // Users
        'users' => [
            'index' => ['label' => 'View Users Table', 'route' => 'users.index'],
            'create' => ['label' => 'Create Users', 'route' => 'users.create'],
            'edit' => ['label' => 'Edit Users', 'route' => 'users.edit', 'needs_param' => true],
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