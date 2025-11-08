<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Edit User
            </h2>

            <a href="{{ route('users.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium
                        rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto mt-4 md:mt-0 text-center

                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                Back to Users
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <!-- Page Header with Icon -->
                    <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update user roles and bureau/section assignments</p>
                            </div>
                        </div>
                    </div>

                    <form id="updateForm" action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf

                        <!-- Personal Information Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Personal Information</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    First Name
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $user->first_name }}
                                </div>
                                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Last Name
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $user->last_name }}
                                </div>
                                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Birthdate
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : 'N/A' }}
                                </div>
                                <input type="hidden" name="birthdate" value="{{ $user->birthdate ? (\Carbon\Carbon::parse($user->birthdate)->format('Y-m-d')) : '' }}">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Email
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $user->email }}
                                </div>
                                <input type="hidden" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assign Roles Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Assign Roles</h4>
                        </div>

                        @if ($roles->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($roles as $role)
                                    <div class="relative">
                                        <input id="role-{{ $role->id }}" name="role" type="radio" value="{{ $role->name }}" {{ $hasRoles->contains($role->id) ? 'checked' : '' }} class="peer sr-only role-radio">
                                        <label for="role-{{ $role->id }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-amber-50 dark:hover:bg-gray-600 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/30 peer-checked:ring-2 peer-checked:ring-amber-500 transition-all duration-200">
                                            <div class="flex-shrink-0">
                                                <div class="role-indicator w-5 h-5 rounded-full border-2 transition-all border-gray-300 dark:border-gray-500 flex items-center justify-center">
                                                    <svg class="role-check w-3 h-3 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="role-text font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No roles available
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Bureaus & Sections Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Assign to Bureaus & Sections</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Note: Checking a bureau will automatically select all its sections
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($bureaus as $bureau)
                                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex items-center gap-3 mb-4">
                                            <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" 
                                                {{ $user->assignedBureaus->contains($bureau->id) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500 bureau-checkbox">
                                            <label for="bureau-{{ $bureau->id }}" class="flex items-center gap-2 text-base font-semibold text-gray-800 dark:text-gray-200 cursor-pointer">
                                                <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $bureau->bureau_name }}
                                            </label>
                                        </div>
                                        
                                        @if($bureau->sections->isNotEmpty())
                                            <div class="ml-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                                @foreach($bureau->sections as $section)
                                                    <div class="flex items-center gap-2 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-150">
                                                        <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}"
                                                            {{ $user->assignedSections->contains($section->id) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500 section-checkbox">
                                                        <label for="section-{{ $section->id }}" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer flex-1">
                                                            {{ $section->section_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Button Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg flex-1">
                                <svg class="h-5 w-5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Purpose of this page</p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">
                                        This page allows administrators to modify user roles and assign them to specific bureaus and sections within the organization.
                                    </p>
                                </div>
                            </div>
                            <button type="button" id="updateButton" 
                                class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="text-lg">Update User</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("updateButton").addEventListener("click", function() {
            Swal.fire({
                title: 'Update User?',
                text: "Are you sure you want to update this user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                background: '#101966',
                color: '#fff'
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
                            document.getElementById('updateForm').submit();
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
                title: "Updated!",
                text: "{{ session('success') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif

        // Role selection logic - Update UI when role is selected
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('.role-radio');
            
            function updateRoleUI() {
                roleRadios.forEach(radio => {
                    const label = radio.nextElementSibling;
                    const indicator = label.querySelector('.role-indicator');
                    const check = label.querySelector('.role-check');
                    const text = label.querySelector('.role-text');
                    
                    if (radio.checked) {
                        indicator.classList.remove('border-gray-300', 'dark:border-gray-500');
                        indicator.classList.add('border-amber-500', 'bg-amber-500');
                        check.classList.remove('hidden');
                        check.classList.add('block');
                        text.classList.remove('text-gray-700', 'dark:text-gray-300');
                        text.classList.add('text-amber-700', 'dark:text-amber-300');
                    } else {
                        indicator.classList.add('border-gray-300', 'dark:border-gray-500');
                        indicator.classList.remove('border-amber-500', 'bg-amber-500');
                        check.classList.add('hidden');
                        check.classList.remove('block');
                        text.classList.add('text-gray-700', 'dark:text-gray-300');
                        text.classList.remove('text-amber-700', 'dark:text-amber-300');
                    }
                });
            }
            
            // Initialize on page load
            updateRoleUI();
            
            // Update when role changes
            roleRadios.forEach(radio => {
                radio.addEventListener('change', updateRoleUI);
            });
            
            // Bureau and Section selection logic
            const bureauCheckboxes = document.querySelectorAll('.bureau-checkbox');
            
            // Add event listener to each bureau checkbox
            bureauCheckboxes.forEach(bureauCheckbox => {
                bureauCheckbox.addEventListener('change', function() {
                    const bureauDiv = this.closest('.rounded-xl');
                    
                    // Get all section checkboxes within this bureau
                    const sectionCheckboxes = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    if (this.checked) {
                        // Check all sections when bureau is checked
                        sectionCheckboxes.forEach(sectionCheckbox => {
                            sectionCheckbox.checked = true;
                        });
                    } else {
                        // Uncheck all sections when bureau is unchecked
                        sectionCheckboxes.forEach(sectionCheckbox => {
                            sectionCheckbox.checked = false;
                        });
                    }
                });
            });

            // Add event listener to section checkboxes to handle bureau state
            const sectionCheckboxes = document.querySelectorAll('.section-checkbox');
            sectionCheckboxes.forEach(sectionCheckbox => {
                sectionCheckbox.addEventListener('change', function() {
                    const bureauDiv = this.closest('.rounded-xl');
                    const bureauCheckbox = bureauDiv.querySelector('.bureau-checkbox');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    // Check if all sections are checked
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    
                    // Check if any sections are checked
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked) {
                        // If all sections are checked, check the bureau
                        bureauCheckbox.checked = true;
                        bureauCheckbox.indeterminate = false;
                    } else if (!anySectionsChecked) {
                        // If no sections are checked, uncheck the bureau
                        bureauCheckbox.checked = false;
                        bureauCheckbox.indeterminate = false;
                    } else {
                        // If some sections are checked, set indeterminate state
                        bureauCheckbox.indeterminate = true;
                    }
                });
            });

            // Initialize bureau states based on section selections
            function initializeBureauStates() {
                bureauCheckboxes.forEach(bureauCheckbox => {
                    const bureauDiv = bureauCheckbox.closest('.rounded-xl');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked && allSections.length > 0) {
                        bureauCheckbox.checked = true;
                        bureauCheckbox.indeterminate = false;
                    } else if (anySectionsChecked) {
                        // For partially checked state, we can set indeterminate property
                        bureauCheckbox.indeterminate = true;
                    } else {
                        bureauCheckbox.checked = false;
                        bureauCheckbox.indeterminate = false;
                    }
                });
            }

            // Call initialization
            initializeBureauStates();
        });

    </script>
</x-app-layout>