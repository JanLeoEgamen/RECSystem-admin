<style>
    [x-cloak] { display: none !important; }

    .dropdown-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-12px);
        transition:
            max-height 0.6s ease,
            opacity 0.5s ease,
            transform 0.5s ease;
    }

    .dropdown-content.open {
        max-height: 1000px;
        opacity: 1;
        transform: translateY(0);
    }

    /* Animation for sidebar items - only when needed */
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

    /* Staggered animation delays */
    .sidebar-item.animate:nth-child(1) { animation-delay: 0.1s; }
    .sidebar-item.animate:nth-child(2) { animation-delay: 0.15s; }
    .sidebar-item.animate:nth-child(3) { animation-delay: 0.2s; }
    .sidebar-item.animate:nth-child(4) { animation-delay: 0.25s; }
    .sidebar-item.animate:nth-child(5) { animation-delay: 0.3s; }
    .sidebar-item.animate:nth-child(6) { animation-delay: 0.35s; }
    .sidebar-item.animate:nth-child(7) { animation-delay: 0.4s; }
    .sidebar-item.animate:nth-child(8) { animation-delay: 0.45s; }
    .sidebar-item.animate:nth-child(9) { animation-delay: 0.5s; }
    .sidebar-item.animate:nth-child(10) { animation-delay: 0.55s; }
    .sidebar-item.animate:nth-child(11) { animation-delay: 0.6s; }
    .sidebar-item.animate:nth-child(12) { animation-delay: 0.65s; }
    .sidebar-item.animate:nth-child(13) { animation-delay: 0.7s; }
    .sidebar-item.animate:nth-child(14) { animation-delay: 0.75s; }
    .sidebar-item.animate:nth-child(15) { animation-delay: 0.8s; }
    .sidebar-item.animate:nth-child(n+16) { animation-delay: 0.85s; }
</style>

@canany(['view admin dashboard', 'view applicant dashboard'])

@php
    $shouldAnimate = !session()->has('sidebar_animation_shown') || request()->has('from_menu');
    
    if ($shouldAnimate && !session()->has('sidebar_animation_shown')) {
        session()->put('sidebar_animation_shown', true);
    }
@endphp

<aside 
    x-show="sidebarOpen"
    class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-[#101966] dark:bg-gray-900 left-sidebar-shadow"
    style="margin-top: 4rem; height: calc(100vh - 4rem);"
    x-data="{ 
    openDropdown: '{{ 
        request()->routeIs(
            'users.index', 'roles.index', 'permissions.index',
            'main-carousels.index', 'markees.index', 'articles.index',
            'event-announcements.index', 'communities.index', 'supporters.index', 'faqs.index',
            'membership-types.index', 'bureaus.index', 'sections.index', 'applicants.index', 'student-applicants.index',
            'reports.index', 'members.index', 'licenses.index', 'renew.index', 'cashier.index', 'payment-methods.index',
            'events.index', 'announcements.index', 'surveys.index',
            'quizzes.index', 'certificates.index',
            'emails.index', 'documents.index', 'activity-logs.index', 'login-logs.index',
            'manual.index','manual.view', 'profile.edit', 'backups.index'
        ) 
            ? (
                request()->routeIs('users.index', 'roles.index', 'permissions.index') 
                    ? 'userManagement' 
                    : (
                        request()->routeIs('main-carousels.index', 'markees.index', 'articles.index',
                                        'event-announcements.index', 'communities.index',
                                        'supporters.index', 'faqs.index') 
                            ? 'websiteManagement' 
                            : (
                                request()->routeIs('events.index', 'announcements.index', 'surveys.index', 'quizzes.index', 'certificates.index', 'emails.index', 'documents.index') 
                                    ? 'memberEngagement' 
                                    : (
                                        request()->routeIs('activity-logs.index', 'login-logs.index')
                                            ? 'auditTrail'
                                            : (
                                                request()->routeIs('manual.view', 'manual.index') 
                                                    ? 'usersManual'
                                                    : (
                                                        request()->routeIs('profile.edit', 'backups.index') 
                                                            ? 'profile'
                                                            : (
                                                                request()->routeIs('cashier.index', 'payment-methods.index')
                                                                    ? 'memberManagement,billings'
                                                                    : (
                                                                        request()->routeIs('student-applicants.index')
                                                                            ? 'memberManagement,applicants'
                                                                            : 'memberManagement'
                                                                    )
                                                            )
                                                    )
                                            )            
                                    )
                            )
                    )
            ) 
            : '' 
    }}',
    isDropdownOpen(name) { 
        if (this.openDropdown.includes(',')) {
            return this.openDropdown.split(',').includes(name);
        }
        return this.openDropdown === name;
    },
    toggleDropdown(name) { 
        if (name === 'billings') {
            if (this.isDropdownOpen('billings')) {
                this.openDropdown = 'memberManagement';
            } else {
                this.openDropdown = 'memberManagement,billings';
            }
        } else if (name === 'applicants') {
            if (this.isDropdownOpen('applicants')) {
                this.openDropdown = 'memberManagement';
            } else {
                this.openDropdown = 'memberManagement,applicants';
            }
        } else if (name === 'memberManagement') {
            if (this.isDropdownOpen('memberManagement')) {
                this.openDropdown = '';
            } else {
                this.openDropdown = 'memberManagement';
            }
        } else {
            this.openDropdown = this.openDropdown === name ? '' : name;
        }
    },
    openedViaMenu: {{ request()->has('from_menu') ? 'true' : 'false' }}
}"
    x-transition:enter="transform transition-transform duration-300 ease-out"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition-transform duration-300 ease-in"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    x-cloak
