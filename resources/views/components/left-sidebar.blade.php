@can('view admin dashboard')
<!-- Left Sidebar -->
<aside 
    x-show="sidebarOpen || $screen('md')"
    @click.away="if ($screen('sm')) sidebarOpen = false"
    class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-[#101966] left-sidebar-shadow"
    style="margin-top: 4rem; height: calc(100vh - 4rem);"
    x-data="{ 
        openDropdown: null,
        isDropdownOpen(name) { return this.openDropdown === name },
        toggleDropdown(name) { this.openDropdown = this.openDropdown === name ? null : name }
    }"
    x-transition:enter="transform transition-transform duration-300 ease-out"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition-transform duration-300 ease-in"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    x-cloak
>
    <!-- Sidebar Content -->
    <div class="flex-1 flex flex-col overflow-y-auto scrollbar-left pt-4 pb-4">
        <!-- User Profile Section -->
        <div class="px-4 py-3 flex items-center space-x-3">
            <div class="relative">
                <img class="h-10 w-10 rounded-full bg-[#5E6FFB] p-1" src="https://ui-avatars.com/api/?name=Admin&background=5E6FFB&color=fff" alt="Admin">
                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-[#101966]"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">Administrator</p>
                <p class="text-xs text-white truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 space-y-1 mt-4">
            <!-- Dashboard -->
            @can('view admin dashboard')
            <a 
                href="{{ route('dashboard') }}" 
                :active="request()->routeIs('dashboard')" 
                class="flex items-center px-3 py-3 text-sm font-medium rounded-md text-white 
                    hover:bg-[#5E6FFB] 
                    transition-transform duration-300 
                    hover:scale-105 active:scale-95"
            >
                <img 
                    src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/50/FFFFFF/external-dashboard-user-interface-kmg-design-glyph-kmg-design.png" 
                    alt="dashboard"
                    class="w-5 h-5 object-contain mr-2 transition-transform duration-300"
                >
                <span class="flex-1 text-left transition-transform duration-300">
                    {{ __('Dashboard') }}
                </span>
            </a>
            @endcan

            <!-- User Management Dropdown -->
            @canany(['view users', 'view roles', 'view permissions'])
            <div>
                <button 
                    @click="toggleDropdown('userManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg 
                        class="w-5 h-5 mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('User Management') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('userManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Content -->
                <div x-show="isDropdownOpen('userManagement')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2">
         
                    @can('view users')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"  class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/conference-call.png"  class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                            <span>{{ __('Users') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view roles')
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')"  class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/connected-people.png"  class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                            <span>{{ __('Roles') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view permissions')
                        <x-nav-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')"  class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/restriction-shield.png"  class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                            <span>{{ __('Permissions') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Website Management Dropdown -->
            @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters', 'view markees'])
            <div>
                <button 
                    @click="toggleDropdown('websiteManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Website Management') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('websiteManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isDropdownOpen('websiteManagement')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    @can('view main carousels')
                        <x-nav-link :href="route('main-carousels.index')" :active="request()->routeIs('main-carousels.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/image-file.png" class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                            <span>{{ __('Main Carousels') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view markees')
                        <x-nav-link :href="route('markees.index')" :active="request()->routeIs('markees.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/old-shop.png" class="w-4 h-4 mr-2 object-contain" alt="Markee">
                            <span>{{ __('Markee on the Air') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view articles')
                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/external-glyph-design-circle/66/FFFFFF/external-News-journalism-solid-design-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Articles">
                            <span>{{ __('Articles') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view event announcements')
                        <x-nav-link :href="route('event-announcements.index')" :active="request()->routeIs('event-announcements.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/event-accepted.png" class="w-4 h-4 mr-2 object-contain" alt="Events">
                            <span>{{ __('Event Announcements') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view communities')
                        <x-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/fluency-systems-filled/50/FFFFFF/conference-call.png" class="w-4 h-4 mr-2 object-contain" alt="Communities">
                            <span>{{ __('Communities') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view supporters')
                        <x-nav-link :href="route('supporters.index')" :active="request()->routeIs('supporters.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/collaborating-in-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Supporters">
                            <span>{{ __('Supporters') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view faqs')
                        <x-nav-link :href="route('faqs.index')" :active="request()->routeIs('faqs.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/16/FFFFFF/help.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                            <span>{{ __('FAQs') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Member Management Dropdown -->
            @canany(['view membership types', 'view bureaus', 'view sections', 'view applicants', 'view members', 'view licenses', 'view renewals', 'view payments'])
            <div>
                <button 
                    @click="toggleDropdown('memberManagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 mr-3 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Member Management') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('memberManagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isDropdownOpen('memberManagement')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    @can('view membership types')
                        <x-nav-link :href="route('membership-types.index')" :active="request()->routeIs('membership-types.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/membership-card.png" class="w-4 h-4 mr-2 object-contain" alt="membership_types">
                            <span>{{ __('Membership Types') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view bureaus')
                        <x-nav-link :href="route('bureaus.index')" :active="request()->routeIs('bureaus.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/department.png" class="w-4 h-4 mr-2 object-contain" alt="Markee">
                            <span>{{ __('Bureaus') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view sections')
                        <x-nav-link :href="route('sections.index')" :active="request()->routeIs('sections.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-pie-graph-chart-isolated-on-white-right-now-business-bold-tal-revivo.png" class="w-4 h-4 mr-2 object-contain" alt="Articles">
                            <span>{{ __('Sections') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view applicants')
                        <x-nav-link :href="route('applicants.index')" :active="request()->routeIs('applicants.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/material-rounded/24/FFFFFF/parse-resume.png"  class="w-4 h-4 mr-2 object-contain" alt="Events">
                            <span>{{ __('Applicants') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view members')
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/groups.png" class="w-4 h-4 mr-2 object-contain" alt="Communities">
                            <span>{{ __('Members') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view licenses')
                        <x-nav-link :href="route('licenses.index')" :active="request()->routeIs('licenses.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/material-rounded/24/FFFFFF/security-checked.png"  class="w-4 h-4 mr-2 object-contain" alt="Supporters">
                            <span>{{ __('Licenses') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view renewals')
                        <x-nav-link :href="route('renew.index')" :active="request()->routeIs('renew.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/restart.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                            <span>{{ __('Renewal Request') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view payments')
                        <x-nav-link :href="route('cashier.index')" :active="request()->routeIs('cashier.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/checkout.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                            <span>{{ __('Cashier') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view reports')
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/graph-report.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                            <span>{{ __('Reports') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Member Engagement Dropdown -->
            @canany(['view events', 'view announcements', 'view surveys'])
            <div>
                <button 
                    @click="toggleDropdown('memberEngagement')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Member Engagement') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('memberEngagement')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isDropdownOpen('memberEngagement')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    @can('view events')
                        <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/event-accepted.png" 
                                alt="Events" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Events & Activities') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view announcements')
                        <x-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/speaker_1.png" 
                                alt="Announcements" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Announcements') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view surveys')
                        <x-nav-link :href="route('surveys.index')" :active="request()->routeIs('surveys.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/customer-survey.png" 
                                alt="Surveys" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Surveys') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Assessments Dropdown -->
            @canany(['view quizzes', 'view certificates', 'view reviewers'])
            <div>
                <button 
                    @click="toggleDropdown('assessments')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Assessments') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('assessments')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>


                <div 
                    x-show="isDropdownOpen('assessments')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    @can('view quizzes')
                        <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/test.png" 
                                alt="Examination" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Examination') }}</span>
                        </x-nav-link>
                    @endcan
                    @can('view certificates')
                        <x-nav-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/certificate.png" 
                                alt="Certificates" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Certificates') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Integrations Dropdown -->
            @canany(['view emails', 'view documents'])
            <div>
                <button 
                    @click="toggleDropdown('integrations')" 
                    class="w-full flex items-center justify-start px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>

                    <!-- Label -->
                    <span class="flex-1 text-left transition-transform duration-300">
                        {{ __('Integrations') }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-1 h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('integrations')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isDropdownOpen('integrations')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    @can('view emails')
                        <x-nav-link :href="route('emails.index')" :active="request()->routeIs('emails.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-category-emails-bundle-email-bold-tal-revivo.png" 
                                alt="Emails" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Emails') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view documents')
                        <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img src="https://img.icons8.com/ios-filled/50/FFFFFF/documents.png" 
                                alt="Documents" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Documents') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Profile Section -->
            <div>
                <button 
                    @click="toggleDropdown('profile')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white 
                        hover:bg-[#5E6FFB] focus:outline-none 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Profile Icon -->
                    <svg class="w-5 h-5 object-contain mr-3 transition-transform duration-300" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <!-- Profile Name -->
                    <span class="transition-transform duration-300">
                        {{ Auth::user()->first_name }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg 
                        class="ml-auto h-4 w-4 transform transition-transform duration-300" 
                        :class="{'rotate-180': isDropdownOpen('profile')}" 
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="isDropdownOpen('profile')"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-6 pl-4 border-l-2 border-[#5E6FFB] space-y-2"
                >
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img src="https://img.icons8.com/material/50/FFFFFF/user-male-circle--v1.png" 
                            alt="Profile" class="w-4 h-4 mr-2 object-contain">
                        <span>{{ __('Profile') }}</span>
                    </x-nav-link>
                </div>
            </div>
        </nav>

        <!-- Bottom Section -->
        <div class="px-4 py-3">
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit"
                    class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-white 
                        bg-[#1A25A1] rounded-md 
                        hover:bg-[#5E6FFB] 
                        transition-transform duration-300 
                        hover:scale-105 active:scale-95"
                >
                    <!-- Icon -->
                    <svg class="mr-2 h-4 w-4 transition-transform duration-300" 
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>

                    <!-- Label -->
                    <span class="transition-transform duration-300">
                        {{ __('Log Out') }}
                    </span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endcan