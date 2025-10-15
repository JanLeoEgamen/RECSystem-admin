<section class="space-y-6">
    <!-- Danger Zone Warning -->
    <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 dark:border-red-600 rounded-r-xl p-6">
        <div class="absolute inset-0 bg-red-100 dark:bg-red-900 opacity-10"></div>
        <div class="relative z-10">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-red-500 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-red-800 dark:text-red-200 mb-2">Permanent Account Deletion</h4>
                    <p class="text-red-700 dark:text-red-300 text-sm leading-relaxed mb-4">
                        This action cannot be undone. Once your account is deleted, all of your data, membership information, certificates, and activity history will be permanently removed from our servers.
                    </p>
                    <div class="bg-red-100 dark:bg-red-900/40 rounded-lg p-3">
                        <h5 class="font-semibold text-red-800 dark:text-red-200 text-sm mb-2">What will be deleted:</h5>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Personal profile and account information
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Membership records and certificates
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Activity logs and system records
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                All associated files and documents
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="flex justify-center">
        <button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 border-2 border-red-500 hover:border-red-400">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span>Delete My Account</span>
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <!-- Modal Header -->
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    {{ __('Confirm Account Deletion') }}
                </h2>
            </div>

            <!-- Warning Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-500 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <p class="text-red-800 dark:text-red-200 text-sm font-medium">
                            {{ __('This action is irreversible!') }}
                        </p>
                        <p class="text-red-700 dark:text-red-300 text-sm mt-1">
                            {{ __('All your data, including membership records, certificates, and activity history will be permanently deleted from our servers.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>{{ __('Confirm with your password') }}</span>
                    </div>
                </label>

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-100"
                    placeholder="{{ __('Enter your password to confirm deletion') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    {{ __('Delete Account Permanently') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
