<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Student Applicant / View
            </h2>
            <a href="{{ route('student-applicants.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Student Applicants
            </a>                
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                        <!-- Personal Information -->
                        <div class="col-span-2">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Personal Information</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">First Name</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->first_name }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Middle Name</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->middle_name ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Last Name</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->last_name }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Suffix</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->suffix ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Sex</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->sex }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Birthdate</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Civil Status</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->civil_status }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Citizenship</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->citizenship }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Blood Type</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->blood_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-span-1 md:col-span-2">
                            <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                        </div>

                        <!-- Student Information -->
                        <div class="col-span-2">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 shadow-md">
                                    <img src="https://img.icons8.com/material-rounded/24/FFFFFF/student-male.png" class="w-5 h-5 sm:w-6 sm:h-6 object-contain" alt="Student">
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Student Information</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Student Number</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->student_number ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5m0 0l9 5m-9-5v10l9 5m0 0l9-5m-9 5v-10m0 0l-9-5" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">School/University</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->school ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Program/Course</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->program ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Year Level</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->year_level ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-span-1 md:col-span-2">
                            <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                        </div>

                        <!-- Contact Information -->
                        <div class="col-span-2 md:col-span-1">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Contact Information</h3>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Cellphone No.</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->cellphone_no }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Telephone No.</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->telephone_no ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Email Address</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->email_address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="col-span-2 md:col-span-1">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-rose-500 to-pink-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Emergency Contact</h3>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Name</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->emergency_contact }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Contact No.</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->emergency_contact_number }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Relationship</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->relationship }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-span-1 md:col-span-2">
                            <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                        </div>

                        <!-- License Information -->
                        <div class="col-span-2 md:col-span-1 lg:col-span-2">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0 0h5a2 2 0 002-2V8a2 2 0 00-2-2h-5m0 0V5a2 2 0 00-2-2h-.5a2 2 0 00-2 2v7m0 0H5" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">License Information</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">License Class</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->license_class ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">License Number</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Callsign</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->callsign ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Expiration Date</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->license_expiration_date ? \Carbon\Carbon::parse($applicant->license_expiration_date)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-span-1 md:col-span-2">
                            <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                        </div>

                        <!-- Address Information -->
                        <div class="col-span-2 md:col-span-1 lg:col-span-2">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">Address Information</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">House/Building No./Name</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->house_building_number_name }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Street Address</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->street_address }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                         <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Region</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $regionName }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Province</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $provinceName }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Municipality</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $municipalityName }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Barangay</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $barangayName }}</p>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-5">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Zip Code</p>
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant->zip_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note and Buttons -->
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                        <!-- Note Section -->
                        <div class="flex-1 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-3 sm:p-4 rounded-r-lg">
                            <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs sm:text-sm text-blue-800 dark:text-blue-200 font-medium">Review this student applicant's information. You can assess their application.</p>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:flex-nowrap">
                            @can('assess student applicants')
                            <a href="{{ route('student-applicants.assess', $applicant->id) }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-blue-600 to-cyan-600 
                                    hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-blue-600 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg 
                                    transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Assess
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: "{{ session('success') }}",
                confirmButtonColor: "#5e6ffb",
                background: '#101966',
                color: '#fff'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
                confirmButtonColor: "#5e6ffb",
                background: '#101966',
                color: '#fff'
            });
        @endif
    </script>
</x-app-layout>