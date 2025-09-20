<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualController extends Controller
{
    /**
     * Display the manual index page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Sample FAQ data - you can move this to database later
        $faqs = [
            [
                'question' => 'How do I add a new member to the system?',
                'answer' => 'Navigate to Members > Add New Member, fill in the required information including name, email, phone, and membership type. Click Save to add the member.'
            ],
            [
                'question' => 'How can I export member data?',
                'answer' => 'Go to Members > Export Data, select your preferred format (Excel/CSV), choose date range and member filters, then click Export.'
            ],
            [
                'question' => 'How do I manage membership renewals?',
                'answer' => 'Access Renewals section from the main dashboard, view expiring memberships, and process renewals individually or in bulk.'
            ],
            [
                'question' => 'What should I do if a member forgets their login?',
                'answer' => 'Go to Members > Find the member > Click Reset Password. The system will send a password reset link to their registered email.'
            ],
            [
                'question' => 'How do I generate membership reports?',
                'answer' => 'Navigate to Reports section, select report type (Monthly, Quarterly, Annual), set date parameters, and click Generate Report.'
            ]
        ];

        // Sample user management guide data
        $userGuides = [
            [
                'title' => 'Getting Started',
                'description' => 'Basic navigation and dashboard overview',
                'steps' => [
                    'Login to your admin account',
                    'Familiarize yourself with the main dashboard',
                    'Check your user permissions and role',
                    'Review recent activity logs'
                ]
            ],
            [
                'title' => 'Member Management',
                'description' => 'Complete guide to managing members',
                'steps' => [
                    'Adding new members with proper validation',
                    'Updating member information and status',
                    'Managing membership types and categories',
                    'Handling member deactivation/reactivation'
                ]
            ],
            [
                'title' => 'System Settings',
                'description' => 'Configure system preferences and settings',
                'steps' => [
                    'Setting up notification preferences',
                    'Configuring payment gateways',
                    'Managing user roles and permissions',
                    'System backup and maintenance'
                ]
            ],
            [
                'title' => 'Reports & Analytics',
                'description' => 'Generate and understand system reports',
                'steps' => [
                    'Running membership statistics reports',
                    'Analyzing payment and revenue data',
                    'Exporting data for external use',
                    'Setting up automated report schedules'
                ]
            ]
        ];

        // Sample support contacts
        $supportContacts = [
            [
                'type' => 'Technical Support',
                'email' => 'tech@yourcompany.com',
                'phone' => '+1-555-0123',
                'hours' => 'Mon-Fri 9AM-6PM EST'
            ],
            [
                'type' => 'General Support',
                'email' => 'support@yourcompany.com',
                'phone' => '+1-555-0124',
                'hours' => '24/7 Available'
            ]
        ];

        return view('manual.list', compact('faqs', 'userGuides', 'supportContacts'));
    }

    /**
     * Search FAQ items
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchFaq(Request $request)
    {
        $query = $request->get('query');
        
        // This is a simple example - you'd want to implement proper search
        // You can expand this to search in database
        $faqs = collect([
            [
                'question' => 'How do I add a new member to the system?',
                'answer' => 'Navigate to Members > Add New Member, fill in the required information including name, email, phone, and membership type. Click Save to add the member.'
            ],
            [
                'question' => 'How can I export member data?',
                'answer' => 'Go to Members > Export Data, select your preferred format (Excel/CSV), choose date range and member filters, then click Export.'
            ],
            // Add more FAQs here
        ]);

        $filtered = $faqs->filter(function ($faq) use ($query) {
            return stripos($faq['question'], $query) !== false || 
                   stripos($faq['answer'], $query) !== false;
        });

        return response()->json($filtered->values());
    }
}