<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Membership Reports
            </h2>

            <div class="flex flex-col md:flex-row flex-wrap gap-4 w-full md:w-auto">
                @can('generate membership reports')
                    <a href="{{ route('reports.membership', ['export' => 'pdf']) }}" 
                        class="bg-white text-red-700 hover:bg-red-700 hover:text-white px-4 py-2 rounded-md flex items-center justify-center font-medium border border-white hover:border-white transition w-full md:w-auto">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export PDF
                    </a>
                @endcan

                <a href="{{ route('reports.index') }}"
                    class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center justify-center font-medium border border-white hover:border-white transition w-full md:w-auto">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Reports
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in-from-left {
            animation: slideInFromLeft 0.5s ease-out forwards;
        }

        .animate-slide-in-from-right {
            animation: slideInFromRight 0.5s ease-out forwards;
        }

        /* Staggered animation delay for each row */
        tbody tr:nth-child(1) { animation-delay: 0.1s; }
        tbody tr:nth-child(2) { animation-delay: 0.2s; }
        tbody tr:nth-child(3) { animation-delay: 0.3s; }
        tbody tr:nth-child(4) { animation-delay: 0.4s; }
        tbody tr:nth-child(5) { animation-delay: 0.5s; }
        tbody tr:nth-child(6) { animation-delay: 0.6s; }
        tbody tr:nth-child(7) { animation-delay: 0.7s; }
        tbody tr:nth-child(8) { animation-delay: 0.8s; }
        tbody tr:nth-child(9) { animation-delay: 0.9s; }
        tbody tr:nth-child(10) { animation-delay: 1.0s; }
        tbody tr:nth-child(n+11) { animation-delay: 1.1s; }

        /* Custom green-150 for hover effect */
        .hover\:bg-green-150:hover {
            background-color: #d1fae5;
        }
    </style>


<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Membership Summary -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Membership Summary</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Total Members -->
                    <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Total Members</p>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalMembers }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Members -->
                    <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Active Members</p>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $activeMembers }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Inactive Members -->
                    <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Inactive Members</p>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $inactiveMembers }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Bureaus -->
                    <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Total Bureaus</p>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $bureaus->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sections -->
                    <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Total Sections</p>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalSections }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bureau and Section Summary Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Membership Distribution</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-[#101966] dark:bg-gray-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Bureau/Section</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Active</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Inactive</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($bureaus as $bureau)
                            <tr class="bg-blue-100 dark:bg-gray-700 hover:bg-blue-300 dark:hover:bg-gray-600 transition-all duration-300 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                    {{ $bureau->bureau_name }} (Bureau)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                                    {{ $bureau->active_members_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                                    {{ $bureau->inactive_members_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {{ $bureau->total_members_count }}
                                </td>
                            </tr>
                            @if($bureau->sections && $bureau->sections->count() > 0)
                                @foreach($bureau->sections as $section)
                                <tr class="hover:bg-indigo-100 dark:hover:bg-gray-600 transition-all duration-300 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300 pl-10">
                                        {{ $section->section_name }} (Section)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                                        {{ $section->active_members_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                                        {{ $section->inactive_members_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                                        {{ $section->total_members_count }}
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            @endforeach
                            <!-- Totals Row -->
                            <tr class="bg-green-100 dark:bg-green-800 font-semibold hover:bg-green-150 dark:hover:bg-green-700 transition-all duration-300 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-green-800 dark:text-green-100">
                                    Grand Total
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-800 dark:text-green-100">
                                    {{ $activeMembers }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-800 dark:text-green-100">
                                    {{ $inactiveMembers }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-800 dark:text-green-100">
                                    {{ $totalMembers }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detailed Members Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Member Details</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-[#101966] dark:bg-gray-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Rec #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Callsign</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Validity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Membership Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Bureau</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Section</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($members as $member)
                            <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition-all duration-300 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $member->rec_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-medium">
                                    {{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name ? $member->middle_name[0].'.' : '' }} {{ $member->suffix ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $member->callsign ?? 'Unlicensed' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $member->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    @if($member->is_lifetime_member)
                                        Lifetime
                                    @elseif($member->membership_end)
                                        {{ \Carbon\Carbon::parse($member->membership_end)->format('m/d/Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $member->membershipType->type_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $member->section->bureau->bureau_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $member->section->section_name ?? 'N/A' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div></x-app-layout>