>
    <div class="flex-1 flex flex-col overflow-y-auto scrollbar-left pt-4 pb-4">
        <div class="px-4 py-3 flex items-center space-x-3 sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
            <div class="relative">
                <img class="h-10 w-10 rounded-full bg-[#5E6FFB] dark:bg-indigo-700 p-1" src="https://ui-avatars.com/api/?name=Admin&background=5E6FFB&color=fff" alt="Admin">
                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-[#101966] dark:ring-gray-800"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white dark:text-gray-200 truncate">Administrator</p>
                <p class="text-xs text-white dark:text-gray-300 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <nav class="flex-1 px-2 space-y-1 mt-4">
            @can('view admin dashboard')
            <a 
                href="{{ route('dashboard') }}" 
                class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }} flex items-center px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                    hover:bg-[#5E6FFB] dark:hover:bg-gray-700
                    
                    {{ request()->routeIs('dashboard') ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}"
            >
                <img 
                    src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/50/FFFFFF/external-dashboard-user-interface-kmg-design-glyph-kmg-design.png" 
                    alt="dashboard"
                    class="w-5 h-5 object-contain mr-2"
                >
                
                <span class="flex-1 text-left">
                    {{ __('Dashboard') }}
                </span>
            </a>
            @endcan

            @php
                $userManagementActive = request()->routeIs('users.index', 'roles.index', 'permissions.index');
            @endphp
            @canany(['view users', 'view roles', 'view permissions'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                <button 
                    @click.stop="toggleDropdown('userManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md 
                        text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] transition-transform duration-300 
                        hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                        {{ $userManagementActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}"
                >
                    <svg 
                        class="w-5 h-5 mr-3" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="flex-1 text-left">
                        {{ __('User Management') }}
                    </span>
                    <svg 
                        class="ml-1 h-4 w-4" 
                        :class="{'rotate-180': isDropdownOpen('userManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div :class="{'dropdown-content open': isDropdownOpen('userManagement'), 'dropdown-content': !isDropdownOpen('userManagement')}"
                    class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                    @can('view users')
                    <x-nav-link 
                        :href="route('users.index')" 
                        :active="request()->routeIs('users.index')"  
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('users.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                        <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/conference-call.png" class="w-4 h-4 mr-2 object-contain" alt="Users">
                        <span>{{ __('Users') }}</span>
                    </x-nav-link>
                @endcan
                @can('view roles')
                    <x-nav-link 
                        :href="route('roles.index')" 
                        :active="request()->routeIs('roles.index')"  
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('roles.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                        <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/connected-people.png" class="w-4 h-4 mr-2 object-contain" alt="Roles">
                        <span>{{ __('Roles') }}</span>
                    </x-nav-link>
                @endcan
                @can('view permissions')
                    <x-nav-link 
                        :href="route('permissions.index')" 
                        :active="request()->routeIs('permissions.index')"  
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('permissions.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                        <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/restriction-shield.png" class="w-4 h-4 mr-2 object-contain" alt="Permissions">
                        <span>{{ __('Permissions') }}</span>
                    </x-nav-link>
                @endcan
                </div>
            </div>
            @endcanany

            @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters', 'view markees'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                @php
                    $websiteActive = request()->routeIs(
                        'main-carousels.index', 'markees.index', 'articles.index',
                        'event-announcements.index', 'communities.index',
                        'supporters.index', 'faqs.index'
                    );
                @endphp

                <button 
                    @click.stop="toggleDropdown('websiteManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] transition-transform duration-300 
                        hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                        {{ $websiteActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="flex-1 text-left">
                        {{ __('Website Management') }}
                    </span>
                    <svg 
                        class="ml-1 h-4 w-4" 
                        :class="{'rotate-180': isDropdownOpen('websiteManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div :class="{'dropdown-content open': isDropdownOpen('websiteManagement'), 'dropdown-content': !isDropdownOpen('websiteManagement')}"
                    class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                    @can('view main carousels')
                        <x-nav-link :href="route('main-carousels.index')" :active="request()->routeIs('main-carousels.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('main-carousels.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/image-file.png" class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                            <span>{{ __('Main Carousels') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view markees')
                        <x-nav-link :href="route('markees.index')" :active="request()->routeIs('markees.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('markees.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/old-shop.png" class="w-4 h-4 mr-2 object-contain" alt="Markee">
                            <span>{{ __('Marquee') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view articles')
                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('articles.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/external-glyph-design-circle/66/FFFFFF/external-News-journalism-solid-design-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Articles">
                            <span>{{ __('Articles') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view event announcements')
                        <x-nav-link :href="route('event-announcements.index')" :active="request()->routeIs('event-announcements.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('event-announcements.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/event-accepted.png" class="w-4 h-4 mr-2 object-contain" alt="Events">
                            <span>{{ __('Event') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view communities')
                        <x-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('communities.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/fluency-systems-filled/50/FFFFFF/conference-call.png" class="w-4 h-4 mr-2 object-contain" alt="Communities">
                            <span>{{ __('Communities') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view supporters')
                        <x-nav-link :href="route('supporters.index')" :active="request()->routeIs('supporters.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('supporters.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/collaborating-in-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Supporters">
                            <span>{{ __('Supporters') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view faqs')
                        <x-nav-link :href="route('faqs.index')" :active="request()->routeIs('faqs.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('faqs.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/16/FFFFFF/help.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                            <span>{{ __('FAQs') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            @canany(['view membership types', 'view bureau-section', 'view sections', 'view applicants', 'view members', 'view licenses', 'view renewals', 'view payments', 'view payment methods'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                @php
                    $memberEngagementActive = request()->routeIs(
                        'membership-types.index', 'bureau-section.index', 'sections.index',
                        'sections.index', 'applicants.index', 'reports.index',
                        'members.index', 'licenses.index','renew.index', 'cashier.index',
                        'payment-methods.index'
                    );
                @endphp
                <button 
                    @click.stop="toggleDropdown('memberManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] transition-transform duration-300 
                        hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                        {{ $memberEngagementActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="flex-1 text-left">
                        {{ __('Member Management') }}
                    </span>
                    <svg 
                        class="ml-1 h-4 w-4" 
                        :class="{'rotate-180': isDropdownOpen('memberManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div :class="{'dropdown-content open': isDropdownOpen('memberManagement'), 'dropdown-content': !isDropdownOpen('memberManagement')}"
                    class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                    @can('view membership types')
                        <x-nav-link :href="route('membership-types.index')" :active="request()->routeIs('membership-types.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('membership-types.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }} 
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/membership-card.png" class="w-4 h-4 mr-2 object-contain" alt="membership_types">
                            <span>{{ __('Membership Types') }}</span>
                        </x-nav-link>
                    @endcan
                    <!-- @can('view bureau-section')
                        <x-nav-link :href="route('bureau-section.index')" :active="request()->routeIs('bureau-section.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-gray-200 hover:bg-[#5E6FFB] dark:hover:bg-indigo-700 {{ request()->routeIs('bureau-section.index') ? 'bg-[#4C5091] text-white' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/department.png" class="w-4 h-4 mr-2 object-contain" alt="Markee">
                            <span>{{ __('Bureaus & Sections') }}</span>
                        </x-nav-link>
                    @endcan -->

                    @can('view bureaus')
                        <x-nav-link :href="route('bureaus.index')" :active="request()->routeIs('bureaus.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('bureaus.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/department.png" class="w-4 h-4 mr-2 object-contain, alt="Markee">
                            <span>{{ __('Bureaus') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view sections')
                        <x-nav-link :href="route('sections.index')" :active="request()->routeIs('sections.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('sections.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-pie-graph-chart-isolated-on-white-right-now-business-bold-tal-revivo.png" class="w-4 h-4 mr-2 object-contain, alt="Articles">
                            <span>{{ __('Sections') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view applicants')
                        <div class="relative">
                            <button 
                                @click.stop="toggleDropdown('applicants')" 
                                class="w-full flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 
                                {{ request()->routeIs('applicants.index', 'student-applicants.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/material-rounded/24/FFFFFF/parse-resume.png" class="w-4 h-4 mr-2 object-contain" alt="Applicants">
                                <span class="flex-1 text-left">{{ __('Applicants') }}</span>
                                <svg 
                                    class="ml-1 h-3 w-3" 
                                    :class="{'rotate-180': isDropdownOpen('applicants')}" 
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" 
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div :class="{'dropdown-content open': isDropdownOpen('applicants'), 'dropdown-content': !isDropdownOpen('applicants')}"
                                class="ml-6 mt-1 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-1">
                                <x-nav-link :href="route('applicants.index')" :active="request()->routeIs('applicants.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-400 dark:text-gray-200 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('applicants.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                    <img src="https://img.icons8.com/material-rounded/24/FFFFFF/parse-resume.png" class="w-4 h-4 mr-2 object-contain" alt="General Applicants">
                                    <span>{{ __('Total Applicants') }}</span>
                                </x-nav-link>

                                @can('view student applicants')
                                <x-nav-link :href="route('student-applicants.index')" :active="request()->routeIs('student-applicants.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-400 dark:text-gray-200 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('student-applicants.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                    <img src="https://img.icons8.com/material-rounded/24/FFFFFF/student-male.png" class="w-4 h-4 mr-2 object-contain" alt="Student Applicants">
                                    <span>{{ __('Student Applicants') }}</span>
                                </x-nav-link>
                                @endcan
                            </div>
                        </div>
                    @endcan
                    @can('view members')
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('members.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/groups.png" class="w-4 h-4 mr-2 object-contain, alt="Communities">
                            <span>{{ __('Members') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view licenses')
                        <x-nav-link :href="route('licenses.index')" :active="request()->routeIs('licenses.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('licenses.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/material-rounded/24/FFFFFF/security-checked.png"  class="w-4 h-4 mr-2 object-contain, alt="Supporters">
                            <span>{{ __('Licenses') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view renewals')
                        <x-nav-link :href="route('renew.index')" :active="request()->routeIs('renew.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('renew.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/restart.png" class="w-4 h-4 mr-2 object-contain, alt="FAQs">
                            <span>{{ __('Renewal Request') }}</span>
                        </x-nav-link>
                    @endcan

                    <!-- Billings Section with Sublayer -->
                    @can('view payments')
                        @can('view payment methods')
                        <div class="relative">
                            <button 
                                @click.stop="toggleDropdown('billings')" 
                                class="w-full flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 
                                {{ request()->routeIs('cashier.index', 'payment-methods.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/checkout.png" class="w-4 h-4 mr-2 object-contain" alt="Billings">
                                <span class="flex-1 text-left">{{ __('Billings') }}</span>
                                <svg 
                                    class="ml-1 h-3 w-3" 
                                    :class="{'rotate-180': isDropdownOpen('billings')}" 
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" 
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div :class="{'dropdown-content open': isDropdownOpen('billings'), 'dropdown-content': !isDropdownOpen('billings')}"
                                class="ml-6 mt-1 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-1">
                                @can('view payments')
                                <x-nav-link :href="route('cashier.index')" :active="request()->routeIs('cashier.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-400 dark:text-gray-200 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('cashier.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                    <img src="https://img.icons8.com/?size=100&id=WxLJjqwqRFj2&format=png&color=FFFFFF" class="w-4 h-4 mr-2 object-contain" alt="Cashier">
                                    <span>{{ __('Cashier') }}</span>
                                </x-nav-link>
                                @endcan

                                @can('view payment methods')
                                <x-nav-link :href="route('payment-methods.index')" :active="request()->routeIs('payment-methods.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-400 dark:text-gray-200 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('payment-methods.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                    <img src="https://img.icons8.com/?size=100&id=8294&format=png&color=FFFFFF" class="w-4 h-4 mr-2 object-contain" alt="Payment Methods">
                                    <span>{{ __('Payment Methods') }}</span>
                                </x-nav-link>
                                @endcan
                            </div>
                        </div>
                        @endcan
                    @endcan

                    @can('view reports')
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('reports.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/graph-report.png" class="w-4 h-4 mr-2 object-contain, alt="FAQs">
                            <span>{{ __('Reports') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany
            
            @canany(['view events', 'view announcements', 'view surveys', 'view quizzes', 'view certificates', 'view emails', 'view documents'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">  
                @php
                    $memberEngagementActive = request()->routeIs('events.index', 'announcements.index', 'surveys.index', 'quizzes.index', 'certificates.index', 'emails.index', 'documents.index');
                @endphp
            <button 
                @click.stop="toggleDropdown('memberEngagement')" 
                class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                    hover:bg-[#5E6FFB] transition-transform duration-300 
                        hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                    {{ $memberEngagementActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">
                
                <img src="https://img.icons8.com/ios-filled/50/FFFFFF/macbook-chat--v2.png" 
                    alt="Engagement Icon" class="w-5 h-5 object-contain mr-3" />
                
                <span class="flex-1 text-left">
                    {{ __('Member Engagement') }}
                </span>

                <svg 
                    class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('memberEngagement')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" 
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                        clip-rule="evenodd" />
                </svg>
            </button>
                <div :class="{'dropdown-content open': isDropdownOpen('memberEngagement'), 'dropdown-content': !isDropdownOpen('memberEngagement')}"
                    class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                    @can('view events')
                        <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('events.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                            transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/event-accepted.png" 
                                alt="Events" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Events & Activities') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view announcements')
                        <x-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('announcements.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                            transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/speaker_1.png" 
                                alt="Announcements" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Announcements') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view surveys')
                        <x-nav-link :href="route('surveys.index')" :active="request()->routeIs('surveys.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('surveys.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                            transition-transform duration-300 hover:scale-105 active:scale-95">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/customer-survey.png" 
                                alt="Surveys" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Surveys') }}</span>
                        </x-nav-link>
                    @endcan

                    <!-- Assessments Section -->
                    @canany(['view quizzes', 'view certificates'])
                        @can('view quizzes')
                            <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('quizzes.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/ios-filled/50/FFFFFF/test.png" 
                                    alt="Examination" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Examination') }}</span>
                            </x-nav-link>
                        @endcan
                        @can('view certificates')
                            <x-nav-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('certificates.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/certificate.png" 
                                    alt="Certificates" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Certificates') }}</span>
                            </x-nav-link>
                        @endcan
                    @endcanany

                    <!-- Integrations Section -->
                    @canany(['view emails', 'view documents'])
                        @can('view emails')
                            <x-nav-link :href="route('emails.index')" :active="request()->routeIs('emails.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('emails.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-category-emails-bundle-email-bold-tal-revivo.png" 
                                    alt="Emails" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Emails') }}</span>
                            </x-nav-link>
                        @endcan
                        @can('view documents')
                            <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('documents.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/ios-filled/50/FFFFFF/documents.png" 
                                    alt="Documents" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Documents') }}</span>
                            </x-nav-link>
                        @endcan
                    @endcanany
                </div>
            </div>
            @endcanany
                  
            @canany(['view activity log', 'view login log'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                @php
                    $auditActive = request()->routeIs('activity-logs.index', 'login-logs.index');
                @endphp  
                <button 
                    @click.stop="toggleDropdown('auditTrail')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                    hover:bg-[#5E6FFB] transition-transform duration-300 
                    hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                    {{ $auditActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">

                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                         d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Audit Trail') }}
                    </span>

                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('auditTrail')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                        clip-rule="evenodd" />
                    </svg>
                    </button>

                     <div :class="{'dropdown-content open': isDropdownOpen('auditTrail'), 'dropdown-content': !isDropdownOpen('auditTrail')}"
                          class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                        @can('view activity log')
                            <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 hover:text-white hover:bg-[#5E6FFB] {{ request()->routeIs('activity-logs.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/ios-filled/50/FFFFFF/goodnotes.png" 
                                alt="Documents" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Activity Logs') }}</span>
                            </x-nav-link>
                        @endcan

                        @can('view login log')
                            <x-nav-link :href="route('login-logs.index')" :active="request()->routeIs('login-logs.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 hover:text-white hover:bg-[#5E6FFB] {{ request()->routeIs('login-logs.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/48/FFFFFF/external-note-customer-reviews-tanah-basah-glyph-tanah-basah.png" 
                                alt="Documents" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('User Login Logs') }}</span>
                            </x-nav-link>
                        @endcan
                    </div>
                </div>
            @endcanany 

            @canany(['view manual'])
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                @php
                    $usersManualActive = request()->routeIs('manual.view', 'manual.index');
                @endphp  
                <button 
                    @click.stop="toggleDropdown('usersManual')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                    hover:bg-[#5E6FFB] transition-transform duration-300 
                    hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                    {{ $usersManualActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">

                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 19.5A2.5 2.5 0 016.5 17H20M4 4.5A2.5 2.5 0 016.5 7H20v14H6.5A2.5 2.5 0 014 18.5v-14z" />
                    </svg>

                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Users Manual') }}
                    </span>

                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('usersManual')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                        clip-rule="evenodd" />
                    </svg>
                    </button>

                    <div :class="{'dropdown-content open': isDropdownOpen('usersManual'), 'dropdown-content': !isDropdownOpen('usersManual')}"
                          class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                        @can('view manual')
                            <x-nav-link :href="route('manual.view')" :active="request()->routeIs('manual.view')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 hover:text-white hover:bg-[#5E6FFB] {{ request()->routeIs('manual.view') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/?size=100&id=jzjIY4jdjSwR&format=png&color=FFFFFF" 
                                alt="Documents" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Documentations') }}</span>
                            </x-nav-link>
                        @endcan

                        @can('view manual')
                            <x-nav-link :href="route('manual.index')" :active="request()->routeIs('manual.index')" 
                                class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 hover:text-white hover:bg-[#5E6FFB] {{ request()->routeIs('manual.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                                transition-transform duration-300 hover:scale-105 active:scale-95">
                                <img src="https://img.icons8.com/?size=100&id=58137&format=png&color=FFFFFF" 
                                alt="Manuals Maintenance" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Manuals Maintenance') }}</span>
                            </x-nav-link>
                        @endcan
                    </div>
                </div>
            @endcanany
        
            <div class="sidebar-item {{ $shouldAnimate ? 'animate' : '' }}">
                @php
                    $profileActive = request()->routeIs('profile.edit', 'backups.index');
                @endphp

                <button 
                    @click.stop ="toggleDropdown('profile')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white dark:text-gray-200
                        hover:bg-[#5E6FFB] transition-transform duration-300 
                        hover:scale-105 active:scale-95 dark:hover:bg-gray-700 focus:outline-none
                        {{ $profileActive ? 'bg-[#4C5091] dark:bg-gray-700' : '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/admin-settings-male.png" alt="Admin Settings Icon" class="w-5 h-5 object-contain mr-3" />
                    <span>
                        {{ Auth::user()->first_name }}
                    </span>
                    <svg 
                        class="ml-auto h-4 w-4" 
                        :class="{'rotate-180': isDropdownOpen('profile')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div :class="{'dropdown-content open': isDropdownOpen('profile'), 'dropdown-content': !isDropdownOpen('profile')}"
                    class="ml-6 mt-2 pl-4 border-l-2 border-[#5E6FFB] dark:border-gray-400 space-y-2" >
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 dark:text-gray-100 hover:text-white dark:hover:text-gray-100 hover:bg-[#5E6FFB] dark:hover:bg-gray-700 {{ request()->routeIs('profile.edit') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                        <img src="https://img.icons8.com/material/50/FFFFFF/user-male-circle--v1.png" 
                            alt="Profile" class="w-4 h-4 mr-2 object-contain">
                        <span>{{ __('Profile') }}</span>
                    </x-nav-link>
            
                    @can('view back-ups')
                    <x-nav-link :href="route('backups.index')" :active="request()->routeIs('backups.index')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-100 hover:text-white hover:bg-[#5E6FFB] {{ request()->routeIs('backups.index') ? 'bg-[#4C5091] dark:bg-gray-700 text-gray-100 text-white' : '' }}
                        transition-transform duration-300 hover:scale-105 active:scale-95">
                        <img src="https://img.icons8.com/?size=100&id=2965&format=png&color=FFFFFF" 
                        alt="System Back-Up" class="w-4 h-4 mr-2 object-contain">
                        <span>{{ __('System Back-Ups') }}</span>
                    </x-nav-link>
                    @endcan
                </div>
            </div>
        </nav>

        <div class="px-4 py-3 space-y-3">
            <div class="text-center text-sm text-white rounded-md px-3 py-1 shadow-sm">
                {{ now()->format('h:i A') }} today, {{ now()->format('d M Y') }}
            </div>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="button" {{-- change to button (not submit) --}}
                    id="logout-button"
                    class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-white 
                        bg-[#4C5091] dark:bg-indigo-800 rounded-md 
                        hover:bg-red-900 dark:hover:bg-[#F87171] transition-colors duration-300"
                >
                    <svg class="mr-2 h-4 w-4" 
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>
                        {{ __('Log Out') }}
                    </span>
                </button>
            </form>
        </div>

        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('logout-button').addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out of your account.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#5e6ffb',
                    cancelButtonColor: '#d33',
                    background: '#101966',
                    color: '#fff',
                    confirmButtonText: 'Yes, log me out',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#5e6ffb',
                            background: '#101966',
                            color: '#fff',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            document.getElementById('logout-form').submit();
                        }, 1000);
                    }
                });
            });
        </script>
    </div>
</aside>
@endcan