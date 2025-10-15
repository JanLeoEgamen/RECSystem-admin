<section>
    <!-- Information Notice -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-600 rounded-r-lg p-4 mb-6">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">System Managed Profile</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300">Your profile information is managed by the system administrator. Contact support if you need to update your details.</p>
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- First Name Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">First Name</h5>
                </div>
                <div class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">
                    {{ $user->first_name }}
                </div>
                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </div>

            <!-- Last Name Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">Last Name</h5>
                </div>
                <div class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                    {{ $user->last_name }}
                </div>
                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </div>

            <!-- Email Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300">Email Address</h5>
                </div>
                <div class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300 break-all">
                    {{ $user->email }}
                </div>
                <input type="hidden" name="email" value="{{ $user->email }}">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </div>
        </div>
    </form>
</section>