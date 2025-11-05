<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fade-out {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
    .animate-fade-out {
        animation: fade-out 0.3s ease-out forwards;
    }
</style>

<x-app-layout>
@if(session('success'))
<div id="success-notification" class="fixed top-4 right-4 z-50 p-4 bg-green-500 text-white rounded-lg shadow-lg flex items-center animate-fade-in">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span>{{ session('success') }}</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($applicant) && $applicant->region)
        loadProvinces('{{ $applicant->region }}');
    @endif

    function loadProvinces(regionCode) {
        $.ajax({
            url: '/get-provinces/' + regionCode,
            type: 'GET',
            success: function(provinces) {
                $('#province').html('<option value="">Select</option>');
                provinces.forEach(function(prov) {
                    $('#province').append('<option value="'+prov.PSGC_PROV_CODE+'">'+prov.PSGC_PROV_DESC+'</option>');
                });
                
                // Select the applicant's province if available
                @if(isset($applicant) && $applicant->province)
                    $('#province').val('{{ $applicant->province }}');
                    loadMunicipalities('{{ $applicant->region }}', '{{ $applicant->province }}');
                @endif
            }
        });
    }

    function loadMunicipalities(regionCode, provinceCode) {
        $.ajax({
            url: '/get-municipalities/' + regionCode + '/' + provinceCode,
            type: 'GET',
            success: function(municipalities) {
                $('#municipality').html('<option value="">Select</option>');
                municipalities.forEach(function(muni) {
                    $('#municipality').append('<option value="'+muni.PSGC_MUNC_CODE+'">'+muni.PSGC_MUNC_DESC+'</option>');
                });
                
                // Select the applicant's municipality if available
                @if(isset($applicant) && $applicant->municipality)
                    $('#municipality').val('{{ $applicant->municipality }}');
                    loadBarangays('{{ $applicant->region }}', '{{ $applicant->province }}', '{{ $applicant->municipality }}');
                @endif
            }
        });
    }

    function loadBarangays(regionCode, provinceCode, municipalityCode) {
        $.ajax({
            url: '/get-barangays/' + regionCode + '/' + provinceCode + '/' + municipalityCode,
            type: 'GET',
            success: function(barangays) {
                $('#barangay').html('<option value="">Select</option>');
                barangays.forEach(function(brgy) {
                    $('#barangay').append('<option value="'+brgy.PSGC_BRGY_CODE+'">'+brgy.PSGC_BRGY_DESC+'</option>');
                });
                
                // Select the applicant's barangay if available
                @if(isset($applicant) && $applicant->barangay)
                    $('#barangay').val('{{ $applicant->barangay }}');
                @endif
            }
        });
    }

    // Regular AJAX handlers for when users change dropdowns manually
    $('#region').on('change', function() {
        let regionCode = $(this).val();
        if(regionCode) {
            loadProvinces(regionCode);
        } else {
            $('#province').html('<option value="">Select</option>');
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
        }
    });

    $('#province').on('change', function() {
        let regionCode = $('#region').val();
        let provinceCode = $(this).val();
        if(regionCode && provinceCode) {
            loadMunicipalities(regionCode, provinceCode);
        } else {
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
        }
    });

    $('#municipality').on('change', function() {
        let regionCode = $('#region').val();
        let provinceCode = $('#province').val();
        let municipalityCode = $(this).val();
        if(regionCode && provinceCode && municipalityCode) {
            loadBarangays(regionCode, provinceCode, municipalityCode);
        } else {
            $('#barangay').html('<option value="">Select</option>');
        }
    });

    const notification = document.getElementById('success-notification');
    if (notification) {
        setTimeout(() => {
            notification.classList.remove('animate-fade-in');
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    const hasLicenseCheckbox = document.getElementById('hasLicense');
    const licenseSection = document.getElementById('license-info');
    
    // Show license section if applicant has license data or checkbox is checked
    if ({{ $applicant->has_license ?? 'false' }} || hasLicenseCheckbox.checked) {
        licenseSection.style.display = 'block';
        // Make license fields required
        document.getElementById('licenseClass').required = true;
        document.getElementById('licenseNumber').required = true;
        document.getElementById('expirationDate').required = true;
    }
    
    // Toggle license section when checkbox changes
    hasLicenseCheckbox.addEventListener('change', function() {
        if (this.checked) {
            licenseSection.style.display = 'block';
            // Make license fields required
            document.getElementById('licenseClass').required = true;
            document.getElementById('licenseNumber').required = true;
            document.getElementById('expirationDate').required = true;
        } else {
            licenseSection.style.display = 'none';
            // Remove required attributes
            document.getElementById('licenseClass').required = false;
            document.getElementById('licenseNumber').required = false;
            document.getElementById('expirationDate').required = false;
        }
    });

    // If region is already selected, load provinces
    @if(isset($applicant) && $applicant->region)
        loadProvinces('{{ $applicant->region }}');
    @endif

    function loadProvinces(regionCode) {
        $.ajax({
            url: '/get-provinces/' + regionCode,
            type: 'GET',
            success: function(provinces) {
                $('#province').html('<option value="">Select</option>');
                provinces.forEach(function(prov) {
                    $('#province').append('<option value="'+prov.psgc_prov_code+'">'+prov.psgc_prov_desc+'</option>');
                });
                
                // Select the applicant's province if available
                @if(isset($applicant) && $applicant->province)
                    $('#province').val('{{ $applicant->province }}');
                    loadMunicipalities('{{ $applicant->region }}', '{{ $applicant->province }}');
                @endif
            }
        });
    }

    function loadMunicipalities(regionCode, provinceCode) {
        $.ajax({
            url: '/get-municipalities/' + regionCode + '/' + provinceCode,
            type: 'GET',
            success: function(municipalities) {
                $('#municipality').html('<option value="">Select</option>');
                municipalities.forEach(function(muni) {
                    $('#municipality').append('<option value="'+muni.psgc_munc_code+'">'+muni.psgc_munc_desc+'</option>');
                });
                
                // Select the applicant's municipality if available
                @if(isset($applicant) && $applicant->municipality)
                    $('#municipality').val('{{ $applicant->municipality }}');
                    loadBarangays('{{ $applicant->region }}', '{{ $applicant->province }}', '{{ $applicant->municipality }}');
                @endif
            }
        });
    }

    function loadBarangays(regionCode, provinceCode, municipalityCode) {
        $.ajax({
            url: '/get-barangays/' + regionCode + '/' + provinceCode + '/' + municipalityCode,
            type: 'GET',
            success: function(barangays) {
                $('#barangay').html('<option value="">Select</option>');
                barangays.forEach(function(brgy) {
                    $('#barangay').append('<option value="'+brgy.psgc_brgy_code+'">'+brgy.psgc_brgy_desc+'</option>');
                });
                
                // Select the applicant's barangay if available
                @if(isset($applicant) && $applicant->barangay)
                    $('#barangay').val('{{ $applicant->barangay }}');
                @endif
            }
        });
    }

    // Regular AJAX handlers for when users change dropdowns manually
    $('#region').on('change', function() {
        let regionCode = $(this).val();
        if(regionCode) {
            loadProvinces(regionCode);
        } else {
            $('#province').html('<option value="">Select</option>');
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
        }
    });

    $('#province').on('change', function() {
        let regionCode = $('#region').val();
        let provinceCode = $(this).val();
        if(regionCode && provinceCode) {
            loadMunicipalities(regionCode, provinceCode);
        } else {
            $('#municipality').html('<option value="">Select</option>');
            $('#barangay').html('<option value="">Select</option>');
        }
    });

    $('#municipality').on('change', function() {
        let regionCode = $('#region').val();
        let provinceCode = $('#province').val();
        let municipalityCode = $(this).val();
        if(regionCode && provinceCode && municipalityCode) {
            loadBarangays(regionCode, provinceCode, municipalityCode);
        } else {
            $('#barangay').html('<option value="">Select</option>');
        }
    }); 
});
</script>
@endif
  
  <!-- Application Form -->
<div class="bg-gray-300 dark:bg-gray-900 min-h-screen py-8 transition-colors duration-300">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 rounded-xl p-6">
        <!-- Form Container -->
        <div class="flex-1 bg-white dark:bg-gray-900 rounded-lg shadow-xl overflow-hidden transition-all duration-300 hover:shadow-lg">  
            <!-- Form Header -->
            <div class="bg-[#101966] dark:bg-blue-800 px-8 py-6 transition-colors duration-300">               
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        <h2 class="text-2xl font-bold text-white">Application Form</h2>
                    </div>
                    <p class="text-blue-100 dark:text-blue-200 transition-colors duration-300 mt-1">
                        Please fill out all required fields accurately!
                    </p>
                </div>

                <!-- Important Notices -->
                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Accuracy Notice -->
                        <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-white mb-1">Information Accuracy</h3>
                                    <p class="text-xs text-blue-100 dark:text-blue-200 leading-relaxed">
                                        All information must be legitimate. False information may result in disapproval.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Notice -->
                        <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-white mb-1">Payment Required</h3>
                                    <p class="text-xs text-blue-100 dark:text-blue-200 leading-relaxed">
                                        Php 50.00 payment via GCash is required after form submission. <br> This is the only accepted method.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Notice -->
                        <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-white mb-1">Privacy Protected</h3>
                                    <p class="text-xs text-blue-100 dark:text-blue-200 leading-relaxed">
                                        Your data is secure and protected <br> by our 
                                        <a href="#" class="underline hover:text-white transition-colors">Privacy Policy</a>
                                        <span>and<br></span>
                                        <a href="#" class="underline hover:text-white transition-colors">Terms & Conditions</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @if($applicant && in_array($applicant->payment_status, ['rejected', 'refunded']))
                
                    <div class="mt-3 p-3 bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 rounded-lg">
                        <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                            <strong>Please check your email<br></strong><br>
                            <strong>Payment Resubmission:</strong> Your previous payment was {{ $applicant->payment_status }}. Please update your payment information and submit again.
                        </p>
                    </div>
                @endif
            </div>
            
            <!-- Form Content -->
            <form class="px-8 py-6 space-y-8" method="POST" action="{{ route('applicant.store') }}" enctype="multipart/form-data" id="applicationForm">
                @csrf
                <!-- Personal Information Section -->
                <div id="personal-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 rounded-full p-3 mr-3 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    Personal Information
                </h3>
    
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">First Name<span class="text-red-500 ml-1">*</span>
                        <input type="text" id="firstName" name="firstName" required 
                            value="{{ auth()->user()->first_name ?? '' }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200" readonly>
                    </div>
                    <div class="col-span-1">
                        <label for="middleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Middle Name
                            @if(empty(auth()->user()->middle_name))
                                <span class="text-red-500 ml-1">*</span>
                            @endif
                        </label>

                        @if(!empty(auth()->user()->middle_name))
                            <input type="text" id="middleName" name="middleName" 
                                value="{{ auth()->user()->middle_name ?? '' }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200" 
                                readonly>
                        @else
                            <input type="text" id="middleName" name="middleName" placeholder="e.g. Reyes" 
                                value="{{ $applicant->middle_name ?? old('middleName') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                {{ empty($applicant->middle_name) ? 'required' : '' }}>
                        @endif
                    </div>
                    <div class="col-span-1">
                        <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Last Name<span class="text-red-500 ml-1">*</span>
                        <input type="text" id="lastName" name="lastName" required 
                            value="{{ auth()->user()->last_name ?? '' }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200" readonly>
                    </div>
                </div>
    
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="col-span-1">
                        <label for="suffix" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Suffix</label>
                        <select id="suffix" name="suffix" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">None</option>
                            <option value="Jr" {{ ($applicant->suffix ?? old('suffix')) == 'Jr' ? 'selected' : '' }}>Jr</option>
                            <option value="Sr" {{ ($applicant->suffix ?? old('suffix')) == 'Sr' ? 'selected' : '' }}>Sr</option>
                            <option value="II" {{ ($applicant->suffix ?? old('suffix')) == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ ($applicant->suffix ?? old('suffix')) == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ ($applicant->suffix ?? old('suffix')) == 'IV' ? 'selected' : '' }}>IV</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Sex<span class="text-red-500 ml-1">*</span>
                        <select id="sex" name="sex" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">Select</option>
                            <option value="Male" {{ ($applicant->sex ?? old('sex')) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ ($applicant->sex ?? old('sex')) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Birthdate<span class="text-red-500 ml-1">*</span>
                        <input 
                            type="date" 
                            name="date" 
                            id="birthdate" 
                            value="{{ auth()->user()->birthdate ? \Carbon\Carbon::parse(auth()->user()->birthdate)->format('Y-m-d') : '' }}" 
                            readonly 
                            required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200">
                    </div>

                 </div>
    
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="col-span-1">
                        <label for="civilStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Civil Status<span class="text-red-500 ml-1">*</span>
                        <select id="civilStatus" name="civilStatus" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">Select</option>
                            <option value="Single" {{ ($applicant->civil_status ?? old('civilStatus')) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ ($applicant->civil_status ?? old('civilStatus')) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ ($applicant->civil_status ?? old('civilStatus')) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ ($applicant->civil_status ?? old('civilStatus')) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>
                    
                    <div class="col-span-1">
                        <label for="bloodType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Blood Type</label>
                        <select id="bloodType" name="bloodType" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">Select</option>
                            <option value="A+" {{ ($applicant->blood_type ?? old('bloodType')) == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ ($applicant->blood_type ?? old('bloodType')) == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ ($applicant->blood_type ?? old('bloodType')) == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ ($applicant->blood_type ?? old('bloodType')) == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ ($applicant->blood_type ?? old('bloodType')) == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ ($applicant->blood_type ?? old('bloodType')) == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ ($applicant->blood_type ?? old('bloodType')) == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ ($applicant->blood_type ?? old('bloodType')) == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                    
                    <div class="col-span-1">
                        <label for="citizenship" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            <div class="inline-block relative mr-2 group">
                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-help" 
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Tooltip -->
                                <div class="invisible group-hover:visible absolute z-10 max-w-xs sm:w-64 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700 -top-2 -translate-y-full left-1/2 -translate-x-1/2 sm:left-1/2 sm:-translate-x-1/2">
                                    You can change this field depending on your actual citizenship.
                                    <div class="tooltip-arrow absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900 dark:border-t-gray-700"></div>
                                </div>
                            </div>
                            Citizenship <span class="text-red-500 ml-1">*</span>
                        </label>

                        <input type="text" id="citizenship" name="citizenship" required 
                            value="{{ $applicant->citizenship ?? old('citizenship', 'Filipino') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200" 
                            placeholder="e.g. Filipino">
                    </div>

                    <div class="col-span-1 md:col-span-3 mt-6">
                        <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <!-- Info Icon with Tooltip -->
                            <div class="inline-block relative mr-2 group">
                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-help" 
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="invisible group-hover:visible absolute z-10 max-w-xs sm:w-64 px-3 py-2 
                                        text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm 
                                        tooltip dark:bg-gray-700 -top-2 -translate-y-full left-1/2 -translate-x-1/2 
                                        whitespace-normal break-words text-center sm:text-left">
                                    Please answer the License information fields below.
                                    <div
                                        class="tooltip-arrow absolute top-full left-1/2 -translate-x-1/2 
                                            border-4 border-transparent border-t-gray-900 
                                            dark:border-t-gray-700 hidden sm:block"></div>
                                </div>
                            </div>
                            Do you have an Amateur Radio License? 
                            <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        </label>

                        <div class="flex items-center justify-between p-4 border rounded-lg cursor-pointer 
                                    transition-all duration-200 
                                    hover:shadow-md hover:border-blue-500 
                                    bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center">
                                <input type="checkbox" id="hasLicense" name="hasLicense" 
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:border-gray-600"
                                    {{ ($applicant->has_license ?? old('hasLicense')) ? 'checked' : '' }}>
                                <label for="hasLicense" class="ml-3 text-base font-semibold text-gray-900 dark:text-gray-100">
                                    I have an Amateur Radio License
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                            <!-- License Information Section (conditionally shown) -->
                <div id="license-info" style="display: none;">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                        <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100 rounded-full p-3 mr-3 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                        License Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="licenseClass" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                                License Class<span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="licenseClass" name="licenseClass" required
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select License Class</option>
                                <option value="Class A" {{ ($applicant->license_class ?? old('licenseClass')) == 'Class A' ? 'selected' : '' }}>Class A</option>
                                <option value="Class B" {{ ($applicant->license_class ?? old('licenseClass')) == 'Class B' ? 'selected' : '' }}>Class B</option>
                                <option value="Class C" {{ ($applicant->license_class ?? old('licenseClass')) == 'Class C' ? 'selected' : '' }}>Class C</option>
                                <option value="Class D" {{ ($applicant->license_class ?? old('licenseClass')) == 'Class D' ? 'selected' : '' }}>Class D</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="licenseNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                                License Number<span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="licenseNumber" name="licenseNumber" 
                                value="{{ $applicant->license_number ?? old('licenseNumber') }}"
                                placeholder="e.g. A01-23-456789" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="callsign" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                                Callsign
                            </label>
                            <input type="text" id="callsign" name="callsign" 
                                value="{{ $applicant->callsign ?? old('callsign') }}"
                                placeholder="e.g. DU1ABC" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                        <div>
                            <label for="expirationDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                                Expiration Date<span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" id="expirationDate" name="expirationDate" 
                                value="{{ isset($applicant) && $applicant->license_expiration_date ? \Carbon\Carbon::parse($applicant->license_expiration_date)->format('Y-m-d') : old('expirationDate') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                    </div>
                </div>


            <!-- Add this new section for is_student -->
            <div class="col-span-1 md:col-span-3 mt-6">
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <!-- Info Icon with Tooltip -->
                    <div class="inline-block relative mr-2 group">
                        <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-help" 
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <!-- Tooltip -->
                        <div
                            class="invisible group-hover:visible absolute z-10 max-w-xs sm:w-64 px-3 py-2 
                                text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm 
                                tooltip dark:bg-gray-700 -top-2 -translate-y-full left-1/2 -translate-x-1/2 
                                whitespace-normal break-words text-center sm:text-left">
                            Please indicate if you are currently a student.
                            <div
                                class="tooltip-arrow absolute top-full left-1/2 -translate-x-1/2 
                                    border-4 border-transparent border-t-gray-900 
                                    dark:border-t-gray-700 hidden sm:block"></div>
                        </div>
                    </div>
                    Are you currently a student?
                    <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                </label>

                <div class="flex items-center justify-between p-4 border rounded-lg cursor-pointer 
                            transition-all duration-200 
                            hover:shadow-md hover:border-blue-500 
                            bg-gray-50 dark:bg-gray-800">
                    <div class="flex items-center">
                        <input type="checkbox" id="isStudent" name="isStudent" 
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:border-gray-600"
                            {{ ($applicant->is_student ?? old('isStudent')) ? 'checked' : '' }}>
                        <label for="isStudent" class="ml-3 text-base font-semibold text-gray-900 dark:text-gray-100">
                            I am currently a student
                        </label>
                    </div>
                </div>
            </div>

            <!-- Student Information Section (conditionally shown) -->
            <div id="student-info" style="display: none;">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                    <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100 rounded-full p-3 mr-3 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6l9-5-9-5-9 5 9 5z" />
                        </svg>
                    </span>
                    Student Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="studentNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Student Number
                            <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        </label>
                        <input type="text" id="studentNumber" name="studentNumber" 
                            value="{{ $applicant->student_number ?? old('studentNumber') }}"
                            placeholder="e.g. 2023-00123" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                    <div>
                        <label for="school" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            School/University
                            <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        </label>
                        <input type="text" id="school" name="school" 
                            value="{{ $applicant->school ?? old('school') }}"
                            placeholder="e.g. University of the Philippines" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="program" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Program/Course
                            <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        </label>
                        <input type="text" id="program" name="program" 
                            value="{{ $applicant->program ?? old('program') }}"
                            placeholder="e.g. Bachelor of Science in Computer Science" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                    <div>
                        <label for="yearLevel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Year Level
                            <span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        </label>
                        <select id="yearLevel" name="yearLevel" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">Select Year Level</option>
                            <option value="1st Year" {{ ($applicant->year_level ?? old('yearLevel')) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                            <option value="2nd Year" {{ ($applicant->year_level ?? old('yearLevel')) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3rd Year" {{ ($applicant->year_level ?? old('yearLevel')) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4th Year" {{ ($applicant->year_level ?? old('yearLevel')) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            <option value="5th Year" {{ ($applicant->year_level ?? old('yearLevel')) == '5th Year' ? 'selected' : '' }}>5th Year</option>
                            <option value="Graduate" {{ ($applicant->year_level ?? old('yearLevel')) == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="Postgraduate" {{ ($applicant->year_level ?? old('yearLevel')) == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                        </select>
                    </div>
                </div>
            </div>

                
            <!-- Contact Information Section -->
            <div id="contact-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                    <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100 rounded-full p-3 mr-3 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </span>
                    Contact Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Email Address<span class="text-red-500 ml-1">*</span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ auth()->user()->email }}" 
                            readonly
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 
                                transition-all duration-200 cursor-not-allowed"
                        >
                        <p id="emailError" class="mt-1 text-sm text-red-500 hidden">
                            Please enter a valid Gmail address.
                        </p>
                    </div>

                    <div>
                        <label for="cellphone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Cellphone No<span class="text-red-500 ml-1">*</span>
                        <input type="tel" id="cellphone" name="cellphone" 
                            value="{{ $applicant->cellphone_no ?? old('cellphone') }}"
                            placeholder="e.g. 09171234567" 
                            maxlength="11"
                            oninput="validatePhoneNumber(this, 'cellphoneError')"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <p id="cellphoneError" class="mt-1 text-sm text-red-500 hidden">
                            Please enter a valid 11-digit cellphone number starting with 09 (e.g., 09171234567).
                        </p>
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Telephone No.<span class="text-gray-500 text-xs ml-1">(Optional)</span>
                        <input type="tel" id="telephone" name="telephone" 
                            value="{{ $applicant->telephone_no ?? old('telephone') }}"
                            placeholder="e.g. 2-XXXX-XXXX" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Section -->
            <div id="emergency-contact" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                    <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100 rounded-full p-3 mr-3 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </span>
                    Emergency Contact
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label for="emergencyName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Full Name<span class="text-red-500 ml-1">* </span><span class="text-gray-500 text-xs">(Last Name, First Name M.I)</span></label>
                            <input type="text" id="emergencyName" name="emergencyName" required 
                                value="{{ $applicant->emergency_contact ?? old('emergencyName') }}"
                                placeholder="e.g. Maria Reyes Cruz" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                oninput="validateFullName(this)">
                            <p id="emergencyNameError" class="mt-1 text-sm text-red-600 hidden">Please enter both first and last name</p>
                        </div>
                        <div class="col-span-1">
                            <label for="emergencyContact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Contact No.<span class="text-red-500 ml-1">*</span>
                            <input type="tel" id="emergencyContact" name="emergencyContact" required 
                                value="{{ $applicant->emergency_contact_number ?? old('emergencyContact') }}"
                                placeholder="e.g. 09171234567" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                maxlength="11"
                                oninput="validatePhoneNumber(this, 'emergencyContactError')">
                            <p id="emergencyContactError" class="mt-1 text-sm text-red-600 hidden">Please enter a valid 11-digit phone number starting with 09 (e.g. 09171234567)</p>
                        </div>
                        <div class="col-span-1">
                            <label for="emergencyRelationship" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Relationship<span class="text-red-500 ml-1">*</span>
                            <select id="emergencyRelationship" name="emergencyRelationship" required
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="" disabled selected>Select relationship</option>
                                <option value="Father" {{ ($applicant->relationship ?? old('emergencyRelationship')) == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ ($applicant->relationship ?? old('emergencyRelationship')) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Spouse" {{ ($applicant->relationship ?? old('emergencyRelationship')) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Others" {{ ($applicant->relationship ?? old('emergencyRelationship')) == 'Others' ? 'selected' : '' }}>Others (please specify)</option>
                            </select>
                            <div id="otherRelationshipContainer" class="mt-2 hidden">
                                <input type="text" id="otherRelationship" name="otherRelationship" placeholder="Please specify relationship"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Address Information Section -->
                <div id="address-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 rounded-full p-3 mr-3 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        Address Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="houseNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">House/Building No./Name<span class="text-red-500 ml-1">*</span>
                            <input type="text" id="houseNumber" name="houseNumber" required 
                                value="{{ $applicant->house_building_number_name ?? old('houseNumber') }}"
                                placeholder="e.g. Blk/Lot" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                        <div>
                            <label for="streetAddress" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Street Address<span class="text-red-500 ml-1">*</span>
                            <input type="text" id="streetAddress" name="streetAddress" required 
                                value="{{ $applicant->street_address ?? old('streetAddress') }}"
                                placeholder="e.g. Acacia St." 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Region<span class="text-red-500 ml-1">*</span>
                            <select id="region" name="region" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->PSGC_REG_CODE }}" 
                                        {{ (isset($applicant) && $applicant->region == $region->PSGC_REG_CODE) ? 'selected' : '' }}>
                                        {{ $region->PSGC_REG_DESC }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Province<span class="text-red-500 ml-1">*</span>
                            <select id="province" name="province" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select</option>
                                <!-- Provinces loaded dynamically via AJAX -->
                                @if(isset($province) && $province)
                                    <option value="{{ $province->PSGC_PROV_CODE }}" selected>{{ $province->PSGC_PROV_DESC }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="municipality" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Municipality<span class="text-red-500 ml-1">*</span>
                            <select id="municipality" name="municipality" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select</option>
                                <!-- Municipalities loaded dynamically via AJAX -->
                                @if(isset($municipality) && $municipality)
                                    <option value="{{ $municipality->PSGC_MUNC_CODE }}" selected>{{ $municipality->PSGC_MUNC_DESC }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="barangay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Barangay<span class="text-red-500 ml-1">*</span>
                            <select id="barangay" name="barangay" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select</option>
                                <!-- Barangays loaded dynamically via AJAX -->
                                @if(isset($barangay) && $barangay)
                                    <option value="{{ $barangay->PSGC_BRGY_CODE }}" selected>{{ $barangay->PSGC_BRGY_DESC }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4 w-full md:w-1/4">
                        <label for="zipCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Zip Code<span class="text-red-500 ml-1">*</span>
                        <input type="text" id="zipCode" name="zipCode" required 
                            value="{{ $applicant->zip_code ?? old('zipCode') }}"    
                            placeholder="0000" 
                            maxlength="4"
                            oninput="validateZipCode(this)"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <p id="zipCodeError" class="mt-1 text-sm text-red-500 hidden">Zip code must be exactly 4 digits.</p>
                    </div>
                </div>
                
                
                
            </form> 
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 px-8 pb-6">
                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 text-sm font-medium bg-red-600 dark:bg-red-700 text-white border border-red-600 dark:border-red-700 rounded-lg 
                            hover:bg-white hover:text-red-600 hover:border-red-600 dark:hover:bg-gray-900 dark:hover:text-red-400 
                            transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cancel Application
                        </button>
                    </form>

                    <!-- Proceed to Payment Button -->
                    <button type="button" id="proceedToPaymentBtn" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 text-sm font-medium bg-[#101966] dark:bg-[#101966] text-white border border-[#101966] dark:border-[#101966] rounded-lg 
                    hover:bg-white hover:text-[#101966] hover:border-[#101966] dark:hover:bg-gray-900 dark:hover:text-gray-200 
                    transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                        Proceed to Payment
                    </button>
                </div>       
            </div>
        </div>
    </div>





<!-- Payment Overlay -->
<div id="paymentOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-xs sm:max-w-md md:max-w-2xl lg:max-w-4xl max-h-[90vh] sm:max-h-screen overflow-y-auto relative my-4 sm:my-0">
        <button id="closePaymentOverlay" class="absolute top-3 right-3 z-10 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 bg-white dark:bg-gray-800 rounded-full p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <div class="p-4 sm:p-6 lg:p-8">
            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-[#132080] dark:text-white mb-4 sm:mb-6 pr-8">Payment Information</h2>
            

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                <!-- Payment Details Section -->
                <div class="order-1 lg:order-1">
                    <div id="paymentMethodDetails" class="hidden">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 sm:mb-4 flex items-center gap-2">
                            <span id="selectedMethodName"></span>
                            <div class="relative inline-block group">
                                <svg class="w-4 h-4 text-blue-500 hover:text-blue-700 cursor-help transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <!-- Tooltip -->
                                <div class="invisible group-hover:visible absolute z-10 w-48 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700 -top-2 -translate-y-full left-1/2 -translate-x-1/2">
                                    This transaction is refundable
                                    <div class="tooltip-arrow absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900 dark:border-t-gray-700"></div>
                                </div>
                            </div>
                        </h3>
                        
                        <!-- QR Code Image -->
                        <div class="mb-3 sm:mb-4" id="qrCodeContainer">
                            <img id="qrCodeImage" src="" alt="QR Code" class="w-full max-w-xs mx-auto sm:max-w-none sm:mx-0 h-auto rounded-lg border border-gray-200 dark:border-gray-700 hidden">
                            <div id="noQrCode" class="text-center py-8 text-gray-500 dark:text-gray-400 hidden">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm">No QR code available</p>
                            </div>
                        </div>
                        
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-3 sm:mb-4">
                            Please scan the QR code or send payment to:
                        </p>

                        <!-- Total Amount Due -->
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-3 sm:p-4 rounded-lg mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold text-green-800 dark:text-green-200">Total Amount Due:</span>
                                </div>
                                <span id="totalAmountDue" class="text-lg sm:text-xl font-bold text-green-800 dark:text-green-200">₱0.00</span>
                            </div>
                        </div>
                        
                        <!-- Payment Details -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-3 sm:p-4 rounded-lg mb-4">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm sm:text-base text-blue-800 dark:text-blue-200 mb-1">
                                        <span class="font-semibold">Account Name:</span> 
                                        <span id="displayAccountName">-</span>
                                    </p>
                                    <p class="text-sm sm:text-base text-blue-800 dark:text-blue-200 mb-1">
                                        <span class="font-semibold">Account Number:</span> 
                                        <span id="displayAccountNumber">-</span>
                                    </p>
                                    <p class="text-sm sm:text-base text-blue-800 dark:text-blue-200">
                                        <span class="font-semibold">Amount:</span> 
                                        <span id="displayAmount">-</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- No Payment Method Selected -->
                    <div id="noPaymentSelected" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        <p class="text-lg font-medium mb-2">Select a Payment Method</p>
                        <p class="text-sm">Please choose a payment method to view payment details</p>
                    </div>
                </div>
                
                <!-- Payment Form Section -->
                <div class="order-2 lg:order-2">
                    <form id="paymentForm">
                        <!-- Hidden field to store selected payment method -->
                        <input type="hidden" id="selectedPaymentMethodId" name="selected_payment_method_id">
                        
                        <div class="mb-4 sm:mb-6">

                        <label for="paymentMethodSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Select Payment Method <span class="text-red-500">*</span>
                        </label>
                        <select id="paymentMethodSelect" 
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="">Choose a payment method...</option>
                            @foreach($paymentMethods->where('category', 'application') as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}" 
                                        data-account-name="{{ $paymentMethod->account_name }}"
                                        data-account-number="{{ $paymentMethod->account_number }}"
                                        data-amount="{{ $paymentMethod->amount }}"
                                        data-qr-image="{{ $paymentMethod->mode_of_payment_qr_image ? asset('images/' . $paymentMethod->mode_of_payment_qr_image) : '' }}"
                                        data-method-name="{{ $paymentMethod->mode_of_payment_name }}">
                                    {{ $paymentMethod->mode_of_payment_name }} 
                                    @if($paymentMethod->amount)
                                        - ₱{{ number_format($paymentMethod->amount, 2) }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                            <label for="gcashRefNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Reference Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="gcashRefNumber" name="gcashRefNumber" required 
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                placeholder="e.g. 1234 567 123456"
                                maxlength="15"
                                oninput="formatGcashRefNumber(this)"
                                onkeypress="return isNumberKey(event)">
                            <p id="gcashRefError" class="mt-1 text-xs sm:text-sm text-red-500 hidden">
                                Please enter a valid 13-digit reference number (e.g., 1234 567 123456)
                            </p>
                        </div>
                        
                        <div class="mb-4 sm:mb-6">
                            <label for="paymentProof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Upload Payment Proof <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 sm:p-4 text-center payment-proof-container relative">
                                <input type="file" id="paymentProof" name="paymentProof" accept="image/*" class="hidden">
                                <label for="paymentProof" class="cursor-pointer block">
                                    <div id="uploadContent">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 sm:h-10 sm:w-10 lg:h-12 lg:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14z" />
                                        </svg>
                                        <p class="mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">Click to upload payment screenshot</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 5MB</p>
                                    </div>
                                    <div id="imagePreviewContainer" class="hidden">
                                        <img id="imagePreview" class="max-w-full h-32 sm:h-40 lg:h-48 rounded-lg border border-gray-200 dark:border-gray-700 mx-auto" title="Click to reupload">
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 sm:px-6 sm:py-3 text-sm font-medium bg-[#101966] text-white border border-[#101966] rounded-lg 
                            hover:bg-white hover:text-blue-600 hover:border-blue-600 dark:hover:bg-gray-900 dark:hover:text-gray-200 
                            transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            id="submitButton" disabled>
                            Submit Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Data Privacy Consent Modal -->
<div id="consentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Data Privacy Consent
                </h3>
                <button type="button" id="closeConsentModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Before submitting your application, please read and acknowledge our Data Privacy Policy.
                </p>
                
                <div class="flex items-start space-x-3">
                    <input 
                        type="checkbox" 
                        id="dataPrivacyConsent" 
                        name="dataPrivacyConsent"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-1"
                    >
                    <label for="dataPrivacyConsent" class="text-sm text-gray-700 dark:text-gray-300">
                        I have read and understood the 
                        <a href="{{ route('data.privacy') }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                            Privacy Policy
                        </a> 
                        and I consent to the collection and processing of my personal data in accordance with the Data Privacy Act of 2012.
                    </label>
                </div>
                <p id="consentError" class="mt-2 text-sm text-red-600 hidden">You must accept the Data Privacy Policy to continue.</p>
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelConsent" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirmConsent" class="px-4 py-2 text-sm font-medium text-white bg-[#101966] rounded-lg hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                    Confirm & Submit
                </button>
            </div>
        </div>
    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Payment Method Selection Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            const paymentMethodDetails = document.getElementById('paymentMethodDetails');
            const noPaymentSelected = document.getElementById('noPaymentSelected');
            const selectedMethodName = document.getElementById('selectedMethodName');
            const qrCodeImage = document.getElementById('qrCodeImage');
            const noQrCode = document.getElementById('noQrCode');
            const displayAccountName = document.getElementById('displayAccountName');
            const displayAccountNumber = document.getElementById('displayAccountNumber');
            const displayAmount = document.getElementById('displayAmount');
            const selectedPaymentMethodId = document.getElementById('selectedPaymentMethodId');
            const submitButton = document.getElementById('submitButton');

            // Handle payment method selection
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    
                    if (selectedOption.value) {
                        // Show payment method details and hide no selection message
                        paymentMethodDetails.classList.remove('hidden');
                        noPaymentSelected.classList.add('hidden');
                        
                        // Update displayed information
                        selectedMethodName.textContent = selectedOption.getAttribute('data-method-name');
                        displayAccountName.textContent = selectedOption.getAttribute('data-account-name') || '-';
                        displayAccountNumber.textContent = selectedOption.getAttribute('data-account-number') || '-';
                        
                        const amount = selectedOption.getAttribute('data-amount');
                        displayAmount.textContent = amount ? '₱' + parseFloat(amount).toFixed(2) : '-';

                        // Inside the paymentMethodSelect change event, after setting displayAmount
                        document.getElementById('totalAmountDue').textContent = amount ? '₱' + parseFloat(amount).toFixed(2) : '₱0.00';
                        
                        // Update hidden field
                        selectedPaymentMethodId.value = selectedOption.value;
                        
                        // Enable submit button
                        submitButton.disabled = false;
                        
                        // Handle QR code image
                        const qrImageUrl = selectedOption.getAttribute('data-qr-image');
                        if (qrImageUrl && qrImageUrl !== '') {
                            qrCodeImage.src = qrImageUrl;
                            qrCodeImage.classList.remove('hidden');
                            noQrCode.classList.add('hidden');
                        } else {
                            qrCodeImage.classList.add('hidden');
                            noQrCode.classList.remove('hidden');
                        }
                    } else {
                        // Hide payment method details and show no selection message
                        paymentMethodDetails.classList.add('hidden');
                        noPaymentSelected.classList.remove('hidden');
                        
                        // Disable submit button
                        submitButton.disabled = true;
                        
                        // Clear hidden field
                        selectedPaymentMethodId.value = '';
                    }
                });
            }

            // Form validation for payment method selection
            const form = document.getElementById('paymentForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!paymentMethodSelect.value) {
                        e.preventDefault();
                        alert('Please select a payment method before submitting your application.');
                        paymentMethodSelect.focus();
                        return false;
                    }
                    
                    // Additional validation can be added here
                    const refNumber = document.getElementById('gcashRefNumber').value;
                    const accountNumber = document.getElementById('gcashAccountNumber').value;
                    
                    if (!refNumber || refNumber.replace(/\s/g, '').length !== 13) {
                        e.preventDefault();
                        alert('Please enter a valid 13-digit reference number.');
                        document.getElementById('gcashRefNumber').focus();
                        return false;
                    }
                    
                    if (!accountNumber || !/^09[0-9]{9}$/.test(accountNumber)) {
                        e.preventDefault();
                        alert('Please enter a valid 11-digit account number starting with 09.');
                        document.getElementById('gcashAccountNumber').focus();
                        return false;
                    }
                });
            }

            // Close overlay functionality
            const closePaymentOverlay = document.getElementById('closePaymentOverlay');
            const paymentOverlay = document.getElementById('paymentOverlay');
            
            if (closePaymentOverlay && paymentOverlay) {
                closePaymentOverlay.addEventListener('click', function() {
                    paymentOverlay.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                
                // Close when clicking outside the content
                paymentOverlay.addEventListener('click', function(e) {
                    if (e.target === paymentOverlay) {
                        paymentOverlay.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
        });

        $('#applicationForm').on('submit', function(e) {
        // Handle hasLicense checkbox value
        const hasLicenseCheckbox = document.getElementById('hasLicense');
        if (hasLicenseCheckbox.checked) {
            // Create a hidden input with value "on"
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'hasLicense';
            hiddenInput.value = 'on';
            this.appendChild(hiddenInput);
        } else {
            // Create a hidden input with value "0"
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'hasLicense';
            hiddenInput.value = '0';
            this.appendChild(hiddenInput);
        }
        
        // Your existing code for relationship handling
        var relSelect = document.getElementById('emergencyRelationship');
        if (relSelect.value === 'Others') {
            var otherInput = document.getElementById('otherRelationship');
            if (otherInput && otherInput.value.trim() !== '') {
                relSelect.value = otherInput.value.trim();
            }
        }
        
        // Zip Code validation
        const zipInput = document.getElementById('zipCode');
        if (!validateZipCode(zipInput)) {
            zipInput.scrollIntoView({behavior: 'smooth', block: 'center'});
            zipInput.focus();
            e.preventDefault();
        }
    });

    $(document).ready(function() {
        // On form submit, if relationship is 'Others', set select value to custom input
        $('#applicationForm').on('submit', function(e) {
            var relSelect = document.getElementById('emergencyRelationship');
            if (relSelect.value === 'Others') {
                var otherInput = document.getElementById('otherRelationship');
                if (otherInput && otherInput.value.trim() !== '') {
                    relSelect.value = otherInput.value.trim();
                }
            }
        });
        // Zip Code validation on form submit
        $('#applicationForm').on('submit', function(e) {
            const zipInput = document.getElementById('zipCode');
            if (!validateZipCode(zipInput)) {
                zipInput.scrollIntoView({behavior: 'smooth', block: 'center'});
                zipInput.focus();
                e.preventDefault();
            }
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

        // Payment overlay functionality
        const proceedToPaymentBtn = document.getElementById('proceedToPaymentBtn');
        const paymentOverlay = document.getElementById('paymentOverlay');
        const closePaymentOverlay = document.getElementById('closePaymentOverlay');
        const applicationForm = document.getElementById('applicationForm');
        const paymentForm = document.getElementById('paymentForm');

        proceedToPaymentBtn.addEventListener('click', function() {
            // Validate all visible required fields in the form
            let firstInvalidField = null;
            let isValid = true;

            // Validate custom fields first
            const emailValid = validateEmail(document.getElementById('email'));
            const cellphoneValid = validatePhoneNumber(document.getElementById('cellphone'), 'cellphoneError');
            const nameValid = validateFullName(document.getElementById('emergencyName'));
            const emergencyContactValid = validatePhoneNumber(document.getElementById('emergencyContact'), 'emergencyContactError');
            const zipValid = validateZipCode(document.getElementById('zipCode'));

            if (!emailValid && !firstInvalidField) firstInvalidField = document.getElementById('email');
            if (!cellphoneValid && !firstInvalidField) firstInvalidField = document.getElementById('cellphone');
            if (!nameValid && !firstInvalidField) firstInvalidField = document.getElementById('emergencyName');
            if (!emergencyContactValid && !firstInvalidField) firstInvalidField = document.getElementById('emergencyContact');
            if (!zipValid && !firstInvalidField) firstInvalidField = document.getElementById('zipCode');

            isValid = emailValid && cellphoneValid && nameValid && emergencyContactValid && zipValid;

            // FIXED: Only validate license fields if license section is visible
            const licenseSection = document.getElementById('license-info');
            if (licenseSection.style.display !== 'none') {
                const licenseClass = document.getElementById('licenseClass');
                const licenseNumber = document.getElementById('licenseNumber');
                const expirationDate = document.getElementById('expirationDate');
                
                if (!licenseClass.value) {
                    licenseClass.classList.add('border-red-500');
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = licenseClass;
                }
                
                if (!licenseNumber.value) {
                    licenseNumber.classList.add('border-red-500');
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = licenseNumber;
                }
                
                if (!expirationDate.value) {
                    expirationDate.classList.add('border-red-500');
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = expirationDate;
                }
            }

            // Validate all other required fields (text, select, date, etc.)
            $(applicationForm).find('input[required]:visible, select[required]:visible, textarea[required]:visible').each(function() {
                // Skip fields already validated above
                if (["email","cellphone","emergencyName","emergencyContact","zipCode"].includes(this.id)) return;
                // For license fields, skip if license section is hidden
                if ((this.id === 'licenseClass' || this.id === 'licenseNumber' || this.id === 'expirationDate') && licenseSection.style.display === 'none') return;
                // For otherRelationship, skip if not visible
                if (this.id === 'otherRelationship' && $('#otherRelationshipContainer').hasClass('hidden')) return;
                // If empty or invalid
                if (!this.value || (this.type === 'checkbox' && !this.checked)) {
                    $(this).addClass('border-red-500');
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = this;
                } else {
                    $(this).removeClass('border-red-500');
                }
            });

            if (!isValid) {
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField.focus();
                }
                return;
            }

            // Check if user is a student
            const isStudent = document.getElementById('isStudent').checked;
            
            if (isStudent) {
                // If student, skip payment and go directly to data privacy modal
                paymentFormData = new FormData();
                consentModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                // If not student, show payment overlay as normal
                paymentOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });

        closePaymentOverlay.addEventListener('click', function() {
            paymentOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Consent Modal Functionality
        const consentModal = document.getElementById('consentModal');
        const closeConsentModal = document.getElementById('closeConsentModal');
        const cancelConsent = document.getElementById('cancelConsent');
        const confirmConsent = document.getElementById('confirmConsent');
        const dataPrivacyConsent = document.getElementById('dataPrivacyConsent');
        const consentError = document.getElementById('consentError');

        let paymentFormData = null;

        // Modify the payment form submission to show consent modal first
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Store the form data
            paymentFormData = new FormData(this);
            
            // Close payment overlay first
            paymentOverlay.classList.add('hidden');
            
            // Then show consent modal
            setTimeout(() => {
                consentModal.classList.remove('hidden');
            }, 300);
        });

        // Close modal handlers
        [closeConsentModal, cancelConsent].forEach(button => {
            button.addEventListener('click', function() {
                consentModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                paymentFormData = null;
                
                // Only reopen payment overlay if user is NOT a student
                const isStudent = document.getElementById('isStudent').checked;
                if (!isStudent) {
                    setTimeout(() => {
                        paymentOverlay.classList.remove('hidden');
                    }, 100);
                }
            });
        });


        // Close consent modal when clicking outside
        consentModal.addEventListener('click', function(e) {
            if (e.target === consentModal) {
                consentModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                paymentFormData = null;
                
                // Only reopen payment overlay if user is NOT a student
                const isStudent = document.getElementById('isStudent').checked;
                if (!isStudent) {
                    setTimeout(() => {
                        paymentOverlay.classList.remove('hidden');
                    }, 100);
                }
            }
        });




        // Confirm consent and submit
        confirmConsent.addEventListener('click', function() {
            if (!dataPrivacyConsent.checked) {
                consentError.classList.remove('hidden');
                dataPrivacyConsent.focus();
                return;
            }
            
            consentError.classList.add('hidden');
            
            // Close modal
            consentModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Show loading state
            Swal.fire({
                title: 'Submitting Application',
                text: 'Please wait while we process your application...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Combine application form data with payment form data and consent
            const applicationFormData = new FormData(document.getElementById('applicationForm'));
            
            // Check if user is a student
            const isStudent = document.getElementById('isStudent').checked;
            
            if (isStudent) {
                // For students, add empty payment data or student-specific payment status
                applicationFormData.append('isStudent', 'on');
                applicationFormData.append('payment_status', 'waived'); // Or 'student'
                applicationFormData.append('reference_number', 'STUDENT_WAIVED');
            } else {
                // For non-students, append payment data normally
                if (paymentFormData) {
                    for (let [key, value] of paymentFormData.entries()) {
                        applicationFormData.append(key, value);
                    }
                }
            }
            
            // Append the consent
            applicationFormData.append('dataPrivacyConsent', dataPrivacyConsent.checked ? '1' : '0');
            
            // Submit the combined form data
            fetch(document.getElementById('applicationForm').action, {
                method: 'POST',
                body: applicationFormData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                
                // Clone the response to read it multiple times
                return response.clone().json().then(data => {
                    console.log('Response data:', data);
                    return { status: response.status, data };
                }).catch(error => {
                    console.error('Error parsing JSON:', error);
                    return response.text().then(text => {
                        console.log('Response text:', text);
                        return { status: response.status, text };
                    });
                });
            })
            .then(result => {
                let firstErrorField = null;
                
                if (result.status === 422) {
                    console.log('Validation errors:', result.data);
            
                    let errorMessage = 'Please fix the following errors:';
                    if (result.data && result.data.errors) {
                        for (const field in result.data.errors) {
                            errorMessage += `\n• ${result.data.errors[field][0]}`;
                            
                            // Highlight the problematic field
                            const fieldElement = document.querySelector(`[name="${field}"]`);
                            if (fieldElement) {
                                fieldElement.classList.add('border-red-500');
                                // Scroll to the first error field
                                if (!firstErrorField) {
                                    firstErrorField = fieldElement;
                                    fieldElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    fieldElement.focus();
                                }
                            }
                        }
                    } else {
                        errorMessage += '\n• Unknown validation error';
                    }
                    
                    Swal.fire('Validation Error', errorMessage, 'error');
                } else if (result.data && result.data.redirect) {
                    window.location.href = result.data.redirect;
                } else if (result.data && result.data.error) {
                    Swal.fire('Error', result.data.error, 'error');
                } else {
                    Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while submitting your application. Please try again.', 'error');
            })
            .finally(() => {
                Swal.close();
                paymentFormData = null;
            });
        });

        // Close modal when clicking outside
        consentModal.addEventListener('click', function(e) {
            if (e.target === consentModal) {
                consentModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                paymentFormData = null;
            }
        });

        document.getElementById('paymentProof').onchange = function() {
            previewImage(this);
            validatePaymentProof(this);
        };

        // Image preview functionality
        window.previewImage = function(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    });

    // Show/hide license section based on checkbox
    document.getElementById('hasLicense').addEventListener('change', function() {
        const licenseSection = document.getElementById('license-info');
        if (this.checked) {
            licenseSection.style.display = 'block';
            // Make license fields required
            document.getElementById('licenseClass').required = true;
            document.getElementById('licenseNumber').required = true;
            document.getElementById('callsign').required = true;
            document.getElementById('expirationDate').required = true;
        } else {
            licenseSection.style.display = 'none';
            // Remove required attributes
            document.getElementById('licenseClass').required = false;
            document.getElementById('licenseNumber').required = false;
            document.getElementById('callsign').required = false;
            document.getElementById('expirationDate').required = false;
            // Clear license fields when hidden
            document.getElementById('licenseClass').value = '';
            document.getElementById('licenseNumber').value = '';
            document.getElementById('callsign').value = '';
            document.getElementById('expirationDate').value = '';

        }
    });

    // Validate email (must be Gmail)
    function validateEmail(input) {
        const errorElement = document.getElementById('emailError');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        
        if (!emailRegex.test(input.value)) {
            input.classList.add('border-red-500');
            errorElement.classList.remove('hidden');
            return false;
        } else {
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    // Validate full name (at least first name and last name)
    function validateFullName(input) {
        const errorElement = document.getElementById('emergencyNameError');
        const nameParts = input.value.trim().split(/\s+/);
        
        if (nameParts.length < 2) {
            input.classList.add('border-red-500');
            errorElement.classList.remove('hidden');
            return false;
        } else {
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    // Validate phone number (only digits, 11 characters)
    function validatePhoneNumber(input, errorId) {
        const errorElement = document.getElementById(errorId);
        // Remove all non-digit characters
        input.value = input.value.replace(/\D/g, '');
        
        if (input.value.length !== 11 || !input.value.startsWith('09')) {
            input.classList.add('border-red-500');
            errorElement.classList.remove('hidden');
            return false;
        } else {
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    // Validate GCash Account Number (11 digits, starts with 09)
    function validateGcashNumber(input) {
        const errorElement = document.getElementById('gcashAccountNumberError');
        input.value = input.value.replace(/\D/g, '');
        if (input.value.length !== 11 || !input.value.startsWith('09')) {
            input.classList.add('border-red-500');
            errorElement.classList.remove('hidden');
            return false;
        } else {
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    // Validate Zip Code (exactly 4 digits)
    function validateZipCode(input) {
        const errorElement = document.getElementById('zipCodeError');
        // Remove all non-digit characters
        input.value = input.value.replace(/\D/g, '');
        if (input.value.length !== 4) {
            input.classList.add('border-red-500');
            errorElement.classList.remove('hidden');
            return false;
        } else {
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    // Other relationship field handling
    document.getElementById('emergencyRelationship').addEventListener('change', function() {
        const otherContainer = document.getElementById('otherRelationshipContainer');
        if (this.value === 'Others') {
            otherContainer.classList.remove('hidden');
            document.getElementById('otherRelationship').setAttribute('required', 'required');
        } else {
            otherContainer.classList.add('hidden');
            document.getElementById('otherRelationship').removeAttribute('required');
        }
    });

    // Format GCash reference number with spaces (1234 567 123456)
    function formatGcashRefNumber(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Limit to 13 digits only
        value = value.substring(0, 13);
        
        // Format with spaces after 4 digits and then after 3 more digits
        if (value.length > 4) {
            value = value.substring(0, 4) + ' ' + value.substring(4);
        }
        if (value.length > 8) {
            value = value.substring(0, 8) + ' ' + value.substring(8);
        }
        
        input.value = value;
        
        // Validate the reference number
        validateGcashRefNumber(input);
    }

    // Validate GCash reference number (exactly 13 digits)
    function validateGcashRefNumber(input) {
        const errorElement = document.getElementById('gcashRefError');
        // Remove spaces to count only digits
        const digitsOnly = input.value.replace(/\s/g, '');
        
        if (digitsOnly.length === 0) {
            errorElement.classList.add('hidden');
            input.classList.remove('border-red-500');
            return false;
        }
        
        const isValid = digitsOnly.length === 13;
        
        if (!isValid) {
            errorElement.classList.remove('hidden');
            input.classList.add('border-red-500');
            return false;
        } else {
            errorElement.classList.add('hidden');
            input.classList.remove('border-red-500');
            return true;
        }
    }

    // Allow only numbers to be entered
    function isNumberKey(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
            return false;
        }
        return true;
    }

    // Add validation to payment form submission
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const gcashRefInput = document.getElementById('gcashRefNumber');
        const isValid = validateGcashRefNumber(gcashRefInput);
        
        if (!isValid) {
            e.preventDefault();
            gcashRefInput.focus();
        }
    });

    // Also add validation when the overlay is opened
    document.getElementById('proceedToPaymentBtn').addEventListener('click', function() {
        // Your existing validation code...
        
        // After showing overlay, focus on GCash reference input
        setTimeout(() => {
            document.getElementById('gcashRefNumber').focus();
        }, 100);
    });

    function validatePaymentProof(input) {
        // Remove any existing error
        const existingError = input.parentNode.parentNode.querySelector('.payment-proof-error');
        if (existingError) {
            existingError.remove();
        }
        
        if (!input.files || !input.files[0]) {
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mt-2 p-2 bg-red-100 text-red-700 rounded payment-proof-error';
            errorDiv.textContent = 'Please upload payment proof.';
            input.parentNode.parentNode.appendChild(errorDiv);
            
            // Make the border red to indicate error
            input.parentNode.parentNode.classList.add('border-red-500');
            
            return false;
        }
        
        // Check file type
        const file = input.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mt-2 p-2 bg-red-100 text-red-700 rounded payment-proof-error';
            errorDiv.textContent = 'Please upload a valid image (JPEG, PNG, JPG).';
            input.parentNode.parentNode.appendChild(errorDiv);
            
            // Make the border red to indicate error
            input.parentNode.parentNode.classList.add('border-red-500');
            
            return false;
        }
        
        // Check file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mt-2 p-2 bg-red-100 text-red-700 rounded payment-proof-error';
            errorDiv.textContent = 'File size must be less than 5MB.';
            input.parentNode.parentNode.appendChild(errorDiv);
            
            // Make the border red to indicate error
            input.parentNode.parentNode.classList.add('border-red-500');
            
            return false;
        }
        
        // Remove error styling if valid
        input.parentNode.parentNode.classList.remove('border-red-500');
        
        return true;
    }

    // Show/hide student section based on checkbox
    document.getElementById('isStudent').addEventListener('change', function() {
        const studentSection = document.getElementById('student-info');
        if (this.checked) {
            studentSection.style.display = 'block';
        } else {
            studentSection.style.display = 'none';
            // Clear student fields when hidden
            document.getElementById('studentNumber').value = '';
            document.getElementById('school').value = '';
            document.getElementById('program').value = '';
            document.getElementById('yearLevel').value = '';
        }

        const proceedButton = document.getElementById('proceedToPaymentBtn');
        if (this.checked) {
            proceedButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                Proceed to Submit
            `;
        } else {
            proceedButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                Proceed to Payment
            `;
        }

    });

    // Also handle on page load for existing applicants
    document.addEventListener('DOMContentLoaded', function() {
        const isStudentCheckbox = document.getElementById('isStudent');
        const studentSection = document.getElementById('student-info');
        
        // Show student section if applicant is a student or checkbox is checked
        if ({{ $applicant->is_student ?? 'false' }} || isStudentCheckbox.checked) {
            studentSection.style.display = 'block';
        }
    });

    // Initialize total amount display
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('totalAmountDue').textContent = '₱0.00';
    });
    </script>
</x-app-layout>