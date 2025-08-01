 @can('view admin dashboard')
<nav x-show="sidebarOpen || window.innerWidth > 768"
     :class="{
         'fixed md:static': true,
         'hidden md:block': !sidebarOpen && window.innerWidth <= 768,
         'w-16': !sidebarOpen && window.innerWidth > 768,
         'w-64': sidebarOpen || window.innerWidth <= 768
     }"
     @mouseenter="if(window.innerWidth > 768 && !sidebarOpen) sidebarOpen = true"
     @mouseleave="if(window.innerWidth > 768 && sidebarOpen) sidebarOpen = false"
     class="bg-[#101966] dark:bg-gray-800 text-white fixed left-0 top-20 flex flex-col"
     style="background-color: #132080; height: calc(100vh - 80px); box-shadow: 8px 0 15px -5px rgba(0, 0, 0, 0.7);"
     x-data="{
         activeDropdown: null,
         toggleDropdown(dropdownName) {
             if (window.innerWidth > 768 && !sidebarOpen) {
                 sidebarOpen = true;
             } else {
                 this.activeDropdown = this.activeDropdown === dropdownName ? null : dropdownName;
             }
         },
         isDropdownOpen(dropdownName) {
             return this.activeDropdown === dropdownName && (sidebarOpen || window.innerWidth <= 768);
         }
     }">
     
    <div class="p-4 flex flex-col items-center shrink-0" x-show="sidebarOpen || window.innerWidth <= 768">
        <div class="w-full flex items-center justify-center mb-4">
            <div class="flex items-center space-x-3">
                <span x-show="sidebarOpen" class="text-sm font-medium text-gray-300">
                    ADMINISTRATOR
                </span>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-6 space-y-6" style="scrollbar-width: thin; scrollbar-color: #5E6FFB #101966;">
        @role('Member')
            <div class="px-2 border-b border-gray-700">
                <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" 
                    class="justify-center py-3"
                    @click="if(window.innerWidth > 768 && !sidebarOpen) { sidebarOpen = true; }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen || window.innerWidth <= 768" class="ml-3">{{ __('Dashboard') }}</span>
                </x-nav-link>
            </div>
        @endrole

        @can('view admin dashboard')
            <div class="px-2">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="flex items-left py-3"
                        @click="if(window.innerWidth > 768 && !sidebarOpen) { sidebarOpen = true; }">
                    <img width="16" height="16" src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/50/FFFFFF/external-dashboard-user-interface-kmg-design-glyph-kmg-design.png" 
                        alt="dashboard">
                    <span x-show="sidebarOpen || window.innerWidth <= 768" class="ml-3">
                        {{ __('Dashboard') }}
                    </span>
                </x-nav-link>
            </div>
            <div class="flex justify-center" x-show="sidebarOpen || window.innerWidth <= 768">
                <div class="border-t border-gray-700 w-3/4"></div>
            </div>
        @endcan

        @canany(['view users', 'view roles', 'view permissions'])
        <div class="px-2">
            <button @click="toggleDropdown('userManagement')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">User Management</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('userManagement')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="isDropdownOpen('userManagement')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                @can('view users')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/sf-black-filled/64/FFFFFF/conference-call.png" alt="user" class="mr-2">
                        <span>{{ __('Users') }}</span>
                    </x-nav-link>
                @endcan
                
                @can('view roles')
                    <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/sf-black-filled/64/FFFFFF/connected-people.png" alt="roles" class="mr-2">
                        <span>{{ __('Roles') }}</span>
                    </x-nav-link>
                @endcan
                
                @can('view permissions')
                    <x-nav-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/glyph-neue/50/FFFFFF/restriction-shield.png" alt="roles" class="mr-2">
                        <span>{{ __('Permissions') }}</span>
                    </x-nav-link>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Website Management Section -->
        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters', 'view markees'])
        <div class="px-2">
            <button @click="toggleDropdown('websiteManagement')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">Website Management</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('websiteManagement')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="isDropdownOpen('websiteManagement')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">

                @can('view main carousels')
                    <x-nav-link :href="route('main-carousels.index')" :active="request()->routeIs('main-carousels.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/deco-glyph/48/FFFFFF/image-file.png" alt="main_carousel" class="mr-2">
                        <span>{{ __('Main Carousels') }}</span>
                    </x-nav-link>
                @endcan
            
                @can('view markees')
                        <x-nav-link :href="route('markees.index')" :active="request()->routeIs('markees.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-glyphs/50/FFFFFF/old-shop.png" alt="marquee" class="mr-2">
                            <span>{{ __('Markee on the Air') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view articles')
                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/external-glyph-design-circle/66/FFFFFF/external-News-journalism-solid-design-circle.png" alt="articles" class="mr-2">
                            <span>{{ __('Articles') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view event announcements')
                        <x-nav-link :href="route('event-announcements.index')" :active="request()->routeIs('event-announcements.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/event-accepted.png" alt="events" class="mr-2">
                            <span>{{ __('Event Announcements') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view communities')
                        <x-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/fluency-systems-filled/50/FFFFFF/conference-call.png" alt="communities" class="mr-2">
                            <span>{{ __('Communities') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view supporters')
                        <x-nav-link :href="route('supporters.index')" :active="request()->routeIs('supporters.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/collaborating-in-circle.png" alt="supporters" class="mr-2">
                            <span>{{ __('Supporters') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view faqs')
                        <x-nav-link :href="route('faqs.index')" :active="request()->routeIs('faqs.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/16/FFFFFF/help.png" alt="FAQs" class="mr-2">
                            <span>{{ __('FAQs') }}</span>
                        </x-nav-link>
                    @endcan
            </div>
        </div>
        @endcanany

        
        @canany(['view membership types', 'view bureaus', 'view sections', 'view applicants', 'view members', 'view licenses', 'view renewals', 'view payments'])
        <div class="px-2">
            <button @click="toggleDropdown('memberManagement')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">Member Management</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('memberManagement')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

                <div x-show="isDropdownOpen('memberManagement')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                    @can('view membership types')
                        <x-nav-link :href="route('membership-types.index')" :active="request()->routeIs('membership-types.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/glyph-neue/50/FFFFFF/membership-card.png" alt="types" class="mr-2">
                            <span>{{ __('Membership Types') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view bureaus')
                        <x-nav-link :href="route('bureaus.index')" :active="request()->routeIs('bureaus.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/deco-glyph/48/FFFFFF/department.png" alt="bureaus" class="mr-2">
                            <span>{{ __('Bureaus') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view sections')
                        <x-nav-link :href="route('sections.index')" :active="request()->routeIs('sections.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-pie-graph-chart-isolated-on-white-right-now-business-bold-tal-revivo.png" alt="sections" class="mr-2">
                            <span>{{ __('Sections') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view applicants')
                        <x-nav-link :href="route('applicants.index')" :active="request()->routeIs('applicants.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/material-rounded/24/FFFFFF/parse-resume.png" alt="applicant" class="mr-2">
                            <span>{{ __('Applicants') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view members')
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/groups.png" alt="members" class="mr-2">
                            <span>{{ __('Members') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view licenses')
                        <x-nav-link :href="route('licenses.index')" :active="request()->routeIs('licenses.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/material-rounded/24/FFFFFF/security-checked.png" alt="licenses" class="mr-2">
                            <span>{{ __('Licenses') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view renewals')
                        <x-nav-link :href="route('renew.index')" :active="request()->routeIs('renew.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/glyph-neue/50/FFFFFF/restart.png" alt="renewals" class="mr-2">
                            <span>{{ __('Renewal Request') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view payments')
                        <x-nav-link :href="route('cashier.index')" :active="request()->routeIs('cashier.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/sf-black-filled/64/FFFFFF/checkout.png" alt="payments" class="mr-2">
                            <span>{{ __('Cashier') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view reports')
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/graph-report.png" alt="reports" class="mr-2">
                            <span>{{ __('Reports') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
        @endcan


        @canany(['view events', 'view announcements', 'view surveys'])
        <div class="px-2">
            <button @click="toggleDropdown('memberEngagement')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">Member Engagement</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('memberEngagement')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

                <div x-show="isDropdownOpen('memberEngagement')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                    @can('view events')
                        <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/sf-black-filled/64/FFFFFF/event-accepted.png" alt="events" class="mr-2">
                            <span>{{ __('Events & Activities') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view announcements')
                        <x-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/speaker_1.png" alt="announcementz" class="mr-2">
                            <span>{{ __('Announcements') }}</span>
                        </x-nav-link>
                    @endcan

                    @can('view surveys')
                        <x-nav-link :href="route('surveys.index')" :active="request()->routeIs('surveys.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/customer-survey.png" alt="survey" class="mr-2">
                            <span>{{ __('Surveys') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany


        @canany(['view quizzes', 'view certificates', 'view reviewers'])
        <div class="px-2">
            <button @click="toggleDropdown('assessments')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">Assessments</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('assessments')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

                <div x-show="isDropdownOpen('assessments')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                    @can('view quizzes')
                        <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/test.png" alt="examination" class="mr-2">
                            <span>{{ __('Examination') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/popular-topic.png" alt="reviewer" class="mr-2">
                        <span>{{ __('Reviewers') }}</span>
                    </x-nav-link>
                    
                    @can('view certificates')
                        <x-nav-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-glyphs/50/FFFFFF/certificate.png" alt="certificates" class="mr-2">
                            <span>{{ __('Certificates') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany


        @canany(['view emails', 'view documents'])
         <div class="px-2">
            <button @click="toggleDropdown('integrations')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">Integrations</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('integrations')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

                <div x-show="isDropdownOpen('integrations')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                    @can('view emails')
                        <x-nav-link :href="route('emails.index')" :active="request()->routeIs('emails.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-category-emails-bundle-email-bold-tal-revivo.png" alt="email" class="mr-2">
                            <span>{{ __('Emails') }}</span>
                        </x-nav-link>
                    @endcan
                    
                    @can('view documents')
                        <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FFFFFF/documents.png" alt="documents" class="mr-2">
                            <span>{{ __('Documents') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Profile Section -->
        <div class="px-2 pt-4">
            <div class="flex justify-center" x-show="sidebarOpen || window.innerWidth <= 768">
                <div class="border-t border-gray-700 my-3 w-3/4"></div>
            </div>
            <button @click="toggleDropdown('profile')" 
                    class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none justify-center"
                    :class="{'justify-center': !sidebarOpen && window.innerWidth > 768, 'justify-start': sidebarOpen || window.innerWidth <= 768}">
                <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="sidebarOpen || window.innerWidth <= 768" class="">{{ Auth::user()->first_name }}</span>
                <svg x-show="sidebarOpen || window.innerWidth <= 768" class="ml-1 h-4 w-4" 
                    :class="{'rotate-180': isDropdownOpen('profile')}" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="isDropdownOpen('profile')" class="pl-12 mt-2 space-y-3 bg-[#101966] rounded-md py-2">
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                    <img width="16" height="16" src="https://img.icons8.com/material/50/FFFFFF/user-male-circle--v1.png" alt="profile" class="mr-2">
                    <span>{{ __('Profile') }}</span>
                </x-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB]">
                        <img width="16" height="16" src="https://img.icons8.com/material/50/FFFFFF/close-pane.png" alt="logout" class="mr-2">
                        <span>{{ __('Log Out') }}</span>
                    </a>
                </form>
            </div>
        </div>
</nav>
@endcan