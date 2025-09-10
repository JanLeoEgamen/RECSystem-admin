@can('view admin dashboard')
<!-- Right Sidebar -->
<aside 
    x-show="rightSidebarOpen"
    @click.away="rightSidebarOpen = false"
    class="fixed inset-y-0 right-0 z-40 w-64 md:w-80 flex flex-col bg-[#101966] dark:bg-gray-900 right-sidebar-shadow"
    style="margin-top: 4rem; height: calc(100vh - 4rem); display: none;"
    x-transition:enter="transform transition-all duration-300 ease-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transform transition-all duration-300 ease-in"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
>
    <!-- Sidebar Header -->
    <div class="px-4 py-3 flex items-center justify-center relative">
        <h2 class="text-base md:text-lg font-semibold text-white dark:text-gray-200 flex items-center">
            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Quick Actions
        </h2>
        <button @click="rightSidebarOpen = false" class="p-1 rounded-md hover:bg-white/10 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-gray-200 absolute right-4">
            <svg class="h-4 w-4 md:h-5 md:w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto scrollbar-left p-3 md:p-4 space-y-3 md:space-y-4">

        <!-- Membership Section -->
        @canany(['view applicants', 'view members', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.1s">

            <div class="flex justify-center items-center mb-4 md:mb-6">
                <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 0 014 0z"/>
                    </svg>
                    Membership
                </h3>
            </div>
            
            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                <!-- Add Applicant -->
                <div class="group sidebar-item animate" style="animation-delay: 0.15s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-emerald-500/20 dark:bg-emerald-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-emerald-500/30 dark:group-hover:bg-emerald-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-emerald-300 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">Add Applicant</span>
                        </div>
                    </a>
                </div>

                <!-- Add Member -->
                <div class="group sidebar-item animate" style="animation-delay: 0.2s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500/20 dark:bg-blue-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-blue-500/30 dark:group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">
                                Add<span class="block md:hidden"></span><span class="hidden md:inline"> </span>Member
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Assess Applicants -->
                <div class="group sidebar-item animate" style="animation-delay: 0.25s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-amber-500/20 dark:bg-amber-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-amber-500/30 dark:group-hover:bg-amber-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-amber-300 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">Assess Applicants</span>
                        </div>
                    </a>
                </div>

                <!-- Renew Members -->
                <div class="group sidebar-item animate" style="animation-delay: 0.3s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-purple-500/20 dark:bg-purple-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-purple-500/30 dark:group-hover:bg-purple-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-purple-300 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">Renew Members</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endcanany

        <!-- Website Content Section -->
        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.35s">

            <div class="flex justify-center items-center mb-4 md:mb-6">
                <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 3a9 9 0 100 18 9 9 0 000-18zm0 0c3.866 0 7 4.03 7 9s-3.134 9-7 9-7-4.03-7-9 3.134-9 7-9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3.6 9h16.8M3.6 15h16.8" />
                    </svg>
                    Website Content
                </h3>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                @can('view event-announcements')
                <div class="group sidebar-item animate" style="animation-delay: 0.4s">
                    <a href="{{ route('event-announcements.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 dark:bg-red-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-red-500/30 dark:group-hover:bg-red-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-red-300 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Event</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view articles')
                <div class="group sidebar-item animate" style="animation-delay: 0.45s">
                    <a href="{{ route('articles.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-green-500/20 dark:bg-green-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-green-500/30 dark:group-hover:bg-green-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-green-300 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h6l2 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 3v4M13 3h-2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Article</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view markees')
                <div class="group sidebar-item animate" style="animation-delay: 0.5s">
                    <a href="{{ route('markees.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-pink-500/20 dark:bg-pink-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-pink-500/30 dark:group-hover:bg-pink-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-pink-300 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v16M19 7l-7 4-7-4V3l7 4 7-4v4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Markee</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view faqs')
                <div class="group sidebar-item animate" style="animation-delay: 0.55s">
                    <a href="{{ route('faqs.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-yellow-500/20 dark:bg-yellow-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-yellow-500/30 dark:group-hover:bg-yellow-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-yellow-300 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.257 11.238a4 4 0 116.486 3.122M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New FAQ</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view communities')
                <div class="group sidebar-item animate" style="animation-delay: 0.6s">
                    <a href="{{ route('communities.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500/20 dark:bg-blue-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-blue-500/30 dark:group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Community</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view supporters')
                <div class="group sidebar-item animate" style="animation-delay: 0.65s">
                    <a href="{{ route('supporters.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-teal-500/20 dark:bg-teal-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-teal-500/30 dark:group-hover:bg-teal-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-teal-300 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.382 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">
                                New<span class="block md:hidden"></span><span class="hidden md:inline"> </span>Supporters
                            </span>
                        </div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- User Management Section -->
        @canany(['view bureaus', 'view sections', 'view users', 'view roles', 'view permissions'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.7s">

            <div class="flex items-center mb-4 md:mb-6">
                <div class="relative"></div>
                <div class="ml-4">
                    <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-3 text-[#5E6FFB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                        User Management
                    </h3>
                </div>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                @can('view bureaus')
                <div class="group sidebar-item animate" style="animation-delay: 0.75s">
                    <a href="{{ route('bureaus.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-orange-500/20 dark:bg-orange-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-orange-500/30 dark:group-hover:bg-orange-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-orange-300 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M4 21V5a1 1 0 011-1h14a1 1 0 011 1v16M9 21V9h6v12"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Bureau</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view sections')
                <div class="group sidebar-item animate" style="animation-delay: 0.8s">
                    <a href="{{ route('sections.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-cyan-500/20 dark:bg-cyan-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-cyan-500/30 dark:group-hover:bg-cyan-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-cyan-300 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h4V8H3z M9 14v7h4v-11H9z M15 10v11h4V10h-4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Section</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view users')
                <div class="group sidebar-item animate" style="animation-delay: 0.85s">
                    <a href="{{ route('users.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-lime-500/20 dark:bg-lime-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-lime-500/30 dark:group-hover:bg-lime-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-lime-300 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM21 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New User</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view roles')
                <div class="group sidebar-item animate" style="animation-delay: 0.9s">
                    <a href="{{ route('roles.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-rose-500/20 dark:bg-rose-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-rose-500/30 dark:group-hover:bg-rose-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-rose-300 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 3l9 4-9 4-9-4 9-4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Role</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view permissions')
                <div class="group sidebar-item animate" style="animation-delay: 0.95s">
                    <a href="{{ route('permissions.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-violet-500/20 dark:bg-violet-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-violet-500/30 dark:group-hover:bg-violet-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-violet-300 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Permission</span>
                        </div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
        @endcanany
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-3 text-center">
        <div class="text-xs text-gray-400 dark:text-gray-500 mb-1">System Version: BETA</div>
        <div class="text-xs text-gray-400 dark:text-gray-500">Last Updated: {{ now()->format('M d, Y') }}</div>
    </div>
</aside>

<style>
.action-card {
    position: relative;
    overflow: hidden;
}
.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
}
.action-card:hover::before {
    left: 100%;
}
.action-card:active {
    transform: scale(0.98) !important;
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-2px); }
}
.group:hover .action-card {
    animation: float 2s ease-in-out infinite;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.sidebar-item.animate {
    opacity: 0;
    animation: slideInLeft 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

@media (max-width: 768px) {
    .right-sidebar-shadow {
        box-shadow: -4px 0 10px rgba(0, 0, 0, 0.2);
    }
}

@media (max-width: 640px) {
    .scrollbar-left::-webkit-scrollbar {
        width: 4px;
    }
}
</style>
@endcan