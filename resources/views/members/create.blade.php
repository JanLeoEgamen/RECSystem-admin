<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Members / Create</span>
            </h2>

            <a href="{{ route('members.index') }}" 
            class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-semibold dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-all duration-200 
                    w-full sm:w-auto hover:shadow-lg">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Members
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 rounded-xl backdrop-blur-sm shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Create New Member</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new member to the system</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data" id="applicationForm">
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-red-800 dark:text-red-200 mb-2">Please correct the following errors:</h4>
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li class="text-red-600 dark:text-red-300 text-sm">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @csrf
                        
                        <!-- Applicant Selection Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Applicant Information</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Select an approved applicant to create member profile</p>
                                </div>
                            </div>

                            <div>
                                <label for="applicant_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Select Applicant <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <select name="applicant_id" id="applicant_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                    <option value="">Select Applicant</option>
                                    @foreach($applicants as $applicant)
                                        <option value="{{ $applicant->id }}" 
                                            {{ old('applicant_id') == $applicant->id ? 'selected' : '' }}
                                            data-region="{{ $applicant->region }}"
                                            data-province="{{ $applicant->province }}"
                                            data-municipality="{{ $applicant->municipality }}"
                                            data-barangay="{{ $applicant->barangay }}">
                                            {{ $applicant->first_name }} {{ $applicant->last_name }} 
                                            ({{ $applicant->email_address }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('applicant_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Personal Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Personal Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name <span class="text-red-500">*</span></label>
                                    <input id="first_name" value="{{ old('first_name') }}" name="first_name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('first_name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="middle_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Middle Name</label>
                                    <input id="middle_name" value="{{ old('middle_name') }}" name="middle_name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('middle_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-red-500">*</span></label>
                                    <input id="last_name" value="{{ old('last_name') }}" name="last_name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="suffix" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Suffix</label>
                                    <input id="suffix" value="{{ old('suffix') }}" name="suffix" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('suffix')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <label for="sex" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sex <span class="text-red-500">*</span></label>
                                    <select id="sex" name="sex" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('sex')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="birthdate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Birthdate <span class="text-red-500">*</span></label>
                                    <input id="birthdate" value="{{ old('birthdate') }}" name="birthdate" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('birthdate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="civil_status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Civil Status <span class="text-red-500">*</span></label>
                                    <select id="civil_status" name="civil_status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                        <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                    </select>
                                    @error('civil_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="citizenship" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Citizenship <span class="text-red-500">*</span></label>
                                    <input id="citizenship" value="{{ old('citizenship') }}" name="citizenship" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('citizenship')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <label for="blood_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Blood Type</label>
                                    <select id="blood_type" name="blood_type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                        <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('blood_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Emergency Information Cards in Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Contact Information Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Contact Information</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="cellphone_no" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cellphone No. <span class="text-red-500">*</span></label>
                                        <input id="cellphone_no" value="{{ old('cellphone_no') }}" name="cellphone_no" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('cellphone_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone_no" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Telephone No.</label>
                                        <input id="telephone_no" value="{{ old('telephone_no') }}" name="telephone_no" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('telephone_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email_address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                                        <input id="email_address" value="{{ old('email_address') }}" name="email_address" type="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('email_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-red-500 to-pink-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Emergency Contact</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="emergency_contact" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Name <span class="text-red-500">*</span></label>
                                        <input id="emergency_contact" value="{{ old('emergency_contact') }}" name="emergency_contact" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('emergency_contact')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="emergency_contact_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Contact No. <span class="text-red-500">*</span></label>
                                        <input id="emergency_contact_number" value="{{ old('emergency_contact_number') }}" name="emergency_contact_number" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('emergency_contact_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="relationship" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Relationship <span class="text-red-500">*</span></label>
                                        <input id="relationship" value="{{ old('relationship') }}" name="relationship" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        @error('relationship')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Membership Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Membership Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="rec_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Record Number <span class="text-red-500">*</span></label>
                                    <input id="rec_number" value="{{ old('rec_number') }}" name="rec_number" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('rec_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="membership_type_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Membership Type <span class="text-red-500">*</span></label>
                                    <select id="membership_type_id" name="membership_type_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select Type</option>
                                        @foreach($membershipTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('membership_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('membership_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="section_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Section</label>
                                    <select id="section_id" name="section_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->section_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('section_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label for="membership_start" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Membership Start <span class="text-red-500">*</span></label>
                                    <input id="membership_start" value="{{ old('membership_start') }}" name="membership_start" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('membership_start')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="membership_end" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Membership End</label>
                                    <input id="membership_end" value="{{ old('membership_end') }}" name="membership_end" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('membership_end')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center pt-7">
                                    <input type="checkbox" id="is_lifetime_member" name="is_lifetime_member" value="1" {{ old('is_lifetime_member') ? 'checked' : '' }} class="w-4 h-4 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_lifetime_member" class="ml-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">Lifetime Member</label>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="last_renewal_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Renewal Date</label>
                                    <input id="last_renewal_date" value="{{ old('last_renewal_date') }}" name="last_renewal_date" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('last_renewal_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status <span class="text-red-500">*</span></label>
                                    <select id="status" name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3" required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : 'selected' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- License Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">License Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="license_class" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">License Class</label>
                                    <input id="license_class" value="{{ old('license_class') }}" name="license_class" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('license_class')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="callsign" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Callsign</label>
                                    <input id="callsign" value="{{ old('callsign') }}" name="callsign" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('callsign')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="license_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">License Number</label>
                                    <input id="license_number" value="{{ old('license_number') }}" name="license_number" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('license_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="license_expiration_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Expiration Date</label>
                                    <input id="license_expiration_date" value="{{ old('license_expiration_date') }}" name="license_expiration_date" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('license_expiration_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Address Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="house_building_number_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">House/Building No./Name <span class="text-red-500">*</span></label>
                                    <input id="house_building_number_name" value="{{ old('house_building_number_name') }}" name="house_building_number_name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('house_building_number_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="street_address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Street Address <span class="text-red-500">*</span></label>
                                    <input id="street_address" value="{{ old('street_address') }}" name="street_address" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                    @error('street_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label for="region" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Region <span class="text-red-500">*</span></label>
                                    <select id="region" name="region" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->psgc_reg_code }}">{{ $region->psgc_reg_desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="province" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Province <span class="text-red-500">*</span></label>
                                    <select id="province" name="province" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="municipality" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Municipality <span class="text-red-500">*</span></label>
                                    <select id="municipality" name="municipality" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="barangay" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Barangay <span class="text-red-500">*</span></label>
                                    <select id="barangay" name="barangay" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="zip_code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Zip Code <span class="text-red-500">*</span></label>
                                <input id="zip_code" value="{{ old('zip_code') }}" name="zip_code" type="text" class="block w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                @error('zip_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- User Account Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">User Account Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input id="password" name="password" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3 pr-10" onkeyup="validatePassword()" required>
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password')">
                                            <svg id="password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="password-requirements" class="text-xs mt-2 hidden bg-gray-50 dark:bg-gray-900 rounded-lg p-3">
                                        <p class="text-gray-600 dark:text-gray-400 font-semibold mb-2">Password must contain:</p>
                                        <ul class="space-y-1">
                                            <li id="req-length" class="text-red-500 flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                                At least 8 characters
                                            </li>
                                            <li id="req-uppercase" class="text-red-500 flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                                One uppercase letter
                                            </li>
                                            <li id="req-lowercase" class="text-red-500 flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                                One lowercase letter
                                            </li>
                                            <li id="req-number" class="text-red-500 flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                                One number
                                            </li>
                                            <li id="req-special" class="text-red-500 flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                                One special character
                                            </li>
                                        </ul>
                                    </div>
                                    @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3 pr-10" onkeyup="validatePasswordConfirmation()" required>
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password_confirmation')">
                                            <svg id="password_confirmation-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="password_confirmation-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="password-confirmation-message" class="text-xs mt-2 hidden"></div>
                                    @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Generate Password Button -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" id="generatePasswordBtn" 
                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Generate Secure Password
                                </button>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Click to generate a strong password that meets all requirements</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

// Password generation function
function generateSecurePassword() {
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
    // Ensure we have at least one of each required character type
    let password = '';
    password += uppercase[Math.floor(Math.random() * uppercase.length)];
    password += lowercase[Math.floor(Math.random() * lowercase.length)];
    password += numbers[Math.floor(Math.random() * numbers.length)];
    password += specialChars[Math.floor(Math.random() * specialChars.length)];
    
    // Fill the rest with random characters from all sets
    const allChars = uppercase + lowercase + numbers + specialChars;
    const remainingLength = 8 - password.length;
    
    for (let i = 0; i < remainingLength; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
    }
    
    // Shuffle the password to make it more random
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    return password;
}

// Function to handle password generation
function handleGeneratePassword() {
    const generatedPassword = generateSecurePassword();
    
    // Set the generated password in both fields
    document.getElementById('password').value = generatedPassword;
    document.getElementById('password_confirmation').value = generatedPassword;
    
    // Trigger validation to show the requirements are met
    validatePassword();
    validatePasswordConfirmation();
    
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Password Generated!',
        text: 'A secure password has been generated and filled in both fields.',
        confirmButtonColor: '#10B981',
        background: '#101966',
        color: '#fff',
        timer: 2000,
        showConfirmButton: true
    });
}

// Add event listener to the generate password button
document.getElementById('generatePasswordBtn').addEventListener('click', handleGeneratePassword);



        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`${fieldId}-eye-icon`);
            const eyeSlashIcon = document.getElementById(`${fieldId}-eye-slash-icon`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value;
            const requirements = document.getElementById('password-requirements');
            
            if (password.length > 0) {
                requirements.classList.remove('hidden');
            } else {
                requirements.classList.add('hidden');
                return;
            }
            
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            document.getElementById('req-length').className = hasMinLength ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-uppercase').className = hasUppercase ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-lowercase').className = hasLowercase ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-number').className = hasNumber ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-special').className = hasSpecialChar ? 'text-green-500' : 'text-red-500';
            
            if (document.getElementById('password_confirmation').value.length > 0) {
                validatePasswordConfirmation();
            }
        }

        function validatePasswordConfirmation() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const messageElement = document.getElementById('password-confirmation-message');
            
            if (confirmPassword.length === 0) {
                messageElement.classList.add('hidden');
                return;
            }   
            
            messageElement.classList.remove('hidden');
            
            if (password === confirmPassword) {
                messageElement.innerHTML = '<p class="text-green-500">Passwords match!</p>';
            } else {
                messageElement.innerHTML = '<p class="text-red-500">Passwords do not match</p>';
            }
        }

        document.getElementById("applicationForm").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            if (!hasMinLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Requirements Not Met',
                    text: 'Password must have at least 8 characters with uppercase, lowercase, number, and special character.',
                    confirmButtonColor: '#101966'
                });
                return false;
            }
            
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords Do Not Match',
                    text: 'Please confirm your password correctly.',
                    confirmButtonColor: '#101966'
                });
                return false;
            }
            
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to create this member and user account?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#5e6ffb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Creating...',
                        text: 'Please wait',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            e.target.submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Created!",
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lifetimeCheckbox = document.getElementById('is_lifetime_member');
            const membershipEndInput = document.querySelector('input[name="membership_end"]');
            
            lifetimeCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    membershipEndInput.disabled = true;
                    membershipEndInput.value = '';
                } else {
                    membershipEndInput.disabled = false;
                }
            });
            
            if (lifetimeCheckbox.checked) {
                membershipEndInput.disabled = true;
            }
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#region').on('change', function() {
            let regionCode = $(this).val();
    
            $('#province').html('<option value="">Select</option>');
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
    
            if(regionCode) {
                $.ajax({
                    url: '/get-provinces/' + regionCode,
                    type: 'GET',
                    success: function(provinces) {
                        provinces.forEach(function(prov) {
                            $('#province').append('<option value="'+prov.psgc_prov_code+'">'+prov.psgc_prov_desc+'</option>');
                        });
                    }
                });
            }
        });
    
        $('#province').on('change', function() {
            let regionCode = $('#region').val();
            let provinceCode = $(this).val();
    
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
    
            if(regionCode && provinceCode) {
                $.ajax({
                    url: '/get-municipalities/' + regionCode + '/' + provinceCode,
                    type: 'GET',
                    success: function(municipalities) {
                        municipalities.forEach(function(muni) {
                            $('#municipality').append('<option value="'+muni.psgc_munc_code+'">'+muni.psgc_munc_desc+'</option>');
                        });
                    }
                });
            }
        });
    
        $('#municipality').on('change', function() {
            let regionCode = $('#region').val();
            let provinceCode = $('#province').val();
            let municipalityCode = $(this).val();
    
            $('#barangay').html('<option value="">Select</option>');
    
            if(regionCode && provinceCode && municipalityCode) {
                $.ajax({
                    url: '/get-barangays/' + regionCode + '/' + provinceCode + '/' + municipalityCode,
                    type: 'GET',
                    success: function(barangays) {
                        barangays.forEach(function(brgy) {
                            $('#barangay').append('<option value="'+brgy.psgc_brgy_code+'">'+brgy.psgc_brgy_desc+'</option>');
                        });
                    }
                });
            }
        });

        $('#applicant_id').on('change', function() {
            const applicantId = $(this).val();
            
            if (applicantId) {
                $(this).attr('disabled', true);
                
                $.ajax({
                    url: '/members/applicants/' + applicantId,
                    method: 'GET',
                    success: function(data) {
                        $('#first_name').val(data.first_name);
                        $('#middle_name').val(data.middle_name);
                        $('#last_name').val(data.last_name);
                        $('#suffix').val(data.suffix);
                        $('#sex').val(data.sex);
                        $('#birthdate').val(data.birthdate);
                        $('#civil_status').val(data.civil_status);
                        $('#citizenship').val(data.citizenship);
                        $('#blood_type').val(data.blood_type);
                        
                        $('#cellphone_no').val(data.cellphone_no);
                        $('#telephone_no').val(data.telephone_no);
                        $('#email_address').val(data.email_address);
                        
                        $('#emergency_contact').val(data.emergency_contact);
                        $('#emergency_contact_number').val(data.emergency_contact_number);
                        $('#relationship').val(data.relationship);
                        
                        $('#license_class').val(data.license_class);
                        $('#license_number').val(data.license_number);
                        $('#license_expiration_date').val(data.license_expiration_date);
                        
                        $('#house_building_number_name').val(data.house_building_number_name);
                        $('#street_address').val(data.street_address);
                        $('#zip_code').val(data.zip_code);
                        
                        loadAddressData(data.region, data.province, data.municipality, data.barangay);
                    },
                    error: function(xhr) {
                        console.error('Error loading applicant data:', xhr.responseText);
                        alert('Failed to load applicant data. Please try again.');
                    },
                    complete: function() {
                        $('#applicant_id').attr('disabled', false);
                    }
                });
            } else {
                clearFormFields();
            }
        });
        
        function loadAddressData(region, province, municipality, barangay) {
            $('#province, #municipality, #barangay').empty().append('<option value="">Select...</option>');
            
            if (region) {
                $('#region').val(region);
                
                $.get('/get-provinces/' + region, function(provinces) {
                    provinces.forEach(function(prov) {
                        const selected = (prov.psgc_prov_code == province) ? 'selected' : '';
                        $('#province').append(`<option value="${prov.psgc_prov_code}" ${selected}>${prov.psgc_prov_desc}</option>`);
                    });
                    
                    if (province) {
                        $.get(`/get-municipalities/${region}/${province}`, function(municipalities) {
                            municipalities.forEach(function(muni) {
                                const selected = (muni.psgc_munc_code == municipality) ? 'selected' : '';
                                $('#municipality').append(`<option value="${muni.psgc_munc_code}" ${selected}>${muni.psgc_munc_desc}</option>`);
                            });
                            
                            if (municipality) {
                                $.get(`/get-barangays/${region}/${province}/${municipality}`, function(barangays) {
                                    barangays.forEach(function(brgy) {
                                        const selected = (brgy.psgc_brgy_code == barangay) ? 'selected' : '';
                                        $('#barangay').append(`<option value="${brgy.psgc_brgy_code}" ${selected}>${brgy.psgc_brgy_desc}</option>`);
                                    });
                                });
                            }
                        });
                    }
                });
            }
        }
        
        function clearFormFields() {
            $('input[type="text"], input[type="email"], input[type="date"]').val('');
            $('select').val('');
            $('#province, #municipality, #barangay').empty().append('<option value="">Select...</option>');
        }
        
        if ($('#applicant_id').val()) {
            $('#applicant_id').trigger('change');
        }
    });
    </script>
</x-app-layout>