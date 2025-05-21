<x-guest-layout>
    <div class="w-full mx-auto p-8 bg-white dark:bg-gray-800 rounded-xl">
        <div class="text-center mb-10">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('Application-logo/Logo.png') }}" 
                     alt="{{ config('app.name', 'RECInc') }}" 
                     class="h-20 w-auto">
            </div>
            <h2 class="text-4xl font-bold text-[#101966] dark:text-white">Create Your Account</h2>
            <p class="text-gray-500 dark:text-gray-300 mt-3">Join us today to get started!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" class="text-gray-700 dark:text-gray-300 text-lg" />
                    <x-text-input 
                        id="first_name" 
                        class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="text" 
                        name="first_name" 
                        :value="old('first_name')" 
                        required 
                        autofocus 
                        autocomplete="given-name"
                        placeholder="Juan" 
                    />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" class="text-gray-700 dark:text-gray-300 text-lg" />
                    <x-text-input 
                        id="last_name" 
                        class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="text" 
                        name="last_name" 
                        :value="old('last_name')" 
                        required 
                        autocomplete="family-name"
                        placeholder="Cruz" 
                    />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>
            </div>

            <!-- Birthdate -->
            <div>
                <x-input-label for="birthdate" :value="__('Birthdate')" class="text-gray-700 dark:text-gray-300 text-lg" />
                <x-text-input 
                    id="birthdate" 
                    class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500" 
                    type="date" 
                    name="birthdate" 
                    :value="old('birthdate')" 
                />
                <x-input-error :messages="$errors->get('birthdate')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>
            
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 text-lg" />
                <x-text-input 
                    id="email" 
                    class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autocomplete="username"
                    placeholder="your@email.com" 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Password Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 text-lg" />
                    <div class="relative">
                        <x-text-input 
                            id="password" 
                            class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500 pr-12"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button type="button" 
                                class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                onclick="togglePasswordVisibility('password')"
                                aria-label="Toggle password visibility">
                            <svg id="password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 text-lg" />
                    <div class="relative">
                        <x-text-input 
                            id="password_confirmation" 
                            class="block mt-2 w-full px-5 py-3 text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500 pr-12"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button type="button" 
                                class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                onclick="togglePasswordVisibility('password_confirmation')"
                                aria-label="Toggle password visibility">
                            <svg id="password_confirmation-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password_confirmation-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <a class="text-lg text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium transition-colors" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="py-4 px-6 text-lg">
                    {{ __('Register') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`${fieldId}-eye-icon`);
            const eyeSlashIcon = document.getElementById(`${fieldId}-eye-slash-icon`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>