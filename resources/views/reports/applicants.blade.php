<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Applicant Reports
            </h2>

            <div class="flex flex-col md:flex-row flex-wrap gap-4 w-full md:w-auto">
                @can('generate applicant reports')
                    <a href="{{ route('reports.applicants', ['export' => 'pdf']) }}" 
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
            <!-- Summary Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Applicant Summary</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Total Applicants -->
                        <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Total Applicants</p>
                                    <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalApplicants }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Approved -->
                        <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-2">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Approved</p>
                                    <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $approvedApplicants }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-2">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Pending</p>
                                    <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $pendingApplicants }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rejected -->
                        <div class="bg-blue-50 border border-blue-500 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-500 rounded-md p-2">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Disapproaved</p>
                                    <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $rejectedApplicants }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved Applicants Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Approved Applicants ({{ $approvedApplicants }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-[#101966] dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Full Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Date Applied</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Date Approved</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Section</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Bureau</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Membership Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($approved as $applicant)
                                <tr class="hover:bg-green-50 dark:hover:bg-green-900 transition-all duration-300 ease-in-out transform hover:scale-105 animate-slide-in-from-left">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-medium">
                                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }} {{ $applicant->suffix ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->created_at->format('m/d/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        @if($applicant->member && $applicant->member->created_at)
                                            {{ $applicant->member->created_at->format('m/d/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->member->section->section_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->member->section->bureau->bureau_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->member->membershipType->type_name ?? 'N/A' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No approved applicants found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pending Applicants Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pending Applicants ({{ $pendingApplicants }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-[#101966] dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Full Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date Applied</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($pending as $applicant)
                                <tr class="hover:bg-yellow-50 dark:hover:bg-yellow-900 transition-all duration-300 ease-in-out transform hover:scale-105 animate-slide-in-from-right">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-medium">
                                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }} {{ $applicant->suffix ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->created_at->format('m/d/Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No pending applicants found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rejected Applicants Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Disapproved Applicants ({{ $rejectedApplicants }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-[#101966] dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Full Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-white border-opacity-30">Date Applied</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date of Disapproval</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($rejected as $applicant)
                                <tr class="hover:bg-red-50 dark:hover:bg-red-900 transition-all duration-300 ease-in-out transform hover:scale-105 animate-slide-in-from-left">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-medium">
                                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }} {{ $applicant->suffix ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->created_at->format('m/d/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $applicant->updated_at->format('m/d/Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No rejected applicants found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>