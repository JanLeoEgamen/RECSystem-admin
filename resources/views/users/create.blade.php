<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="font-bold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                    Create New User
                </h2>
            </div>

            <a href="{{ route('users.index') }}" 
                class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium 
                        rounded-lg text-lg md:text-xl leading-normal transition-all duration-200 
                        w-full md:w-auto mt-4 md:mt-0 text-center shadow-lg hover:shadow-xl
                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                Back to Users
            </a>                
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{route('users.store')}}" method="post" id="userForm">
                        @csrf
                        <div class="space-y-8">
                            <!-- Personal Information Section -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Personal Information</h3>
                                </div>
                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                First Name <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1">
                                            <input value="{{ old('first_name') }}" name="first_name" id="first_name" placeholder="Enter first name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4" required>
                                            @error('first_name')
                                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Last Name <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1">
                                            <input value="{{ old('last_name') }}" name="last_name" id="last_name" placeholder="Enter last name" type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4" required>
                                            @error('last_name')
                                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="birthdate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Birthdate <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1">
                                            <input value="{{ old('birthdate') }}" name="birthdate" id="birthdate" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4" required>
                                            @error('birthdate')
                                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Email <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1">
                                            <input value="{{ old('email') }}" name="email" id="email" placeholder="Enter email" type="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4" required>
                                            @error('email')
                                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Password <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1 relative">
                                            <input value="{{ old('password') }}" name="password" id="password" placeholder="Enter Password" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-12 transition-all duration-200 py-3 px-4" onkeyup="validatePassword()" required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" onclick="togglePasswordVisibility('password')">
                                                <svg id="password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="password-requirements" class="text-xs mt-3 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg hidden border border-gray-200 dark:border-gray-700">
                                            <p class="text-gray-600 dark:text-gray-400 font-semibold mb-2">Password must contain:</p>
                                            <ul class="space-y-1 pl-5">
                                                <li id="req-length" class="text-red-500 flex items-center gap-2">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    At least 8 characters
                                                </li>
                                                <li id="req-uppercase" class="text-red-500 flex items-center gap-2">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    One uppercase letter
                                                </li>
                                                <li id="req-lowercase" class="text-red-500 flex items-center gap-2">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    One lowercase letter
                                                </li>
                                                <li id="req-number" class="text-red-500 flex items-center gap-2">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    One number
                                                </li>
                                                <li id="req-special" class="text-red-500 flex items-center gap-2">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    One special character
                                                </li>
                                            </ul>
                                        </div>
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="confirm_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Confirm Password <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="mt-1 relative">
                                            <input value="{{ old('confirm_password') }}" name="confirm_password" id="confirm_password" placeholder="Confirm Your Password" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-12 transition-all duration-200 py-3 px-4" onkeyup="validatePasswordConfirmation()" required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" onclick="togglePasswordVisibility('confirm_password')">
                                                <svg id="confirm_password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="confirm_password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="password-confirmation-message" class="text-sm mt-3 p-3 rounded-lg hidden"></div>
                                        @error('confirm_password')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Assign Roles Section -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Assign Roles</h3>
                                </div>
                                <div class="mt-6">
                                    @if ($roles->isNotEmpty())
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach($roles as $role)
                                                <div class="relative flex items-start p-4 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-200 cursor-pointer bg-gray-50 dark:bg-gray-700/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                                                    <div class="flex h-5 items-center">
                                                        <input id="role-{{ $role->id }}" 
                                                            name="role" 
                                                            type="radio" 
                                                            value="{{ $role->name }}" 
                                                            class="h-5 w-5 rounded-full border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500 cursor-pointer"
                                                            @if(old('role') === $role->name) checked @endif
                                                            required>
                                                    </div>
                                                    <div class="ml-3 text-sm flex-1">
                                                        <label for="role-{{ $role->id }}" class="font-semibold text-gray-800 dark:text-gray-200 cursor-pointer">{{ $role->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('role')
                                            <p class="mt-3 text-sm text-red-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">No roles available</p>
                                    @endif
                                </div>
                            </div> 

                              <!-- Bureaus & Sections Selection -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-green-500 to-teal-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Assign to Bureaus & Sections</h3>
                                </div>
                                <div class="mt-6 space-y-4">
                                    @foreach($bureaus as $bureau)
                                        <div class="rounded-xl border-2 border-gray-200 dark:border-gray-600 p-5 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800/50 hover:border-teal-400 dark:hover:border-teal-500 transition-all duration-200">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" 
                                                    class="h-5 w-5 rounded border-gray-300 text-teal-600 focus:ring-2 focus:ring-teal-500 cursor-pointer bureau-checkbox"
                                                    data-bureau-id="{{ $bureau->id }}">
                                                <label for="bureau-{{ $bureau->id }}" class="ml-3 block text-base font-bold text-gray-800 dark:text-gray-200 cursor-pointer">
                                                    {{ $bureau->bureau_name }}
                                                </label>
                                            </div>
                                            
                                            @if($bureau->sections->isNotEmpty())
                                                <div class="mt-4 ml-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($bureau->sections as $section)
                                                        <div class="flex items-center p-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all duration-200">
                                                            <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}"
                                                                class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-2 focus:ring-teal-500 cursor-pointer section-checkbox"
                                                                data-bureau-id="{{ $bureau->id }}">
                                                            <label for="section-{{ $section->id }}" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
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
                            <div class="flex justify-end pt-4">
                                <button type="button" id="submitButton"
                                    class="inline-flex items-center px-8 py-4 text-white bg-gradient-to-r from-[#101966] to-indigo-700 hover:from-white hover:to-gray-50 hover:text-[#101966] 
                                           border-2 border-[#101966] hover:border-[#101966] rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105
                                           dark:from-gray-900 dark:to-gray-800 dark:text-white dark:border-gray-100 
                                           dark:hover:from-gray-700 dark:hover:to-gray-600 dark:hover:text-white dark:hover:border-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            
            updateRequirement('req-length', hasMinLength);
            updateRequirement('req-uppercase', hasUppercase);
            updateRequirement('req-lowercase', hasLowercase);
            updateRequirement('req-number', hasNumber);
            updateRequirement('req-special', hasSpecialChar);
            
            if (document.getElementById('confirm_password').value.length > 0) {
                validatePasswordConfirmation();
            }
        }
        
        function updateRequirement(id, isValid) {
            const element = document.getElementById(id);
            if (isValid) {
                element.className = 'text-green-500 flex items-center gap-2';
                element.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
            } else {
                element.className = 'text-red-500 flex items-center gap-2';
                element.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
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
                messageElement.className = 'text-sm mt-3 p-3 rounded-lg bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700';
                messageElement.innerHTML = '<p class="text-green-700 dark:text-green-400 flex items-center gap-2 font-semibold"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>Passwords match!</p>';
            } else {
                messageElement.className = 'text-sm mt-3 p-3 rounded-lg bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700';
                messageElement.innerHTML = '<p class="text-red-700 dark:text-red-400 flex items-center gap-2 font-semibold"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>Passwords do not match</p>';
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