<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members / Create</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen">
        <div class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                        Members / Create
                    </h2>
                    <a href="{{ route('members.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Members
                    </a>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data" id="applicationForm">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Applicant Selection -->
                                <div class="col-span-2">
                                    <h3 class="text-xl font-semibold mb-4">Applicant Information</h3>
                                    <div>
                                        <label for="applicant_id" class="block text-sm font-medium">Select Applicant *</label>
                                        <select name="applicant_id" id="applicantSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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

                                <!-- Personal Information -->
                                <div class="col-span-2">
                                    <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium">First Name *</label>
                                            <input value="{{ old('first_name') }}" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('first_name')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="middle_name" class="block text-sm font-medium">Middle Name</label>
                                            <input value="{{ old('middle_name') }}" name="middle_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('middle_name')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium">Last Name *</label>
                                            <input value="{{ old('last_name') }}" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('last_name')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="suffix" class="block text-sm font-medium">Suffix</label>
                                            <input value="{{ old('suffix') }}" name="suffix" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('suffix')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                        <div>
                                            <label for="sex" class="block text-sm font-medium">Sex *</label>
                                            <select name="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                            <input value="{{ old('birthdate') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('birthdate')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="civil_status" class="block text-sm font-medium">Civil Status *</label>
                                            <select name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                            <input value="{{ old('citizenship') }}" name="citizenship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('citizenship')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                        <div>
                                            <label for="blood_type" class="block text-sm font-medium">Blood Type</label>
                                            <select name="blood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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

                                <!-- Contact Information -->
                                <div>
                                    <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="cellphone_no" class="block text-sm font-medium">Cellphone No. *</label>
                                            <input value="{{ old('cellphone_no') }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('cellphone_no')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="telephone_no" class="block text-sm font-medium">Telephone No.</label>
                                            <input value="{{ old('telephone_no') }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('telephone_no')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email_address" class="block text-sm font-medium">Email Address *</label>
                                            <input value="{{ old('email_address') }}" name="email_address" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('email_address')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact -->
                                <div>
                                    <h3 class="text-xl font-semibold mb-4">Emergency Contact</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="emergency_contact" class="block text-sm font-medium">Name *</label>
                                            <input value="{{ old('emergency_contact') }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('emergency_contact')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="emergency_contact_number" class="block text-sm font-medium">Contact No. *</label>
                                            <input value="{{ old('emergency_contact_number') }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('emergency_contact_number')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="relationship" class="block text-sm font-medium">Relationship *</label>
                                            <input value="{{ old('relationship') }}" name="relationship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('relationship')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Membership Information -->
                                <div class="col-span-2">
                                    <h3 class="text-xl font-semibold mb-4">Membership Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="rec_number" class="block text-sm font-medium">Record Number *</label>
                                            <input value="{{ old('rec_number') }}" name="rec_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('rec_number')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="membership_type_id" class="block text-sm font-medium">Membership Type *</label>
                                            <select name="membership_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                            <select name="section_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                            <input value="{{ old('membership_start') }}" name="membership_start" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('membership_start')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="membership_end" class="block text-sm font-medium">Membership End</label>
                                            <input value="{{ old('membership_end') }}" name="membership_end" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('membership_end')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="is_lifetime_member" name="is_lifetime_member" value="1" {{ old('is_lifetime_member') ? 'checked' : '' }} class="rounded">
                                            <label for="is_lifetime_member" class="ml-2 block text-sm font-medium">Lifetime Member</label>
                                            @error('is_lifetime_member')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="last_renewal_date" class="block text-sm font-medium">Last Renewal Date</label>
                                        <input value="{{ old('last_renewal_date') }}" name="last_renewal_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('last_renewal_date')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- License Information -->
                                <div class="col-span-2">
                                    <h3 class="text-xl font-semibold mb-4">License Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="license_class" class="block text-sm font-medium">License Class</label>
                                            <input value="{{ old('license_class') }}" name="license_class" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('license_class')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="callsign" class="block text-sm font-medium">Callsign</label>
                                            <input value="{{ old('callsign') }}" name="callsign" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('callsign')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="license_number" class="block text-sm font-medium">License Number</label>
                                            <input value="{{ old('license_number') }}" name="license_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('license_number')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="license_expiration_date" class="block text-sm font-medium">Expiration Date</label>
                                            <input value="{{ old('license_expiration_date') }}" name="license_expiration_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('license_expiration_date')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="col-span-2">
                                    <h3 class="text-xl font-semibold mb-4">Address Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="house_building_number_name" class="block text-sm font-medium">House/Building No./Name *</label>
                                            <input value="{{ old('house_building_number_name') }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('house_building_number_name')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="street_address" class="block text-sm font-medium">Street Address *</label>
                                            <input value="{{ old('street_address') }}" name="street_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('street_address')
                                            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                        <div>
                                            <label for="region" class="block text-sm font-medium">Region *</label>
                                            <select id="region" name="region" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="">Select</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->psgc_reg_code }}">{{ $region->psgc_reg_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="province" class="block text-sm font-medium">Province *</label>
                                            <select id="province" name="province" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="">Select</option>
                                                <!-- Provinces loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                        <div>
                                            <label for="municipality" class="block text-sm font-medium">Municipality *</label>
                                            <select id="municipality" name="municipality" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="">Select</option>
                                                <!-- Municipalities loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                        <div>
                                            <label for="barangay" class="block text-sm font-medium">Barangay *</label>
                                            <select id="barangay" name="barangay" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="">Select</option>
                                                <!-- Barangays loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="zip_code" class="block text-sm font-medium">Zip Code *</label>
                                        <input value="{{ old('zip_code') }}" name="zip_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('zip_code')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
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
    </div>

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
            
            // Initialize state on page load
            if (lifetimeCheckbox.checked) {
                membershipEndInput.disabled = true;
            }
        });
    </script>
    
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

        // Handle applicant selection change
        $('#applicantSelect').on('change', function() {
            const applicantId = $(this).val();
            
            if (applicantId) {
                // Show loading state
                $(this).attr('disabled', true);
                
                // Fetch applicant data using the correct route
                $.ajax({
                    url: '/members/applicants/' + applicantId,
                    method: 'GET',
                    success: function(data) {
                        // Personal Information
                        $('input[name="first_name"]').val(data.first_name);
                        $('input[name="middle_name"]').val(data.middle_name);
                        $('input[name="last_name"]').val(data.last_name);
                        $('input[name="suffix"]').val(data.suffix);
                        $('select[name="sex"]').val(data.sex);
                        $('input[name="birthdate"]').val(data.birthdate);
                        $('select[name="civil_status"]').val(data.civil_status);
                        $('input[name="citizenship"]').val(data.citizenship);
                        $('select[name="blood_type"]').val(data.blood_type);
                        
                        // Contact Information
                        $('input[name="cellphone_no"]').val(data.cellphone_no);
                        $('input[name="telephone_no"]').val(data.telephone_no);
                        $('input[name="email_address"]').val(data.email_address);
                        
                        // Emergency Contact
                        $('input[name="emergency_contact"]').val(data.emergency_contact);
                        $('input[name="emergency_contact_number"]').val(data.emergency_contact_number);
                        $('input[name="relationship"]').val(data.relationship);
                        
                        // License Information
                        $('input[name="license_class"]').val(data.license_class);
                        $('input[name="license_number"]').val(data.license_number);
                        $('input[name="license_expiration_date"]').val(data.license_expiration_date);
                        
                        // Address Information
                        $('input[name="house_building_number_name"]').val(data.house_building_number_name);
                        $('input[name="street_address"]').val(data.street_address);
                        $('input[name="zip_code"]').val(data.zip_code);
                        
                        // Handle address dropdowns
                        loadAddressData(data.region, data.province, data.municipality, data.barangay);
                    },
                    error: function(xhr) {
                        console.error('Error loading applicant data:', xhr.responseText);
                        alert('Failed to load applicant data. Please try again.');
                    },
                    complete: function() {
                        $('#applicantSelect').attr('disabled', false);
                    }
                });
            } else {
                // Clear all fields if no applicant is selected
                clearFormFields();
            }
        });
        
        function loadAddressData(region, province, municipality, barangay) {
            // Reset dependent dropdowns first
            $('#province, #municipality, #barangay').empty().append('<option value="">Select...</option>');
            
            if (region) {
                $('#region').val(region);
                
                // Load provinces
                $.get('/get-provinces/' + region, function(provinces) {
                    provinces.forEach(function(prov) {
                        const selected = (prov.psgc_prov_code == province) ? 'selected' : '';
                        $('#province').append(`<option value="${prov.psgc_prov_code}" ${selected}>${prov.psgc_prov_desc}</option>`);
                    });
                    
                    if (province) {
                        // Load municipalities
                        $.get(`/get-municipalities/${region}/${province}`, function(municipalities) {
                            municipalities.forEach(function(muni) {
                                const selected = (muni.psgc_munc_code == municipality) ? 'selected' : '';
                                $('#municipality').append(`<option value="${muni.psgc_munc_code}" ${selected}>${muni.psgc_munc_desc}</option>`);
                            });
                            
                            if (municipality) {
                                // Load barangays
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
            // Clear all input fields
            $('input[type="text"], input[type="email"], input[type="date"]').val('');
            
            // Clear all select fields
            $('select').val('');
            
            // Clear dynamic dropdowns
            $('#province, #municipality, #barangay').empty().append('<option value="">Select...</option>');
        }
        
        // Initialize form if an applicant is already selected on page load
        if ($('#applicantSelect').val()) {
            $('#applicantSelect').trigger('change');
        }
    });
    </script>
</body>
</html>