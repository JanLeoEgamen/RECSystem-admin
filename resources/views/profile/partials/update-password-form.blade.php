<section>
    <!-- Security Notice -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-600 rounded-r-lg p-4 mb-6">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">Password Security</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300">Use a strong password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.</p>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div x-data="{ showSuccess: @if(session('status') === 'password-updated') true @else false @endif }"
         x-show="showSuccess"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         x-init="@if(session('status') === 'password-updated') setTimeout(() => showSuccess = false, 5000) @endif"
         class="mb-6 relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
        <div class="absolute inset-0 bg-white opacity-10"></div>
        <div class="relative z-10 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-2 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-semibold text-white">Password Updated Successfully!</h4>
                    <p class="text-white text-opacity-90 text-sm">Your account security has been improved.</p>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-2xl" onsubmit="return confirmPasswordUpdate()">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="group">
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Current Password</span>
                </div>
            </label>
            <div class="relative">
                <x-text-input id="update_password_current_password" 
                             name="current_password" 
                             type="password" 
                             class="mt-1 block w-full pr-12 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 transition-all duration-300 group-hover:shadow-md" 
                             autocomplete="current-password" 
                             placeholder="Enter your current password"
                             oninput="toggleVisibilityButton('update_password_current_password')" />
                <button type="button" 
                        id="toggle_update_password_current_password"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer transition-colors duration-200 hidden" 
                        onclick="togglePassword('update_password_current_password')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="group">
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>New Password</span>
                </div>
            </label>
            <div class="relative">
                <x-text-input id="update_password_password" 
                             name="password" 
                             type="password" 
                             class="mt-1 block w-full pr-12 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 transition-all duration-300 group-hover:shadow-md" 
                             autocomplete="new-password" 
                             placeholder="Enter your new password"
                             oninput="toggleVisibilityButton('update_password_password')" />
                <button type="button" 
                        id="toggle_update_password_password"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer transition-colors duration-200 hidden" 
                        onclick="togglePassword('update_password_password')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Confirm New Password</span>
                </div>
            </label>
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" 
                             name="password_confirmation" 
                             type="password" 
                             class="mt-1 block w-full pr-12 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 transition-all duration-300 group-hover:shadow-md" 
                             autocomplete="new-password" 
                             placeholder="Confirm your new password"
                             oninput="toggleVisibilityButton('update_password_password_confirmation')" />
                <button type="button" 
                        id="toggle_update_password_password_confirmation"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer transition-colors duration-200 hidden" 
                        onclick="togglePassword('update_password_password_confirmation')">>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-4">
            <button type="submit" 
                    class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Update Password</span>
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="inline-flex items-center text-sm text-green-600 dark:text-green-400 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Saved!
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    function toggleVisibilityButton(inputId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById('toggle_' + inputId);
        
        if (input.value.length > 0) {
            button.classList.remove('hidden');
        } else {
            button.classList.add('hidden');
        }
    }

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById('toggle_' + inputId);
        
        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            `;
        } else {
            input.type = 'password';
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `;
        }
    }

    function confirmPasswordUpdate() {
        return confirm('Are you sure you want to update your password? This will require you to log in again on other devices.');
    }
</script>