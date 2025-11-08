<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Applicant Assessment
            </h2>

            <a href="{{ route('applicants.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto mt-4 sm:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Applicants
            </a>                
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    @if($applicant->payment_status !== 'verified')
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 text-yellow-800 dark:text-yellow-200 p-4 mb-6 rounded-r-lg" role="alert">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-bold">Payment Not Verified</p>
                                    <p class="text-sm">You cannot approve this applicant until their payment status is verified.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($applicant->payment_status === 'verified')
                        <div id="applicant-payment_status" class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-800 dark:text-green-200 p-4 mb-6 rounded-r-lg" role="alert">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-bold">Payment Verified</p>
                                    <p class="text-sm">This applicant has successfully completed their payment.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('applicants.approve', $applicant->id) }}" method="post" id="approvalForm">
                        @csrf
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
                                        <label for="first_name" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            First Name
                                        </label>
                                        <input id="first_name" value="{{ old('first_name', $applicant->first_name) }}" name="first_name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('first_name')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="middle_name" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Middle Name
                                        </label>
                                        <input id="middle_name" value="{{ old('middle_name', $applicant->middle_name) }}" name="middle_name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('middle_name')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="last_name" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Last Name
                                        </label>
                                        <input id="last_name" value="{{ old('last_name', $applicant->last_name) }}" name="last_name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('last_name')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="suffix" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            Suffix
                                        </label>
                                        <input id="suffix" value="{{ old('suffix', $applicant->suffix) }}" name="suffix" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('suffix')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="sex" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Sex
                                        </label>
                                        <select id="sex" name="sex" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly disabled>
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('sex', $applicant->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('sex', $applicant->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('sex')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="birthdate" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Birthdate
                                        </label>
                                        <input id="birthdate" value="{{ old('birthdate', $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('Y-m-d') : '') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('birthdate')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="civil_status" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Civil Status
                                        </label>
                                        <select id="civil_status" name="civil_status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly disabled>
                                            <option value="">Select</option>
                                            <option value="Single" {{ old('civil_status', $applicant->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ old('civil_status', $applicant->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Widowed" {{ old('civil_status', $applicant->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="Separated" {{ old('civil_status', $applicant->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        </select>
                                        @error('civil_status')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="citizenship" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                            </svg>
                                            Citizenship
                                        </label>
                                        <input id="citizenship" value="{{ old('citizenship', $applicant->citizenship) }}" name="citizenship" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('citizenship')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="blood_type" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                            Blood Type
                                        </label>
                                        <select id="blood_type" name="blood_type" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly disabled>
                                            <option value="">Select</option>
                                            <option value="A+" {{ old('blood_type', $applicant->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_type', $applicant->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_type', $applicant->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_type', $applicant->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_type', $applicant->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_type', $applicant->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_type', $applicant->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_type', $applicant->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_type')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
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
                                        <label for="cellphone_no" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Cellphone No.
                                        </label>
                                        <input id="cellphone_no" value="{{ old('cellphone_no', $applicant->cellphone_no) }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('cellphone_no')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="telephone_no" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Telephone No.
                                        </label>
                                        <input id="telephone_no" value="{{ old('telephone_no', $applicant->telephone_no) }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('telephone_no')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="email_address" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Email Address
                                        </label>
                                        <input id="email_address" value="{{ old('email_address', $applicant->email_address) }}" name="email_address" type="email" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('email_address')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Divider (Mobile Only) -->
                            <div class="col-span-2 md:hidden">
                                <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                            </div>

                            <!-- Emergency Contact -->
                            <div class="col-span-2 md:col-span-1">
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-rose-500 to-pink-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Emergency Contact</h3>
                                </div>
                                <div class="space-y-3 sm:space-y-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="emergency_contact" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Name
                                        </label>
                                        <input id="emergency_contact" value="{{ old('emergency_contact', $applicant->emergency_contact) }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('emergency_contact')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="emergency_contact_number" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Contact No.
                                        </label>
                                        <input id="emergency_contact_number" value="{{ old('emergency_contact_number', $applicant->emergency_contact_number) }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('emergency_contact_number')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="relationship" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                            </svg>
                                            Relationship
                                        </label>
                                        <input id="relationship" value="{{ old('relationship', $applicant->relationship) }}" name="relationship" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('relationship')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="col-span-1 md:col-span-2">
                                <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                            </div>

                            <!-- License Information -->
                            <div class="col-span-2">
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5M16 6h5a2 2 0 012 2v10a2 2 0 01-2 2h-5m-5-12l.117.469a7 7 0 00-1.06 14.061M16 12l.117.469a7 7 0 00-1.06 14.061" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">License Information</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_class" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            License Class
                                        </label>
                                        <input id="license_class" value="{{ old('license_class', $applicant->license_class) }}" name="license_class" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                        @error('license_class')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_number" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            License Number
                                        </label>
                                        <input id="license_number" value="{{ old('license_number', $applicant->license_number) }}" name="license_number" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                        @error('license_number')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_expiration_date" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Expiration Date
                                        </label>
                                        <input id="license_expiration_date" value="{{ old('license_expiration_date', $applicant->license_expiration_date ? \Carbon\Carbon::parse($applicant->license_expiration_date)->format('Y-m-d') : '') }}" name="license_expiration_date" type="date" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                        @error('license_expiration_date')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="col-span-1 md:col-span-2">
                                <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                            </div>

                            <!-- Address Information -->
                            <div class="col-span-2">
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
                                        <label for="house_building_number_name" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            House/Building No./Name
                                        </label>
                                        <input id="house_building_number_name" value="{{ old('house_building_number_name', $applicant->house_building_number_name) }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('house_building_number_name')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="street_address" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            Street Address
                                        </label>
                                        <input id="street_address" value="{{ old('street_address', $applicant->street_address) }}" name="street_address" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('street_address')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="region" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Region
                                        </label>
                                        <input id="region" value="{{ old('region', $regionName) }}" name="region" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('region')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="province" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Province
                                        </label>
                                        <input id="province" value="{{ old('province', $provinceName) }}" name="province" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('province')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="municipality" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Municipality
                                        </label>
                                        <input id="municipality" value="{{ old('municipality',  $municipalityName) }}" name="municipality" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('municipality')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="barangay" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Barangay
                                        </label>
                                        <input id="barangay" value="{{ old('barangay', $barangayName) }}" name="barangay" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('barangay')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="zip_code" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            Zip Code
                                        </label>
                                        <input id="zip_code" value="{{ old('zip_code', $applicant->zip_code) }}" name="zip_code" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100" readonly>
                                        @error('zip_code')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="col-span-1 md:col-span-2">
                                <hr class="border-t-2 border-gray-200 dark:border-gray-700">
                            </div>

                            <!-- Membership Information -->
                            <div class="col-span-2">
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Membership Information</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            REC Number
                                        </label>
                                        <div class="relative">
                                            <input value="{{ old('rec_number') }}" name="rec_number" id="rec_number" type="text" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm pr-28" required>
                                            <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                                                <button type="button" id="generateRecBtn" class="px-2.5 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                                                    Generate
                                                </button>
                                                <button type="button" id="configureRecBtn" data-modal-target="rec-config-modal" data-modal-toggle="rec-config-modal" class="px-2 py-1 text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        @error('rec_number')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="membership_type_id" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                            Membership Type
                                        </label>
                                        <select id="membership_type_id" name="membership_type_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm" required>
                                            <option value="">Select Type</option>
                                            @foreach($membershipTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('membership_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('membership_type_id')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="section_id" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Section
                                        </label>
                                        <select id="section_id" name="section_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                            <option value="">Select Section</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mt-4 sm:mt-5">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="membership_start" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Membership Start
                                        </label>
                                        <input id="membership_start" value="{{ old('membership_start', \Carbon\Carbon::now()->format('Y-m-d')) }}" name="membership_start" type="date" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm" required>
                                        @error('membership_start')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="membership_end" class="flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Membership End
                                        </label>
                                        <input id="membership_end" value="{{ old('membership_end', \Carbon\Carbon::now()->addYear()->format('Y-m-d')) }}" name="membership_end" type="date" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm" required>
                                        @error('membership_end')
                                        <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 p-4 rounded-lg border-2 border-yellow-300 dark:border-yellow-600 flex items-center shadow-lg hover:shadow-xl transition-shadow duration-200">
                                        <div class="flex items-center h-full gap-3">
                                            <div class="relative">
                                                <input type="checkbox" id="is_lifetime_member" name="is_lifetime_member" value="1" {{ old('is_lifetime_member') ? 'checked' : '' }} class="w-5 h-5 text-yellow-400 bg-yellow-100 border-yellow-400 rounded focus:ring-2 focus:ring-yellow-500 cursor-pointer">
                                                <svg class="absolute inset-0 w-5 h-5 text-yellow-500 opacity-0 pointer-events-none transition-opacity" style="display: none;" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <label for="is_lifetime_member" class="block text-xs font-bold text-yellow-800 dark:text-yellow-200 uppercase tracking-widest cursor-pointer flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                                Lifetime Member
                                            </label>
                                            @error('is_lifetime_member')
                                            <p class="text-red-500 font-medium text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Note Section and Buttons -->
                        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <!-- Note Section -->
                            <div class="flex-1 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-3 sm:p-4 rounded-r-lg">
                                <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-xs sm:text-sm text-blue-800 dark:text-blue-200 font-medium">Please review all applicant information carefully. Configure membership details including REC number, type, and dates before approving or rejecting.</p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 sm:flex-nowrap">
                            <!-- Approve Button -->
                            <button type="button" id="approveButton"
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-green-600 to-emerald-600 
                                  hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-green-600 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 w-full sm:w-auto"
                                @if($applicant->payment_status !== 'verified') disabled @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Approve & Create Member
                            </button>

                            <!-- Reject Button -->
                            <button type="button" id="rejectButton" 
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-red-600 to-pink-600 
                                  hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-red-600 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject Applicant
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#101966] mb-4"></div>
            <p class="text-gray-900 dark:text-gray-100 text-lg">Processing request...</p>
        </div>
    </div>

    <!-- REC Number Format Configuration Modal -->
    <div id="formatConfigModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Configure REC Number Format</h3>
                    <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Select Format Components:</label>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" id="format_prefix" value="REC" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="format_prefix" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Prefix "REC"</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="format_applicant_id" name="format_middle" value="applicant_id" checked class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="format_applicant_id" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Applicant ID</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="format_approval_day" name="format_middle" value="approval_day" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="format_approval_day" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Day of Approval (DD)</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="format_approval_month" name="format_middle" value="approval_month" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="format_approval_month" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Month of Approval (MM)</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="format_sequential" name="format_middle" value="sequential" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="format_sequential" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Sequential Number (Auto-increment)</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="format_year" value="year" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="format_year" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Current Year (YYYY)</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Separator:</label>
                    <select id="format_separator" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        <option value="-">Dash (-)</option>
                        <option value="">No Separator</option>
                        <option value="/">Slash (/)</option>
                        <option value="_">Underscore (_)</option>
                    </select>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">Preview:</p>
                    <p id="formatPreview" class="text-lg font-mono text-blue-900 dark:text-blue-100">REC-{{ $applicant->id }}-{{ date('Y') }}</p>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelFormatBtn" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg font-medium transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="button" id="saveFormatBtn" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
                        Save Format
                    </button>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applicantId = {{ $applicant->id }};
    let recNumberGenerated = false;
    let formatConfig = {
        prefix: true,
        middle: 'applicant_id',
        year: true,
        separator: '-'
    };
    
    // Load saved format from localStorage
    const savedFormat = localStorage.getItem('recNumberFormat');
    if (savedFormat) {
        formatConfig = JSON.parse(savedFormat);
    }
    
    // Generate REC Number based on current format
    function generateRecNumber() {
        let parts = [];
        
        if (formatConfig.prefix) {
            parts.push('REC');
        }
        
        // Middle part based on selection
        switch (formatConfig.middle) {
            case 'applicant_id':
                parts.push(applicantId);
                break;
            case 'approval_day':
                parts.push(new Date().getDate().toString().padStart(2, '0'));
                break;
            case 'approval_month':
                parts.push((new Date().getMonth() + 1).toString().padStart(2, '0'));
                break;
            case 'sequential':
                // This would need server-side logic to get the next sequential number
                parts.push('XXXX'); // Placeholder
                break;
        }
        
        if (formatConfig.year) {
            parts.push(new Date().getFullYear());
        }
        
        return parts.join(formatConfig.separator);
    }
    
    // Update format preview
    function updateFormatPreview() {
        document.getElementById('formatPreview').textContent = generateRecNumber();
    }
    
    // Generate REC Number button
    document.getElementById('generateRecBtn').addEventListener('click', function() {
        if (!recNumberGenerated) {
            const recNumber = generateRecNumber();
            document.getElementById('rec_number').value = recNumber;
            recNumberGenerated = true;
            this.disabled = true;
            this.classList.add('bg-gray-400', 'cursor-not-allowed');
            this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            this.textContent = 'Generated';
        }
    });
    
    // Configure Format button
    document.getElementById('configureRecBtn').addEventListener('click', function() {
        document.getElementById('formatConfigModal').classList.remove('hidden');
        
        // Set current format values
        document.getElementById('format_prefix').checked = formatConfig.prefix;
        document.querySelector(`input[name="format_middle"][value="${formatConfig.middle}"]`).checked = true;
        document.getElementById('format_year').checked = formatConfig.year;
        document.getElementById('format_separator').value = formatConfig.separator;
        
        updateFormatPreview();
    });
    
    // Close modal buttons
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('formatConfigModal').classList.add('hidden');
    });
    
    document.getElementById('cancelFormatBtn').addEventListener('click', function() {
        document.getElementById('formatConfigModal').classList.add('hidden');
    });
    
    // Save format configuration
    document.getElementById('saveFormatBtn').addEventListener('click', function() {
        formatConfig.prefix = document.getElementById('format_prefix').checked;
        formatConfig.middle = document.querySelector('input[name="format_middle"]:checked').value;
        formatConfig.year = document.getElementById('format_year').checked;
        formatConfig.separator = document.getElementById('format_separator').value;
        
        // Save to localStorage
        localStorage.setItem('recNumberFormat', JSON.stringify(formatConfig));
        
        // Reset generated state if format changed
        recNumberGenerated = false;
        const generateBtn = document.getElementById('generateRecBtn');
        generateBtn.disabled = false;
        generateBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        generateBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        generateBtn.textContent = 'Generate';
        
        document.getElementById('formatConfigModal').classList.add('hidden');
        
        Swal.fire({
            icon: 'success',
            title: 'Format Saved',
            text: 'REC Number format has been updated successfully',
            background: '#101966',
            color: '#fff',
            confirmButtonColor: '#5e6ffb',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // Update preview when format options change
    document.querySelectorAll('#formatConfigModal input, #formatConfigModal select').forEach(element => {
        element.addEventListener('change', updateFormatPreview);
    });
    
    // Lifetime membership toggle
    const lifetimeCheckbox = document.getElementById('is_lifetime_member');
    const membershipEndInput = document.querySelector('input[name="membership_end"]');
    
    if (lifetimeCheckbox && membershipEndInput) {
        lifetimeCheckbox.addEventListener('change', function() {
            membershipEndInput.disabled = this.checked;
            if (this.checked) {
                membershipEndInput.value = '';
            }
        });
        
        // Initialize state on page load
        if (lifetimeCheckbox.checked) {
            membershipEndInput.disabled = true;
        }
    }

    // Approve button functionality with SweetAlert
    const approveButton = document.getElementById('approveButton');
    if (approveButton) {
        approveButton.addEventListener('click', function() {
            if (this.disabled) return;
            
            Swal.fire({
                title: 'Approve Applicant?',
                text: "Are you sure you want to approve this applicant and create a member account?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                background: '#101966',
                color: '#fff',
                confirmButtonText: 'Yes, approve!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Creating member account',
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            document.getElementById('approvalForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });
    }

    // Reject button functionality with SweetAlert
    const rejectButton = document.getElementById('rejectButton');
    if (rejectButton) {
        rejectButton.addEventListener('click', function() {
            Swal.fire({
                title: 'Reject Applicant?',
                text: "Are you sure you want to reject this applicant? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                background: '#101966',
                color: '#fff',
                confirmButtonText: 'Yes, reject!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("applicants.reject", $applicant->id) }}';
                    
                    // Add CSRF token
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);
                    
                    document.body.appendChild(form);
                    
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Processing rejection',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            form.submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });
    }
});
</script>


</x-app-layout>