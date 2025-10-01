<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Student Applicants / Create
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('student-applicants.store') }}" method="post" enctype="multipart/form-data" id="applicationForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium">First Name *</label>
                                        <input value="{{ old('first_name') }}" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                        <input value="{{ old('last_name') }}" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                        <select name="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                        <input value="{{ old('birthdate') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('birthdate')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="civil_status" class="block text-sm font-medium">Civil Status *</label>
                                        <select name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                        <input value="{{ old('citizenship', 'Filipino') }}" name="citizenship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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

                            <!-- Student Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Student Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="student_number" class="block text-sm font-medium">Student Number</label>
                                        <input value="{{ old('student_number') }}" name="student_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. 2023-00123">
                                        @error('student_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="school" class="block text-sm font-medium">School/University</label>
                                        <input value="{{ old('school') }}" name="school" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. University of the Philippines">
                                        @error('school')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="program" class="block text-sm font-medium">Program/Course</label>
                                        <input value="{{ old('program') }}" name="program" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. Bachelor of Science in Computer Science">
                                        @error('program')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="year_level" class="block text-sm font-medium">Year Level</label>
                                        <select name="year_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select Year Level</option>
                                            <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                            <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                            <option value="5th Year" {{ old('year_level') == '5th Year' ? 'selected' : '' }}>5th Year</option>
                                            <option value="Graduate" {{ old('year_level') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                            <option value="Postgraduate" {{ old('year_level') == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                                        </select>
                                        @error('year_level')
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
                                        <input value="{{ old('cellphone_no') }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. 09171234567">
                                        @error('cellphone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone_no" class="block text-sm font-medium">Telephone No.</label>
                                        <input value="{{ old('telephone_no') }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. 2-XXXX-XXXX">
                                        @error('telephone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email_address" class="block text-sm font-medium">Email Address *</label>
                                        <input value="{{ old('email_address') }}" name="email_address" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. juan.delacruz@gmail.com">
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
                                        <input value="{{ old('emergency_contact') }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. Maria Reyes Cruz">
                                        @error('emergency_contact')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="emergency_contact_number" class="block text-sm font-medium">Contact No. *</label>
                                        <input value="{{ old('emergency_contact_number') }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. 09171234567">
                                        @error('emergency_contact_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="relationship" class="block text-sm font-medium">Relationship *</label>
                                        <input value="{{ old('relationship') }}" name="relationship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. Mother">
                                        @error('relationship')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- License Information -->
                            <div>
                                <h3 class="text-xl font-semibold mb-4">License Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="license_class" class="block text-sm font-medium">License Class</label>
                                        <select name="license_class" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select License Class</option>
                                            <option value="Class A" {{ old('license_class') == 'Class A' ? 'selected' : '' }}>Class A</option>
                                            <option value="Class B" {{ old('license_class') == 'Class B' ? 'selected' : '' }}>Class B</option>
                                            <option value="Class C" {{ old('license_class') == 'Class C' ? 'selected' : '' }}>Class C</option>
                                            <option value="Class D" {{ old('license_class') == 'Class D' ? 'selected' : '' }}>Class D</option>
                                        </select>
                                        @error('license_class')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="license_number" class="block text-sm font-medium">License Number</label>
                                        <input value="{{ old('license_number') }}" name="license_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. A01-23-456789">
                                        @error('license_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="callsign" class="block text-sm font-medium">Callsign</label>
                                        <input value="{{ old('callsign') }}" name="callsign" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. DU1ABC">
                                        @error('callsign')
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
                                        <input value="{{ old('house_building_number_name') }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. Blk/Lot">
                                        @error('house_building_number_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="street_address" class="block text-sm font-medium">Street Address *</label>
                                        <input value="{{ old('street_address') }}" name="street_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="e.g. Acacia St.">
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
                                        </select>
                                    </div>
                                    <div>
                                        <label for="municipality" class="block text-sm font-medium">Municipality *</label>
                                        <select id="municipality" name="municipality" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="barangay" class="block text-sm font-medium">Barangay *</label>
                                        <select id="barangay" name="barangay" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="zip_code" class="block text-sm font-medium">Zip Code *</label>
                                    <input value="{{ old('zip_code') }}" name="zip_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="0000">
                                    @error('zip_code')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                    @error('region')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                    @error('province')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                    @error('municipality')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                    @error('barangay')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="button" id="createButton"
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                  bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                  dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Student Applicant
                            </button>
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
            <p class="text-gray-900 dark:text-gray-100 text-lg">Creating student applicant...</p>
        </div>
    </div>
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#createButton').on('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Create Student Applicant?',
            text: "Are you sure you want to create this student applicant?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5e6ffb',
            cancelButtonColor: '#d33',
            background: '#101966',
            color: '#fff',
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'Cancel'
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
                        $('#applicationForm').submit();
                    },
                    background: '#101966',
                    color: '#fff',
                    allowOutsideClick: false
                });
            }
        });
    });

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

    // Set student applicant flag
    $('<input>').attr({
        type: 'hidden',
        name: 'is_student',
        value: '1'
    }).appendTo('#applicationForm');
});
</script>
</x-app-layout>