@can('view admin dashboard')
<!-- Right Sidebar -->
<aside 
    x-show="rightSidebarOpen"
    @click.away="rightSidebarOpen = false"
    class="fixed inset-y-0 right-0 z-40 w-72 flex flex-col bg-[#101966] dark:bg-gray-900 right-sidebar-shadow"
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
        <h2 class="text-lg font-semibold text-white dark:text-gray-200 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#5E6FFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Quick Actions
        </h2>
        <button @click="rightSidebarOpen = false" class="p-1 rounded-md hover:bg-white/10 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-gray-200 absolute right-4">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto scrollbar-left p-4 space-y-4">

        <!-- Membership Section -->
        @canany(['view applicants', 'view members', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-[#393E85]/70 dark:bg-gray-800 rounded-lg p-3">
            <h3 class="text-sm font-medium text-white dark:text-gray-200 mb-2 flex items-center">
                <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/50/FFFFFF/add-user-group-man-man.png" 
                     class="w-4 h-4 mr-2" alt="membership">
                Membership
            </h3>
            <div class="grid grid-cols-2 gap-2">
                @can('view applicants')
<<<<<<< HEAD
                <a href="{{ route('applicants.showApplicantCreateForm') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Applicant">
=======
                <a href="{{ route('applicants.showApplicantCreateForm') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Applicant">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Applicant
                </a>
                @endcan
                @can('create members')
<<<<<<< HEAD
                <a href="{{ route('members.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Member">
=======
                <a href="{{ route('members.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Member">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Member
                </a>
                @endcan
                @can('view applicants')
<<<<<<< HEAD
                <a href="{{ route('applicants.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="Assess Applicants">
=======
                <a href="{{ route('applicants.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="Assess Applicants">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    Assess Applicants
                </a>
                @endcan
                @can('renew members')
<<<<<<< HEAD
                <a href="{{ route('members.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="Renew Members">
=======
                <a href="{{ route('members.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="Renew Members">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    Renew Members
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Website Content Section -->
        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
<<<<<<< HEAD
        <div class="bg-[#1A25A1] rounded-lg p-3">
            <h3 class="text-sm font-medium text-white mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
=======
        <div class="bg-[#393E85]/70 dark:bg-gray-800 rounded-lg p-3">
            <h3 class="text-sm font-medium text-white dark:text-gray-200 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                </svg>
                Website Content
            </h3>
            <div class="grid grid-cols-2 gap-2">
                @can('view event-announcements')
<<<<<<< HEAD
                <a href="{{ route('event-announcements.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Event">
=======
                <a href="{{ route('event-announcements.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Event">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Event
                </a>
                @endcan
                @can('view articles')
<<<<<<< HEAD
                <a href="{{ route('articles.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Article">
=======
                <a href="{{ route('articles.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Article">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Article
                </a>
                @endcan
                @can('view communities')
<<<<<<< HEAD
                <a href="{{ route('communities.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Community">
=======
                <a href="{{ route('communities.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Community">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Community
                </a>
                @endcan
                @can('view faqs')
<<<<<<< HEAD
                <a href="{{ route('faqs.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New FAQ">
=======
                <a href="{{ route('faqs.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New FAQ">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New FAQ
                </a>
                @endcan
                @can('view markees')
<<<<<<< HEAD
                <a href="{{ route('markees.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Markee">
=======
                <a href="{{ route('markees.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Markee">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Markee
                </a>
                @endcan
                @can('view main-carousels')
<<<<<<< HEAD
                <a href="{{ route('main-carousels.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Carousel">
=======
                <a href="{{ route('main-carousels.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Carousel">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Carousel
                </a>
                @endcan
                @can('view supporters')
<<<<<<< HEAD
                <a href="{{ route('supporters.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Supporter">
=======
                <a href="{{ route('supporters.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Supporter">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Supporter
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Maintenance Section -->
        @canany(['view bureaus', 'view sections', 'view users', 'view roles', 'view permissions'])
<<<<<<< HEAD
        <div class="bg-[#1A25A1] rounded-lg p-3">
            <h3 class="text-sm font-medium text-white mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
=======
        <div class="bg-[#393E85]/70 dark:bg-gray-800 rounded-lg p-3">
            <h3 class="text-sm font-medium text-white dark:text-gray-200 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                </svg>
                Maintenance
            </h3>
            <div class="grid grid-cols-2 gap-2">
                @can('view bureaus')
<<<<<<< HEAD
                <a href="{{ route('bureaus.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Bureau">
=======
                <a href="{{ route('bureaus.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Bureau">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Bureau
                </a>
                @endcan
                @can('view sections')
<<<<<<< HEAD
                <a href="{{ route('sections.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Section">
=======
                <a href="{{ route('sections.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Section">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Section
                </a>
                @endcan
                @can('view users')
<<<<<<< HEAD
                <a href="{{ route('users.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New User">
=======
                <a href="{{ route('users.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New User">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New User
                </a>
                @endcan
                @can('view roles')
<<<<<<< HEAD
                <a href="{{ route('roles.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Role">
=======
                <a href="{{ route('roles.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Role">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Role
                </a>
                @endcan
                @can('view permissions')
<<<<<<< HEAD
                <a href="{{ route('permissions.index') }}" class="p-2 text-xs text-center rounded-md bg-[#101966] text-white hover:bg-[#5E6FFB] transition-colors duration-150">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" class="w-5 h-5 mx-auto mb-1" alt="New Permission">
=======
                <a href="{{ route('permissions.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] dark:bg-gray-700 text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Permission">
>>>>>>> bf3eee08bd08215d294aab7c8cd1bfb689e93034
                    New Permission
                </a>
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
@endcan
