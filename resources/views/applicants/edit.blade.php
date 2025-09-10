<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Applicants / Edit</span>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('applicants.update', $applicant->id) }}" method="post" enctype="multipart/form-data" id="applicationForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium">First Name *</label>
                                        <input value="{{ old('first_name', $applicant->first_name) }}" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('first_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="middle_name" class="block text-sm font-medium">Middle Name</label>
                                        <input value="{{ old('middle_name', $applicant->middle_name) }}" name="middle_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('middle_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium">Last Name *</label>
                                        <input value="{{ old('last_name', $applicant->last_name) }}" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('last_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="suffix" class="block text-sm font-medium">Suffix</label>
                                        <input value="{{ old('suffix', $applicant->suffix) }}" name="suffix" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                            <option value="Male" {{ old('sex', $applicant->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('sex', $applicant->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('sex')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="birthdate" class="block text-sm font-medium">Birthdate *</label>
                                        <input value="{{ old('birthdate', $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('Y-m-d') : '') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('birthdate')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="civil_status" class="block text-sm font-medium">Civil Status *</label>
                                        <select name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select</option>
                                            <option value="Single" {{ old('civil_status', $applicant->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ old('civil_status', $applicant->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Widowed" {{ old('civil_status', $applicant->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="Separated" {{ old('civil_status', $applicant->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        </select>
                                        @error('civil_status')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="citizenship" class="block text-sm font-medium">Citizenship *</label>
                                        <input value="{{ old('citizenship', $applicant->citizenship) }}" name="citizenship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                        <input value="{{ old('cellphone_no', $applicant->cellphone_no) }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('cellphone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone_no" class="block text-sm font-medium">Telephone No.</label>
                                        <input value="{{ old('telephone_no', $applicant->telephone_no) }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('telephone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email_address" class="block text-sm font-medium">Email Address *</label>
                                        <input value="{{ old('email_address', $applicant->email_address) }}" name="email_address" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                        <input value="{{ old('emergency_contact', $applicant->emergency_contact) }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('emergency_contact')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="emergency_contact_number" class="block text-sm font-medium">Contact No. *</label>
                                        <input value="{{ old('emergency_contact_number', $applicant->emergency_contact_number) }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('emergency_contact_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="relationship" class="block text-sm font-medium">Relationship *</label>
                                        <input value="{{ old('relationship', $applicant->relationship) }}" name="relationship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                        <input value="{{ old('license_class', $applicant->license_class) }}" name="license_class" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('license_class')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="license_number" class="block text-sm font-medium">License Number</label>
                                        <input value="{{ old('license_number', $applicant->license_number) }}" name="license_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('license_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                    <label for="callsign" class="block text-sm font-medium">Callsign</label>
                                        <input value="{{ old('callsign', $applicant->callsign) }}" name="callsign" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('callsign')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="license_expiration_date" class="block text-sm font-medium">Expiration Date</label>
                                        <input value="{{ old('license_expiration_date', $applicant->license_expiration_date ? \Carbon\Carbon::parse($applicant->license_expiration_date)->format('Y-m-d') : '') }}" name="license_expiration_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                        <input value="{{ old('house_building_number_name', $applicant->house_building_number_name) }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('house_building_number_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="street_address" class="block text-sm font-medium">Street Address *</label>
                                        <input value="{{ old('street_address', $applicant->street_address) }}" name="street_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                                    <input value="{{ old('zip_code', $applicant->zip_code) }}" name="zip_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                            <button type="button" id="updateButton"
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                  bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                  dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Update
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
            <p class="text-gray-900 dark:text-gray-100 text-lg">Updating applicant information...</p>
        </div>
    </div>
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#updateButton').on('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Update Applicant Information?',
            text: "Are you sure you want to update this applicant's information?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5e6ffb',
            cancelButtonColor: '#d33',
            background: '#101966',
            color: '#fff',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Updating...',
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

    let selectedRegion = "{{ old('region', $applicant->region) }}";
    let selectedProvince = "{{ old('province', $applicant->province) }}";
    let selectedMunicipality = "{{ old('municipality', $applicant->municipality) }}";
    let selectedBarangay = "{{ old('barangay', $applicant->barangay) }}";   

    if (selectedRegion) {
        $('#region').val(selectedRegion);

        $.ajax({
            url: '/get-provinces/' + selectedRegion,
            type: 'GET',
            success: function(provinces) {
                provinces.forEach(function(prov) {
                    let selected = (prov.psgc_prov_code == selectedProvince) ? 'selected' : '';
                    $('#province').append('<option value="'+prov.psgc_prov_code+'" '+selected+'>'+prov.psgc_prov_desc+'</option>');
                });

                if (selectedProvince) {
                    $.ajax({
                        url: '/get-municipalities/' + selectedRegion + '/' + selectedProvince,
                        type: 'GET',
                        success: function(municipalities) {
                            municipalities.forEach(function(muni) {
                                let selected = (muni.psgc_munc_code == selectedMunicipality) ? 'selected' : '';
                                $('#municipality').append('<option value="'+muni.psgc_munc_code+'" '+selected+'>'+muni.psgc_munc_desc+'</option>');
                            });

                            if (selectedMunicipality) {
                                $.ajax({
                                    url: '/get-barangays/' + selectedRegion + '/' + selectedProvince + '/' + selectedMunicipality,
                                    type: 'GET',
                                    success: function(barangays) {
                                        barangays.forEach(function(brgy) {
                                            let selected = (brgy.psgc_brgy_code == selectedBarangay) ? 'selected' : '';
                                            $('#barangay').append('<option value="'+brgy.psgc_brgy_code+'" '+selected+'>'+brgy.psgc_brgy_desc+'</option>');
                                        });
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
    }

});
</script>
</x-app-layout>