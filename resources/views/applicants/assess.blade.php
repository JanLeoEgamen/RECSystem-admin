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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($applicant->payment_status !== 'verified')
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Payment Not Verified</p>
                            <p>You cannot approve this applicant until their payment status is verified.</p>
                        </div>
                    @endif
                    @if($applicant->payment_status === 'verified')
                        <div id="applicant-payment_status" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Payment Verified</p>
                            <p>This applicant has successfully completed their payment.</p>
                        </div>
                    @endif

                    <form action="{{ route('applicants.approve', $applicant->id) }}" method="post" id="approvalForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium">First Name *</label>
                                        <input value="{{ old('first_name', $applicant->first_name) }}" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('first_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="middle_name" class="block text-sm font-medium">Middle Name</label>
                                        <input value="{{ old('middle_name', $applicant->middle_name) }}" name="middle_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('middle_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium">Last Name *</label>
                                        <input value="{{ old('last_name', $applicant->last_name) }}" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('last_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="suffix" class="block text-sm font-medium">Suffix</label>
                                        <input value="{{ old('suffix', $applicant->suffix) }}" name="suffix" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('suffix')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="sex" class="block text-sm font-medium">Sex *</label>
                                        <select name="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly disabled>
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
                                        <input value="{{ old('birthdate', $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('Y-m-d') : '') }}" name="birthdate" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('birthdate')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="civil_status" class="block text-sm font-medium">Civil Status *</label>
                                        <select name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly disabled>
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
                                        <input value="{{ old('citizenship', $applicant->citizenship) }}" name="citizenship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('citizenship')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="blood_type" class="block text-sm font-medium">Blood Type</label>
                                        <select name="blood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly disabled>
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
                                        <input value="{{ old('cellphone_no', $applicant->cellphone_no) }}" name="cellphone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('cellphone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone_no" class="block text-sm font-medium">Telephone No.</label>
                                        <input value="{{ old('telephone_no', $applicant->telephone_no) }}" name="telephone_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('telephone_no')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email_address" class="block text-sm font-medium">Email Address *</label>
                                        <input value="{{ old('email_address', $applicant->email_address) }}" name="email_address" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
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
                                        <input value="{{ old('emergency_contact', $applicant->emergency_contact) }}" name="emergency_contact" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('emergency_contact')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="emergency_contact_number" class="block text-sm font-medium">Contact No. *</label>
                                        <input value="{{ old('emergency_contact_number', $applicant->emergency_contact_number) }}" name="emergency_contact_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('emergency_contact_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="relationship" class="block text-sm font-medium">Relationship *</label>
                                        <input value="{{ old('relationship', $applicant->relationship) }}" name="relationship" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('relationship')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- License Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">License Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                        <input value="{{ old('house_building_number_name', $applicant->house_building_number_name) }}" name="house_building_number_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('house_building_number_name')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="street_address" class="block text-sm font-medium">Street Address *</label>
                                        <input value="{{ old('street_address', $applicant->street_address) }}" name="street_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('street_address')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <label for="region" class="block text-sm font-medium">Region *</label>
                                        <input value="{{ old('region', $regionName) }}" name="region" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('region')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="province" class="block text-sm font-medium">Province *</label>
                                        <input value="{{ old('province', $provinceName) }}" name="province" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('province')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="municipality" class="block text-sm font-medium">Municipality *</label>
                                        <input value="{{ old('municipality',  $municipalityName) }}" name="municipality" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('municipality')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="barangay" class="block text-sm font-medium">Barangay *</label>
                                        <input value="{{ old('barangay', $barangayName) }}" name="barangay" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('barangay')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="zip_code" class="block text-sm font-medium">Zip Code *</label>
                                    <input value="{{ old('zip_code', $applicant->zip_code) }}" name="zip_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                    @error('zip_code')
                                    <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Membership Information -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold mb-4">Membership Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="rec_number" class="block text-sm font-medium">REC Number *</label>
                                        <input value="{{ old('rec_number') }}" name="rec_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('rec_number')
                                        <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="membership_type_id" class="block text-sm font-medium">Membership Type *</label>
                                        <select name="membership_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                        <input value="{{ old('membership_start', \Carbon\Carbon::now()->format('Y-m-d')) }}" name="membership_start" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
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
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <!-- Approve Button -->
                            <button type="button" id="approveButton"
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                  bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                  dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200"
                                @if($applicant->payment_status !== 'verified') disabled @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Approve & Create Member
                            </button>

                            <!-- Reject Button -->
                            <button type="button" id="rejectButton" 
                                class="inline-flex items-center px-5 py-2 text-white hover:text-red-600 hover:border-red-600 
                                  bg-red-600 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-red-600 border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                  dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject Applicant
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
            <p class="text-gray-900 dark:text-gray-100 text-lg">Processing request...</p>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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