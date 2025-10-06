<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Reports Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        .animate-slide-in {
            opacity: 0;
            animation: slideIn 0.6s ease-out forwards;
        }

        .animate-pulse-hover:hover {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Staggered animation delays */
        .delay-100 { animation-delay: 0.2s; }
        .delay-200 { animation-delay: 0.4s; }
        .delay-300 { animation-delay: 0.6s; }
        .delay-400 { animation-delay: 0.8s; }
        .delay-500 { animation-delay: 1.0s; }
        .delay-600 { animation-delay: 1.2s; }

        /* Gradient backgrounds */
        .gradient-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-green {
            background: linear-gradient(135deg, #5e6ffb 0%, #101966 100%);
        }
        .gradient-purple {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .gradient-orange {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
    </style>


    <div class="py-6 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Stats Section -->
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">System Overview</h3>
                <p class="text-gray-600 dark:text-gray-300">Complete analytics and reporting dashboard</p>
            </div>

            <!-- Enhanced Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @can('view members')
                
                <!-- Total Members Card -->
                <div class="animate-slide-in delay-100">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-green-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 group">
                        <div class="gradient-green h-2"></div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-100 dark:bg-blue-900 rounded-xl p-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors duration-300">
                                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Members</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                        {{ number_format($totalMembers) }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium bg-green-100 dark:bg-green-900 px-2 py-1 rounded-full">
                                            Active System
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Bureaus Card -->
                <div class="animate-slide-in delay-200">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-blue-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 group">
                        <div class="gradient-blue h-2"></div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-100 dark:bg-blue-900 rounded-xl p-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors duration-300">
                                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Bureaus</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                        {{ number_format($totalBureaus) }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded-full">
                                            Organizational Units
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Sections Card -->
                <div class="animate-slide-in delay-300">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-purple-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 group">
                        <div class="gradient-purple h-2"></div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-purple-100 dark:bg-purple-900 rounded-xl p-3 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors duration-300">
                                        <svg class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Sections</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                                        {{ number_format($totalSections) }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-purple-600 dark:text-purple-400 font-medium bg-purple-100 dark:bg-purple-900 px-2 py-1 rounded-full">
                                            Sub-departments
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @can('view applicants')
                    
                <!-- Total Applicants Card -->
                <div class="animate-slide-in delay-400">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-orange-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 group">
                        <div class="gradient-orange h-2"></div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-orange-100 dark:bg-orange-900 rounded-xl p-3 group-hover:bg-orange-200 dark:group-hover:bg-orange-800 transition-colors duration-300">
                                        <svg class="h-8 w-8 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Applicants</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">
                                        {{ number_format($totalApplicants) }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium bg-yellow-100 dark:bg-yellow-900 px-2 py-1 rounded-full">
                                            Pending Review
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>

            <!-- Organizational Structure Section -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-[#101966] to-[#1e3a8a] px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Organizational Structure
                        </h3>
                        <p class="text-blue-100 mt-1">Bureaus and their sections overview</p>
                    </div>
                    <div class="p-6">
                        @if($bureausWithSections->isEmpty())
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Organizational Data Available</h4>
                                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                                    There are no bureaus or sections to display based on your current access permissions.
                                </p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($bureausWithSections as $bureau)
                                    @php
                                        $hasSections = $bureau->sections && $bureau->sections->count() > 0;
                                        $sectionsCount = $hasSections ? $bureau->sections->count() : 0;
                                    @endphp
                                    
                                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-5 border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md group">
                                        <div class="flex items-center mb-4">
                                            <div class="bg-[#101966] rounded-lg p-3 group-hover:bg-blue-600 transition-colors duration-300">
                                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4 flex-1 min-w-0">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-[#101966] dark:group-hover:text-blue-400 transition-colors duration-300 truncate">
                                                    {{ $bureau->bureau_name }}
                                                </h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $sectionsCount }} {{ Str::plural('section', $sectionsCount) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($hasSections)
                                            <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                                @foreach($bureau->sections as $section)
                                                    <div class="flex items-center p-2 bg-white dark:bg-gray-800 rounded-lg transition-all duration-200 hover:bg-gray-200 dark:hover:bg-gray-600 group/section">
                                                        <div class="mr-3 group-hover/section:scale-110 transition-transform duration-200 flex-shrink-0">
                                                            <svg class="w-4 h-4 text-blue-400 group-hover/section:text-[#101966] transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm text-gray-700 dark:text-gray-300 group-hover/section:text-[#101966] dark:group-hover/section:text-blue-400 transition-colors duration-200 truncate">
                                                            {{ $section->section_name }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- No sections in this bureau -->
                                            <div class="text-center py-4">
                                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No sections available</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Reports Access Section -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#101966] to-[#1e3a8a] px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Generate Reports
                        </h3>
                        <p class="text-blue-100 mt-1">Access comprehensive system reports and analytics</p>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Membership Report -->
                            @can('view membership reports')
                            <div>
                                <a href="{{ route('reports.membership') }}" class="group block">
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 shadow-sm border border-blue-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:-translate-y-2">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-4 mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                                Membership Report
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                Comprehensive member analytics and status overview
                                            </p>
                                            <div class="mt-4 px-4 py-2 bg-blue-600 dark:bg-blue-700 rounded-full">
                                                <span class="text-xs font-medium text-white">View Details</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            <!-- Applicants Report -->
                            @can('view applicant reports')
                            <div>
                                <a href="{{ route('reports.applicants') }}" class="group block">
                                    <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 shadow-sm border border-green-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:-translate-y-2">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-4 mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300">
                                                Applicants Report
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                Track application status and approval metrics
                                            </p>
                                            <div class="mt-4 px-4 py-2 bg-green-600 dark:bg-green-700 rounded-full">
                                                <span class="text-xs font-medium text-white">View Details</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            <!-- License Report -->
                            @can('view license reports')
                            <div>
                                <a href="{{ route('reports.licenses') }}" class="group block">
                                    <div class="bg-gradient-to-br from-purple-50 to-violet-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 shadow-sm border border-purple-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:-translate-y-2">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl p-4 mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                                                License Report
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                Monitor licensing status and expiration dates
                                            </p>
                                            <div class="mt-4 px-4 py-2 bg-purple-600 dark:bg-purple-700 rounded-full">
                                                <span class="text-xs font-medium text-white">View Details</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            <!-- Custom Report -->
                            @can('view custom reports')
                            <div>
                                <a href="{{ route('reports.custom') }}" class="group block">
                                    <div class="bg-gradient-to-br from-orange-50 to-amber-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 shadow-sm border border-orange-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:-translate-y-2">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl p-4 mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">
                                                Custom Report
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                Create tailored reports with custom parameters
                                            </p>
                                            <div class="mt-4 px-4 py-2 bg-orange-600 dark:bg-orange-700 rounded-full">
                                                <span class="text-xs font-medium text-white">View Details</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>