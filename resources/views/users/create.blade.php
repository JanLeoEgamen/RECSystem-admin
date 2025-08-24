<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Create User
            </h2>
            <a href="{{ route('users.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition duration-150 ease-in-out">
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
                    <form action="{{route('users.store')    }} " method="post" id="userForm">
                        @csrf
                        <div class="space-y-6">
                            <!-- Personal Information Section -->
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Personal Information</h3>
                                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-medium">First Name</label>
                                        <div class="mt-1">
                                            <input value="{{ old('first_name') }}" name="first_name" placeholder="Enter first name" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                            @error('first_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-medium">Last Name</label>
                                        <div class="mt-1">
                                            <input value="{{ old('last_name') }}" name="last_name" placeholder="Enter last name" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                            @error('last_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="birthdate" class="block text-sm font-medium">Birthdate</label>
                                        <div class="mt-1">
                                            <input value="{{ old('birthdate') }}" name="birthdate" type="date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                            @error('birthdate')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium">Email</label>
                                        <div class="mt-1">
                                            <input value="{{ old('email') }}" name="email" placeholder="Enter email" type="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <label for="password" class="text-sm font-medium"> Password</label>
                            <div class="my-3 w-1/2">
                                <div class="relative">
                                    <input value="{{ old('password') }}" name="password" id="password" placeholder="Enter Password" type="password" class="border-gray-300 shadow-sm w-full rounded-lg pr-10" onkeyup="validatePassword()">
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
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="confirm_password" class="text-sm font-medium"> Confirm Password</label>
                            <div class="my-3 w-1/2">
                                <div class="relative">
                                    <input value="{{ old('confirm_password') }}" name="confirm_password" id="confirm_password" placeholder="Confirm Your Password" type="password" class="border-gray-300 shadow-sm w-full rounded-lg pr-10" onkeyup="validatePasswordConfirmation()">
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
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>
                                </div>
                            </div>

                            <!-- Roles Section -->
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
                                                            @if(old('role') === $role->name) checked @endif>
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

                              <!-- Bureaus & Sections Section -->
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Assign to Bureaus & Sections</h3>
                                <div class="mt-4 space-y-6">
                                    @foreach($bureaus as $bureau)
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" 
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bureau-checkbox">
                                                <label for="bureau-{{ $bureau->id }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $bureau->bureau_name }}
                                                </label>
                                            </div>
                                            
                                            @if($bureau->sections->isNotEmpty())
                                                <div class="mt-3 ml-7 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($bureau->sections as $section)
                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}"
                                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 section-checkbox">
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

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    Create User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            
            // Show requirements when typing
            if (password.length > 0) {
                requirements.classList.remove('hidden');
            } else {
                requirements.classList.add('hidden');
                return;
            }
            
            // Check each requirement
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            // Update requirement indicators
            document.getElementById('req-length').className = hasMinLength ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-uppercase').className = hasUppercase ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-lowercase').className = hasLowercase ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-number').className = hasNumber ? 'text-green-500' : 'text-red-500';
            document.getElementById('req-special').className = hasSpecialChar ? 'text-green-500' : 'text-red-500';
            
            // Validate password confirmation if it exists
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
        
        // Add form validation before submission
        document.getElementById('userForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            
            // Check if password meets all requirements
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            if (!hasMinLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
                event.preventDefault();
                alert('Password does not meet all requirements. Please ensure it has at least 8 characters with uppercase, lowercase, number, and special character.');
                return false;
            }
            
            // Check if passwords match
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Passwords do not match. Please confirm your password correctly.');
                return false;
            }
        });
    </script>
</x-app-layout>