<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Create User
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('users.store')}}" method="post" id="userForm">
                        @csrf
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Personal Information</h3>
                                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <input value="{{ old('first_name') }}" name="first_name" id="first_name" placeholder="Enter first name" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" required>
                                            @error('first_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <input value="{{ old('last_name') }}" name="last_name" id="last_name" placeholder="Enter last name" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" required>
                                            @error('last_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="birthdate" class="block text-sm font-medium">Birthdate <span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <input value="{{ old('birthdate') }}" name="birthdate" id="birthdate" type="date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" required>
                                            @error('birthdate')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <input value="{{ old('email') }}" name="email" id="email" placeholder="Enter email" type="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="password" class="block text-sm font-medium">Password <span class="text-red-500">*</span></label>
                                        <div class="mt-1 relative">
                                            <input value="{{ old('password') }}" name="password" id="password" placeholder="Enter Password" type="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 pr-10" onkeyup="validatePassword()" required>
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
                                        <div id="password-requirements" class="text-xs mt-2 hidden">
                                            <p class="text-gray-500 dark:text-gray-400">Password must contain:</p>
                                            <ul class="list-disc pl-5 mt-1">
                                                <li id="req-length" class="text-red-500">At least 8 characters</li>
                                                <li id="req-uppercase" class="text-red-500">One uppercase letter</li>
                                                <li id="req-lowercase" class="text-red-500">One lowercase letter</li>
                                                <li id="req-number" class="text-red-500">One number</li>
                                                <li id="req-special" class="text-red-500">One special character</li>
                                            </ul>
                                        </div>
                                        @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="confirm_password" class="block text-sm font-medium">Confirm Password <span class="text-red-500">*</span></label>
                                        <div class="mt-1 relative">
                                            <input value="{{ old('confirm_password') }}" name="confirm_password" id="confirm_password" placeholder="Confirm Your Password" type="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 pr-10" onkeyup="validatePasswordConfirmation()" required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('confirm_password')">
                                                <svg id="confirm_password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="confirm_password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="password-confirmation-message" class="text-xs mt-2 hidden"></div>
                                        @error('confirm_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Assign Roles</h3>
                                <div class="mt-4">
                                    @if ($roles->isNotEmpty())
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach($roles as $role)
                                                <div class="relative flex items-start">
                                                    <div class="flex h-5 items-center">
                                                        <input id="role-{{ $role->id }}" 
                                                            name="role" 
                                                            type="radio" 
                                                            value="{{ $role->name }}" 
                                                            class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                            @if(old('role') === $role->name) checked @endif
                                                            required>
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="role-{{ $role->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('role')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No roles available</p>
                                    @endif
                                </div>
                            </div> 

                              <!-- Bureaus & Sections Selection -->
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Assign to Bureaus & Sections</h3>
                                <div class="mt-4 space-y-6">
                                    @foreach($bureaus as $bureau)
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" 
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bureau-checkbox"
                                                    data-bureau-id="{{ $bureau->id }}">
                                                <label for="bureau-{{ $bureau->id }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $bureau->bureau_name }}
                                                </label>
                                            </div>
                                            
                                            @if($bureau->sections->isNotEmpty())
                                                <div class="mt-3 ml-7 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($bureau->sections as $section)
                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}"
                                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 section-checkbox"
                                                                data-bureau-id="{{ $bureau->id }}">
                                                            <label for="section-{{ $section->id }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-400">
                                                                {{ $section->section_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" id="submitButton"
                                    class="inline-flex items-center px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] 
                                           border border-white hover:border-[#101966] rounded-lg font-medium text-lg transition-colors duration-200
                                           dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                           dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
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
            
            if (document.getElementById('confirm_password').value.length > 0) {
                validatePasswordConfirmation();
            }
        }
        
        function validatePasswordConfirmation() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
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

        document.addEventListener('DOMContentLoaded', function() {
            const bureauCheckboxes = document.querySelectorAll('.bureau-checkbox');
            const sectionCheckboxes = document.querySelectorAll('.section-checkbox');
            
            bureauCheckboxes.forEach(bureauCheckbox => {
                bureauCheckbox.addEventListener('change', function() {
                    const bureauId = this.getAttribute('data-bureau-id');
                    const sections = document.querySelectorAll(`.section-checkbox[data-bureau-id="${bureauId}"]`);
                    
                    sections.forEach(section => {
                        section.checked = this.checked;
                    });
                });
            });
            
            sectionCheckboxes.forEach(sectionCheckbox => {
                sectionCheckbox.addEventListener('change', function() {
                    const bureauId = this.getAttribute('data-bureau-id');
                    const bureauCheckbox = document.querySelector(`.bureau-checkbox[data-bureau-id="${bureauId}"]`);
                    const sections = document.querySelectorAll(`.section-checkbox[data-bureau-id="${bureauId}"]`);
                    
                    let allChecked = true;
                    sections.forEach(section => {
                        if (!section.checked) {
                            allChecked = false;
                        }
                    });
                    
                    bureauCheckbox.checked = allChecked;
                });
            });
        });
        
        document.getElementById('submitButton').addEventListener('click', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
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
                title: 'Create User?',
                text: "Are you sure you want to create this user?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'Cancel',
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
                            document.getElementById('userForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });

            // Bureau and Section selection logic
        document.addEventListener('DOMContentLoaded', function() {
            // Get all bureau checkboxes
            const bureauCheckboxes = document.querySelectorAll('.bureau-checkbox');
            
            // Add event listener to each bureau checkbox
            bureauCheckboxes.forEach(bureauCheckbox => {
                bureauCheckbox.addEventListener('change', function() {
                    const bureauId = this.value;
                    const bureauDiv = this.closest('.rounded-lg');
                    
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

            // Optional: Add event listener to section checkboxes to handle bureau state
            const sectionCheckboxes = document.querySelectorAll('.section-checkbox');
            sectionCheckboxes.forEach(sectionCheckbox => {
                sectionCheckbox.addEventListener('change', function() {
                    const bureauDiv = this.closest('.rounded-lg');
                    const bureauCheckbox = bureauDiv.querySelector('.bureau-checkbox');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    // Check if all sections are checked
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    
                    // Check if any sections are checked
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked) {
                        // If all sections are checked, check the bureau
                        bureauCheckbox.checked = true;
                    } else if (!anySectionsChecked) {
                        // If no sections are checked, uncheck the bureau
                        bureauCheckbox.checked = false;
                    }
                    // If some but not all sections are checked, the bureau remains in indeterminate state
                    // (visually, this won't show as checked or unchecked)
                });
            });

            // Initialize bureau states based on section selections
            function initializeBureauStates() {
                bureauCheckboxes.forEach(bureauCheckbox => {
                    const bureauDiv = bureauCheckbox.closest('.rounded-lg');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked) {
                        bureauCheckbox.checked = true;
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