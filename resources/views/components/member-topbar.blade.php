<!-- MEMBER-TOPBAR.BLADE.PHP -->
<!-- Member Portal Navigation Component -->
@role('Member')
    <!-- Desktop/Tablet view --> 
    <div class="hidden sm:flex sm:ml-auto sm:mr-4 items-center space-x-4">
        <nav class="flex gap-2 md:gap-4">
            @unless(auth()->user()->member->isExpired())
                <!-- Dashboard -->
                <x-nav-link 
                    :href="route('member.dashboard')"
                    :active="request()->routeIs('member.dashboard')" 
                    class="member-nav-link px-4 py-2 text-sm whitespace-nowrap rounded-lg dark:text-gray-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                        {{ request()->routeIs('member.dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-white hover:bg-gradient-to-r hover:from-white/10 hover:to-white/20 hover:backdrop-blur-sm' }}"
                >
                    <div class="flex items-center gap-2">
                        {{ __('Dashboard') }}
                    </div>
                </x-nav-link>

                <!-- My Membership -->
                <x-nav-link 
                    :href="route('member.membership-details')"
                    :active="request()->routeIs('member.membership-details')" 
                    class="member-nav-link px-4 py-2 text-sm whitespace-nowrap rounded-lg dark:text-gray-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                        {{ request()->routeIs('member.membership-details') ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold shadow-lg shadow-purple-500/25' : 'text-white hover:bg-gradient-to-r hover:from-white/10 hover:to-white/20 hover:backdrop-blur-sm' }}"
                >
                    <div class="flex items-center gap-2">
                        {{ __('My Membership') }}
                    </div>
                </x-nav-link>

                <!-- Member Services Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open" 
                        @click.away="open = false"
                        class="member-nav-link px-4 py-2 text-sm whitespace-nowrap rounded-lg dark:text-gray-200 flex items-center gap-2 transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                            {{ request()->routeIs(['member.announcements', 'member.surveys', 'member.events', 'member.quizzes', 'member.certificates.index', 'member.documents']) ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold shadow-lg shadow-emerald-500/25' : 'text-white hover:bg-gradient-to-r hover:from-white/10 hover:to-white/20 hover:backdrop-blur-sm' }}"
                    >
                        Services
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Enhanced Dropdown Menu -->
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 transform -translate-y-2"
                        class="absolute left-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-600 overflow-hidden z-50"
                        style="display: none;"
                    >
                        <!-- Dropdown Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Member Services</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Access your member features</p>
                        </div>

                        <!-- Dropdown Items -->
                        <div class="py-2">
                            <a href="{{ route('member.announcements') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/20 dark:hover:to-blue-800/20
                                      {{ request()->routeIs('member.announcements') ? 'bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/30 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Announcements') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Latest updates & news</div>
                                </div>
                            </a>

                            <a href="{{ route('member.surveys') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-purple-50 hover:to-purple-100 dark:hover:from-purple-900/20 dark:hover:to-purple-800/20
                                      {{ request()->routeIs('member.surveys') ? 'bg-gradient-to-r from-purple-100 to-purple-50 dark:from-purple-900/30 dark:to-purple-800/30 text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Surveys') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Share your feedback</div>
                                </div>
                            </a>

                            <a href="{{ route('member.events') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 dark:hover:from-green-900/20 dark:hover:to-green-800/20
                                      {{ request()->routeIs('member.events') ? 'bg-gradient-to-r from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/30 text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/50 group-hover:bg-green-200 dark:group-hover:bg-green-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h4zM16 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1h-4a1 1 0 01-1-1V7a1 1 0 011-1h4zM8 15v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1zM16 15v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Events') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Upcoming activities</div>
                                </div>
                            </a>

                            <a href="{{ route('member.quizzes') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 dark:hover:from-orange-900/20 dark:hover:to-orange-800/20
                                      {{ request()->routeIs('member.quizzes') ? 'bg-gradient-to-r from-orange-100 to-orange-50 dark:from-orange-900/30 dark:to-orange-800/30 text-orange-700 dark:text-orange-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 group-hover:bg-orange-200 dark:group-hover:bg-orange-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Reviewers') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Test your knowledge</div>
                                </div>
                            </a>

                            <a href="{{ route('member.certificates.index') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-yellow-100 dark:hover:from-yellow-900/20 dark:hover:to-yellow-800/20
                                      {{ request()->routeIs('member.certificates.index') ? 'bg-gradient-to-r from-yellow-100 to-yellow-50 dark:from-yellow-900/30 dark:to-yellow-800/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/50 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Certificates') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Your achievements</div>
                                </div>
                            </a>

                            <a href="{{ route('member.documents') }}" 
                               class="group flex items-center px-4 py-3 text-sm transition-all duration-200 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-indigo-100 dark:hover:from-indigo-900/20 dark:hover:to-indigo-800/20
                                      {{ request()->routeIs('member.documents') ? 'bg-gradient-to-r from-indigo-100 to-indigo-50 dark:from-indigo-900/30 dark:to-indigo-800/30 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50 transition-colors duration-200 mr-3">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('Documents') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Important files</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- My Logs -->
                <x-nav-link 
                    :href="route('members.activity_logs', Auth::user()->member->id)"
                    :active="request()->routeIs('members.activity_logs')" 
                    class="member-nav-link px-4 py-2 text-sm whitespace-nowrap rounded-lg dark:text-gray-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                        {{ request()->routeIs('members.activity_logs') ? 'bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold shadow-lg shadow-rose-500/25' : 'text-white hover:bg-gradient-to-r hover:from-white/10 hover:to-white/20 hover:backdrop-blur-sm' }}"
                >
                    <div class="flex items-center gap-2">
                        {{ __('My Logs') }}
                    </div>
                </x-nav-link>
            @endunless
        </nav>

        <!-- Enhanced Profile Icon Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                @click.away="open = false"
                class="p-3 rounded-full bg-gradient-to-r from-white/10 to-white/20 hover:from-white/20 hover:to-white/30 transition-all duration-300 transform hover:scale-110 hover:shadow-lg backdrop-blur-sm border border-white/20"
            >
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </button>

            <!-- Enhanced Profile Dropdown -->
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 transform -translate-y-2"
                class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-600 overflow-hidden z-50"
                style="display: none;"
            >
                <!-- Profile Header -->
                <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 border-b border-gray-200 dark:border-gray-600">
                    <div class="text-left">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Profile Actions -->
                <div class="py-2">
                    <a href="{{ route('profile.edit') }}" 
                       class="group flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/20 dark:hover:to-blue-800/20 transition-all duration-200">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors duration-200 mr-3">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium">{{ __('Profile Settings') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Manage your account</div>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button 
                            type="submit"
                            class="group flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 dark:hover:from-red-900/20 dark:hover:to-red-800/20 transition-all duration-200 text-left"
                        >
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/50 group-hover:bg-red-200 dark:group-hover:bg-red-800/50 transition-colors duration-200 mr-3">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="font-medium">{{ __('Log Out') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Sign out securely</div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Enhanced Mobile menu button -->
    <button 
        @click="memberMenuOpen = true" 
        class="sm:hidden p-3 rounded-xl bg-gradient-to-r from-white/10 to-white/20 hover:from-white/20 hover:to-white/30 text-white dark:text-gray-200 transition-all duration-300 transform hover:scale-110 backdrop-blur-sm border border-white/20"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Mobile Right Slide-in Menu -->
    <div 
        class="fixed inset-0 z-50 flex justify-end sm:hidden"
        x-show="memberMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <!-- Backdrop -->
        <div 
            class="absolute inset-0 bg-black/50 dark:bg-black/70 z-10" 
            @click="memberMenuOpen = false"
        ></div>

        <!-- Modern Slide-in Menu -->
        <div 
            class="relative w-80 bg-gradient-to-b from-[#101966] via-[#1a2077] to-[#101966] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 h-full flex flex-col shadow-2xl z-20"
            x-show="memberMenuOpen"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <!-- Header Section -->
            <div class="flex items-center justify-between p-6 border-b border-white/10 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 dark:bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="https://img.icons8.com/ios-glyphs/30/ffffff/user--v1.png" class="h-6 w-6"/>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-lg">{{ Auth::user()->first_name }}</p>
                        <p class="text-blue-200 dark:text-gray-300 text-sm">Member Portal</p>
                    </div>
                </div>
                <button 
                    @click="memberMenuOpen = false" 
                    class="p-2 rounded-full bg-white/10 hover:bg-white/20 dark:bg-gray-700 dark:hover:bg-gray-600 text-white transition-all duration-200 hover:rotate-90"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Section -->
            <div class="flex-1 overflow-y-auto p-4 space-y-1">
                @unless(auth()->user()->member->isExpired())
                    @php
                        $menuItems = [
                            'member.dashboard' => ['label' => 'Dashboard', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z M3 7l9 6 9-6'],
                            'member.membership-details' => ['label' => 'My Membership', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            'member.announcements' => ['label' => 'Announcements', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                            'member.surveys' => ['label' => 'Surveys', 'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            'member.events' => ['label' => 'Events', 'icon' => 'M8 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h4zM16 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1h-4a1 1 0 01-1-1V7a1 1 0 011-1h4zM8 15v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1zM16 15v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1z'],
                            'member.quizzes' => ['label' => 'Reviewers', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                            'member.certificates.index' => ['label' => 'Certificates', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                            'member.documents' => ['label' => 'Documents', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            'members.activity_logs' => ['label' => 'My Logs', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ];
                    @endphp

                    @foreach ($menuItems as $route => $item)
                        <x-nav-link 
                            :href="$route === 'members.activity_logs' 
                                ? route($route, Auth::user()->member->id) 
                                : route($route)"
                            :active="request()->routeIs($route)" 
                            class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-white/10 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 group {{ request()->routeIs($route) ? 'bg-white/20 dark:bg-gray-700 border-l-4 border-white' : '' }}"
                            @click="memberMenuOpen = false"
                        >
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200 {{ request()->routeIs($route) ? 'text-white' : 'text-blue-200 dark:text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                            </div>
                            <span class="font-medium">{{ __($item['label']) }}</span>
                            @if(request()->routeIs($route))
                                <div class="ml-auto">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            @endif
                        </x-nav-link>
                    @endforeach
                @else
                    <!-- Enhanced Expired Message -->
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-xl shadow-lg border border-red-400">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div>
                                <p class="text-white font-semibold text-sm">Membership Expired</p>
                                <p class="text-red-100 text-xs mt-1">Please renew to access member features.</p>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>

            <!-- Footer Section with Profile Actions -->
            <div class="border-t border-white/10 dark:border-gray-700 p-4 space-y-2">
                <x-nav-link 
                    :href="route('profile.edit')" 
                    class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-white/10 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 group"
                    @click="memberMenuOpen = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-200 dark:text-gray-400 group-hover:text-white transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Profile Settings</span>
                </x-nav-link>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button 
                        type="submit"
                        class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-red-500/20 dark:hover:bg-red-600/20 rounded-lg transition-all duration-200 group"
                        @click="memberMenuOpen = false"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-300 group-hover:text-red-400 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Log Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endrole