<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        My Membership Details
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Complete overview of your membership information</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.dashboard') }}" class="group inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @vite('resources/css/membership-details.css')

    <div class="py-8 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Security Notice -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-500 dark:border-green-700/50 rounded-2xl p-6 mb-6 animate-slide-up" style="animation-delay: 0.05s;">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 dark:bg-green-800/50 rounded-xl">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Your Data is Secure & Protected
                        </h4>
                        <p class="text-green-700 dark:text-green-300 text-sm leading-relaxed text-justify sm:text-left">
                            <strong>Privacy Guarantee:</strong> Your personal information displayed below is highly sensitive and confidential. This data is exclusively accessible to you and authorized organization personnel only. We employ industry-standard security measures to protect your information and ensure it remains private and secure at all times.
                        </p>
                        <div class="mt-3 flex items-center text-xs text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>End-to-end encrypted</span>
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Access controlled</span>
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Audit logged</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership Overview -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8 text-white">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between space-y-4 sm:space-y-0 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white/20 dark:bg-white/10 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white dark:text-gray-100">{{ $member->first_name }} {{ $member->last_name }}</h3>
                                <div class="sm:hidden mt-2">
                                    <span class="bg-[#101966] text-white transition-all duration-300 dark:bg-blue-700 dark:text-gray-100 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold">
                                        REC #{{ $member->rec_number }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hidden sm:block">
                            <span class="bg-[#101966] text-white transition-all duration-300 dark:bg-blue-700 dark:text-gray-100 inline-flex items-center px-4 py-2 rounded-full text-sm font-bold">
                                REC #{{ $member->rec_number }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="card-overview-item transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative" style="animation-delay: 0.1s">
                            <div class="hidden lg:flex absolute top-4 left-4">
                                <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mb-2 lg:hidden">
                                <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-blue-100 dark:text-blue-200">Membership Type</p>
                            <p class="text-lg font-bold text-white dark:text-gray-100">{{ $member->membershipType->type_name ?? 'N/A' }}</p>
                        </div>
                        <div class="card-overview-item transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative" style="animation-delay: 0.2s">
                            <div class="hidden lg:flex absolute top-4 left-4">
                                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mb-2 lg:hidden">
                                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-blue-100 dark:text-blue-200">Section</p>
                            <p class="text-lg font-bold text-white dark:text-gray-100">{{ $member->section->section_name ?? 'N/A' }}</p>
                        </div>
                        <div class="card-overview-item transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative" style="animation-delay: 0.3s">
                            <div class="hidden lg:flex absolute top-4 left-4">
                                <div class="p-2 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mb-2 lg:hidden">
                                <div class="p-2 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-blue-100 dark:text-blue-200">Status</p>
                            <p class="text-lg font-bold text-white dark:text-gray-100">{{ $member->status ?? 'N/A' }}</p>
                        </div>
                        <div class="card-overview-item transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative" style="animation-delay: 0.4s">
                            <div class="hidden lg:flex absolute top-4 left-4">
                                <div class="p-2 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mb-2 lg:hidden">
                                <div class="p-2 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-blue-100 dark:text-blue-200">Membership</p>
                            @if($member->is_lifetime_member)
                                <span class="bg-gradient-to-br from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-bold text-white dark:text-gray-100">
                                    ♦️ Lifetime
                                </span>
                            @else
                                <p class="text-lg font-bold text-white dark:text-gray-100">Regular</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Personal Information -->
                <div class="section-container bg-white/90 dark:bg-gray-800 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 p-6 rounded-t-3xl">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white dark:text-white">Personal Information</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-gray-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">First Name</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->first_name }}</p>
                            </div>
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->last_name }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Middle Name</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->middle_name ?? 'N/A' }}</p>
                            </div>
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Suffix</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->suffix ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sex</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->sex }}</p>
                            </div>
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Birthdate</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Civil Status</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->civil_status }}</p>
                            </div>
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Blood Type</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->blood_type ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Citizenship</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->citizenship }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->    
                <div class="section-container bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.3s">
                    <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 dark:border-blue-600/20 p-6 rounded-t-3xl">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white dark:text-white">Contact Information</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cellphone No.</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->cellphone_no }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Telephone No.</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->telephone_no ?? 'N/A' }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->email_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="section-container bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.4s">
                    <div class="section-header bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 dark:border-blue-600/20 p-6 rounded-t-3xl">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white dark:text-white">Emergency Contact</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->emergency_contact }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact No.</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->emergency_contact_number }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Relationship</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->relationship }}</p>
                        </div>
                    </div>
                </div>

                <!-- License Information -->
                <div class="section-container bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.5s">
                    <div class="section-header bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 dark:border-blue-600/20 p-6 rounded-t-3xl">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white dark:text-white">License Information</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">License Class</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->license_class ?? 'N/A' }}</p>
                            </div>
                            <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">License Number</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->license_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Callsign</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->callsign ?? 'N/A' }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Expiration Date</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->license_expiration_date ? \Carbon\Carbon::parse($member->license_expiration_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership Information -->
            <div class="section-container bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden mt-8 border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.6s">
                <div class="section-header bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 dark:border-blue-600/20 p-6 rounded-t-3xl">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white dark:text-white">Membership Information</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Membership Start</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->membership_start ? \Carbon\Carbon::parse($member->membership_start)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Membership End</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->membership_end ? \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') : ($member->is_lifetime_member ? 'Lifetime' : 'N/A') }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Renewal Date</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->last_renewal_date ? \Carbon\Carbon::parse($member->last_renewal_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="section-container bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden mt-8 border border-white/20 dark:border-gray-600/30 hover:transform hover:-translate-y-0.5 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" style="animation-delay: 0.7s">
                <div class="section-header bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 border border-blue-200/20 dark:border-blue-600/20 p-6 rounded-t-3xl">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white dark:text-white">Address Information</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">House/Building No./Name</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->house_building_number_name }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Street Address</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->street_address }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Region</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $regionName }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Province</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $provinceName }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Municipality</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $municipalityName }}</p>
                        </div>
                        <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Barangay</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $barangayName }}</p>
                        </div>
                    </div>
                    <div class="info-item bg-blue-200/50 dark:bg-blue-900/10 border border-blue-200/20 dark:border-blue-600/20 p-4 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/20 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:transform hover:-translate-y-0.5 transition-all duration-300">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Zip Code</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $member->zip_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Optional Edit Section -->
            <!-- 
            <div class="mt-8 text-center animate-fade-in" style="animation-delay: 0.7s">
                <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Request Information Update
                </a>
            </div>
            -->
        </div>
    </div>

    <!-- Floating Help Button -->
    <div class="floating-btn">
        <button onclick="showHelpModal()" class="interactive-btn p-4 bg-gradient-to-r from-[#101966] to-blue-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>

    <!-- Include required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Help modal function
        window.showHelpModal = function() {
            Swal.fire({
                title: 'Membership Details Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">📋 Complete Profile</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">View your complete membership profile including personal information, contact details, and membership status.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">🔒 Privacy & Security</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">Your personal information is secure and confidential. This page is only accessible to you and authorized personnel.</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">📞 Emergency Contact</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">Your emergency contact information is kept up-to-date for safety purposes. Contact support if you need to update this information.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">📄 License Information</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">Your professional license details are maintained for verification and compliance purposes. Keep your license current and valid.</p>
                        </div>
                    </div>
                `,
                background: '#ffffff',
                color: '#374151',
                confirmButtonColor: '#101966',
                confirmButtonText: 'Got it!'
            });
        };
    </script>

    <style>
        /* Floating Help Button */
        .floating-btn {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            z-index: 50;
        }
        
        .interactive-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .interactive-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .interactive-btn:active {
            transform: scale(0.95);
        }
    </style>
</x-app-layout>