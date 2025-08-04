@can('view admin dashboard')
<!-- Right Sidebar -->
<aside 
    x-show="rightSidebarOpen || $screen('xl')"
    @click.away="if ($screen('sm')) rightSidebarOpen = false"
    class="fixed inset-y-0 right-0 z-40 w-72 flex flex-col bg-[#101966] right-sidebar-shadow"
    style="margin-top: 4rem; height: calc(100vh - 4rem);"
    x-transition:enter="transform transition-all duration-300 ease-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transform transition-all duration-300 ease-in"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
>
    <!-- Sidebar Header -->
    <div class="px-4 py-3 flex items-center justify-center relative">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#5E6FFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Quick Actions
        </h2>
        <button @click="rightSidebarOpen = false" class="p-1 rounded-md hover:bg-white/10 text-gray-300 hover:text-white absolute right-4">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto scrollbar-left p-4 space-y-4">

        <!-- Membership Section -->
        @canany(['view applicants', 'view members', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-[#1A25A1] rounded-lg p-3">
            <h3 class="text-sm font-medium text-white mb-2 flex items-center">
                <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/50/FFFFFF/add-user-group-man-man.png" 
                    class="w-4 h-4 mr-2" alt="membership">
                Membership
            </h3>

            <div class="grid grid-cols-2 gap-2">
                @can('view applicants')
                <a href="{{ route('applicants.showApplicantCreateForm') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Applicant">
                    New Applicant
                </a>
                @endcan

                @can('create members')
                <a href="{{ route('members.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Member">
                    New Member
                </a>
                @endcan

                @can('view applicants')
                <a href="{{ route('applicants.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="Assess Applicants">
                    Assess Applicants
                </a>
                @endcan

                @can('renew members')
                <a href="{{ route('members.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="Renew Members">
                    Renew Members
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Website Content Section -->
        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-[#1A25A1] rounded-lg p-3">
            <h3 class="text-sm font-medium text-white mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Website Content
            </h3>

            <div class="grid grid-cols-2 gap-2">
                @can('view event-announcements')
                <a href="{{ route('event-announcements.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Event">
                    New Event
                </a>
                @endcan

                @can('view articles')
                <a href="{{ route('articles.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Article">
                    New Article
                </a>
                @endcan

                @can('view communities')
                <a href="{{ route('communities.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Community">
                    New Community
                </a>
                @endcan

                @can('view faqs')
                <a href="{{ route('faqs.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New FAQ">
                    New FAQ
                </a>
                @endcan

                @can('view markees')
                <a href="{{ route('markees.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Markee">
                    New Markee
                </a>
                @endcan

                @can('view main-carousels')
                <a href="{{ route('main-carousels.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Carousel">
                    New Carousel
                </a>
                @endcan

                @can('view supporters')
                <a href="{{ route('supporters.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Supporter">
                    New Supporter
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Maintenance Section -->
        @canany(['view bureaus', 'view sections', 'view users', 'view roles', 'view permissions'])
        <div class="bg-[#1A25A1] rounded-lg p-3">
            <h3 class="text-sm font-medium text-white mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Maintenance
            </h3>

            <div class="grid grid-cols-2 gap-2">
                @can('view bureaus')
                <a href="{{ route('bureaus.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Bureau">
                    New Bureau
                </a>
                @endcan

                @can('view sections')
                <a href="{{ route('sections.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Section">
                    New Section
                </a>
                @endcan

                @can('view users')
                <a href="{{ route('users.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New User">
                    New User
                </a>
                @endcan

                @can('view roles')
                <a href="{{ route('roles.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Role">
                    New Role
                </a>
                @endcan

                @can('view permissions')
                <a href="{{ route('permissions.index') }}" 
                class="p-2 text-xs text-center rounded-md bg-[#101966] text-white 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95">
                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" 
                        class="w-5 h-5 mx-auto mb-1 transition-transform duration-300" 
                        alt="New Permission">
                    New Permission
                </a>
                @endcan
            </div>
        </div>
        @endcanany
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-3 text-center">
        <div class="text-xs text-gray-400 mb-1">System Version: BETA</div>
        <div class="text-xs text-gray-400">Last Updated: {{ now()->format('M d, Y') }}</div>
    </div>
</aside>
@endcan