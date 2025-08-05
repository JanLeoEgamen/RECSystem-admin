<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-center sm:justify-start
                p-4 sm:p-6 rounded-lg shadow-lg
                bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

        <!-- Header Title -->
        <h1 class="font-semibold text-2xl sm:text-3xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
            {{ __('Reports Dashboard') }}
        </h1>
    </div>
</x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Members Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3 transition-transform duration-300 group-hover:rotate-6">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Total Members
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $totalMembers }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Bureaus Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3 transition-transform duration-300 group-hover:rotate-6">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Total Bureaus
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $totalBureaus }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Sections Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3 transition-transform duration-300 group-hover:rotate-6">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Total Sections
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $totalSections }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Applicants Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3 transition-transform duration-300 group-hover:rotate-6">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Total Applicants
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $totalApplicants }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections per Bureau Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6 transition-all duration-300 hover:shadow-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sections per Bureau</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($bureausWithSections as $bureau)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-600 hover:scale-[1.02]">
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-2 transition-transform duration-300 hover:rotate-6">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $bureau->bureau_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ $bureau->sections_count }} sections</p>
                                </div>
                            </div>
                            
                            <!-- Section List -->
                            <div class="mt-2 pl-9">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($bureau->sections as $section)
                                    <li class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-300 hover:text-gray-900 dark:hover:text-white">
                                        {{ $section->section_name }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Report Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6 transition-all duration-300 hover:shadow-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Report Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Membership Report Button -->
                        @can('view membership reports')
                        <a href="{{ route('reports.membership') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex flex-col items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-105 hover:shadow-md group">
                            <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full p-4 mb-3 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-md font-medium text-gray-700 dark:text-gray-300 text-center group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">Membership Report</span>
                        </a>
                        @endcan
                        @can('view applicant reports')
                        <!-- Applicants Report Button -->
                        <a href="{{ route('reports.applicants') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex flex-col items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-105 hover:shadow-md group">
                            <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-4 mb-3 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-8 w-8 text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <span class="text-md font-medium text-gray-700 dark:text-gray-300 text-center group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">Applicants Report</span>
                        </a>
                        @endcan
                        @can('view license reports')
                        <!-- License Report Button -->
                        <a href="{{ route('reports.licenses') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex flex-col items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-105 hover:shadow-md group">
                            <div class="bg-green-100 dark:bg-green-900 rounded-full p-4 mb-3 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-8 w-8 text-green-600 dark:text-green-400 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-md font-medium text-gray-700 dark:text-gray-300 text-center group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300">License Report</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>