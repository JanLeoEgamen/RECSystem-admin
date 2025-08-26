<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Members / Create</span>
            </h2>

            <a href="{{ route('members.index') }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Members
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data" id="applicationForm">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4 p-4 bg-red-100 dark:bg-red-900 rounded-md">
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li class="text-red-600 dark:text-red-300">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Applicant Information</h3>
                                <div>
                                    <label for="applicant_id" class="block text-sm font-medium">Select Applicant *</label>
                                    <select name="applicant_id" id="applicant_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
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
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium">First Name *</label>
                                        <input id="first_name" value="{{ old('first_name') }}" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('first_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="middle_name" class="block text-sm font-medium">Middle Name</label>
                                        <input id="middle_name" value="{{ old('middle_name') }}" name="middle_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('middle_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium">Last Name *</label>
                                        <input id="last_name" value="{{ old('last_name') }}" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('last_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="suffix" class="block text-sm font-medium">Suffix</label>
                                        <input id="suffix" value="{{ old('suffix') }}" name="suffix" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('suffix')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="sex" class="block text-sm font-medium">Sex *</label>
                                        <select id="sex" name="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('sex')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="birthdate" class="block text-sm font-medium">Birthdate *</label>
                                        <input id="birthdate" value="{{ old('birthdate') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('birthdate')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="civil_status" class="block text-sm font-medium">Civil Status *</label>
                                        <select id="civil_status" name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        </select>
                                        @error('civil_status')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="citizenship" class="block text-sm font-medium">Citizenship *</label>
                                        <input id="citizenship" value="{{ old('citizenship') }}" name="citizenship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('citizenship')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="blood_type" class="block text-sm font-medium">Blood Type</label>
                                        <select id="blood_type" name="blood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
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
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="cellphone_no" class="block text-sm font-medium">Cellphone No. *</label>
                                        <input id="cellphone_no" value="{{ old('cellphone_no') }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('cellphone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone_no" class="block text-sm font-medium">Telephone No.</label>
                                        <input id="telephone_no" value="{{ old('telephone_no') }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('telephone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email_address" class="block text-sm font-medium">Email Address *</label>
                                        <input id="email_address" value="{{ old('email_address') }}" name="email_address" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('email_address')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold mb-4">Emergency Contact</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="emergency_contact" class="block text-sm font-medium">Name *</label>
                                        <input id="emergency_contact" value="{{ old('emergency_contact') }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('emergency_contact')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="emergency_contact_number" class="block text-sm font-medium">Contact No. *</label>
                                        <input id="emergency_contact_number" value="{{ old('emergency_contact_number') }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('emergency_contact_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="relationship" class="block text-sm font-medium">Relationship *</label>
                                        <input id="relationship" value="{{ old('relationship') }}" name="relationship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('relationship')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Membership Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="rec_number" class="block text-sm font-medium">Record Number *</label>
                                        <input id="rec_number" value="{{ old('rec_number') }}" name="rec_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('rec_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="membership_type_id" class="block text-sm font-medium">Membership Type *</label>
                                        <select id="membership_type_id" name="membership_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select Type</option>
                                            @foreach($membershipTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('membership_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('membership_type_id')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="section_id" class="block text-sm font-medium">Section</label>
                                        <select id="section_id" name="section_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select Section</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div>
                                        <label for="membership_start" class="block text-sm font-medium">Membership Start *</label>
                                        <input id="membership_start" value="{{ old('membership_start') }}" name="membership_start" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('membership_start')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="membership_end" class="block text-sm font-medium">Membership End</label>
                                        <input id="membership_end" value="{{ old('membership_end') }}" name="membership_end" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('membership_end')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_lifetime_member" name="is_lifetime_member" value="1" {{ old('is_lifetime_member') ? 'checked' : '' }} class="rounded dark:bg-gray-700">
                                        <label for="is_lifetime_member" class="ml-2 block text-sm font-medium">Lifetime Member</label>
                                        @error('is_lifetime_member')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="last_renewal_date" class="block text-sm font-medium">Last Renewal Date</label>
                                    <input id="last_renewal_date" value="{{ old('last_renewal_date') }}" name="last_renewal_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                    @error('last_renewal_date')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                    </div>
                            </div>

                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">License Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="license_class" class="block text-sm font-medium">License Class</label>
                                        <input id="license_class" value="{{ old('license_class') }}" name="license_class" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('license_class')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="callsign" class="block text-sm font-medium">Callsign</label>
                                        <input id="callsign" value="{{ old('callsign') }}" name="callsign" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('callsign')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="license_number" class="block text-sm font-medium">License Number</label>
                                        <input id="license_number" value="{{ old('license_number') }}" name="license_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('license_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="license_expiration_date" class="block text-sm font-medium">Expiration Date</label>
                                        <input id="license_expiration_date" value="{{ old('license_expiration_date') }}" name="license_expiration_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('license_expiration_date')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Address Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="house_building_number_name" class="block text-sm font-medium">House/Building No./Name *</label>
                                        <input id="house_building_number_name" value="{{ old('house_building_number_name') }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('house_building_number_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="street_address" class="block text-sm font-medium">Street Address *</label>
                                        <input id="street_address" value="{{ old('street_address') }}" name="street_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                        @error('street_address')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="region" class="block text-sm font-medium">Region *</label>
                                        <select id="region" name="region" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->psgc_reg_code }}">{{ $region->psgc_reg_desc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="province" class="block text-sm font-medium">Province *</label>
                                        <select id="province" name="province" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="municipality" class="block text-sm font-medium">Municipality *</label>
                                        <select id="municipality" name="municipality" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="barangay" class="block text-sm font-medium">Barangay *</label>
                                        <select id="barangay" name="barangay" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="zip_code" class="block text-sm font-medium">Zip Code *</label>
                                    <input id="zip_code" value="{{ old('zip_code') }}" name="zip_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                                    @error('zip_code')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("applicationForm").addEventListener("submit", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to create this member?",
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