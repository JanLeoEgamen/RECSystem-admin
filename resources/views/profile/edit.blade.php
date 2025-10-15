<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Profile Settings') }}
            </h2>
        </div>
    </x-slot>

    @vite('resources/css/profile.css')

    <div class="py-8 px-4 sm:px-6 lg:px-8 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">
            
            <!-- Profile Overview Header -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl shadow-xl animate-slide-up" style="animation-delay: 0.1s;">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10 p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Welcome, {{ auth()->user()->first_name }}!</h3>
                            <p class="text-white text-opacity-90 mt-1 text-sm sm:text-base">Manage your account settings and preferences</p>
                            <div class="flex flex-col sm:flex-row items-center mt-3 space-y-2 sm:space-y-0 sm:space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-white bg-opacity-20 text-white">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="break-all">{{ auth()->user()->email }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-white opacity-10 rounded-full -mt-12 -mr-12 sm:-mt-16 sm:-mr-16"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 sm:w-20 sm:h-20 bg-white opacity-10 rounded-full -mb-8 -ml-8 sm:-mb-10 sm:-ml-10"></div>
            </div>

            <!-- Profile Information Card -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Profile Information</h3>
                            <p class="text-gray-600 dark:text-gray-400">Your account details are managed by the system</p>
                        </div>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            </div>

            <!-- Password Update Card -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 animate-slide-up" style="animation-delay: 0.3s;">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Security Settings</h3>
                            <p class="text-gray-600 dark:text-gray-400">Keep your account secure with a strong password</p>
                        </div>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-600"></div>
            </div>

            <!-- Danger Zone Card -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 animate-slide-up" style="animation-delay: 0.4s;">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Danger Zone</h3>
                            <p class="text-gray-600 dark:text-gray-400">Permanently delete your account and all data</p>
                        </div>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-600"></div>
            </div>

        </div>
    </div>
</x-app-layout>
