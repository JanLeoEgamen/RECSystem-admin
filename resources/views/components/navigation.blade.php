 @can('view admin dashboard')
<!-- Sidebar -->
<div 
    class="fixed top-16 left-0 w-64 bg-[#101966] h-[calc(100vh-4rem)] transform transition-transform duration-200 ease-in-out shadow-lg shadow-black/70"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    x-data="{
        dropdowns: {},
        toggleDropdown(name) {
            this.dropdowns[name] = !this.dropdowns[name];
        },
        isDropdownOpen(name) {
            return this.dropdowns[name];
        }
    }" >
    
    <div class="flex flex-col h-full">
        <!-- Header / Logo -->
        <div class="flex items-center h-16 px-4 bg-[#101966]">
            <a href="{{ url('/') }}" class="text-white font-semibold text-xl">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <!-- Sidebar Content -->
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <nav class="flex-1 space-y-2">

                {{-- Dashboard Link --}}
                @can('view admin dashboard')
                    <div class="px-2">
                        <x-nav-link 
                            :href="route('dashboard')" 
                            :active="request()->routeIs('dashboard')" 
                            class="flex items-center px-3 py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] transition-colors duration-150"
                            @click="if(window.innerWidth > 768 && !sidebarOpen) { sidebarOpen = true; }"
                        >
                            <img 
                                src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/50/FFFFFF/external-dashboard-user-interface-kmg-design-glyph-kmg-design.png" 
                                alt="dashboard"
                                class="w-5 h-5 object-contain mr-2"
                            >
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('Dashboard') }}
                            </span>
                        </x-nav-link>
                    </div>

                    <!-- Divider line (visible when sidebar is open or in mobile view) -->
                    <div class="flex justify-center" x-show="sidebarOpen || window.innerWidth <= 768">
                        <div class="border-t border-gray-200 my-3 w-3/4"></div>
                    </div>
                @endcan


                {{-- User Management Dropdown --}}
                @canany(['view users', 'view roles', 'view permissions'])
                    <div class="px-2">
                        <button 
                            @click="toggleDropdown('userManagement')" 
                            class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                            :class="{
                                'justify-center': !sidebarOpen && window.innerWidth > 768, 
                                'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                            }"
                        >
                            <svg 
                                class="w-5 h-5" 
                                :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('User Management') }}
                            </span>
                            <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                                class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                :class="{'rotate-180': isDropdownOpen('userManagement')}" 
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="isDropdownOpen('userManagement')" x-transition class="mt-2 space-y-1">
                            @can('view users')
                                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/conference-call.png" 
                                         alt="Users" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Users') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view roles')
                                <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/connected-people.png" 
                                         alt="Roles" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Roles') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view permissions')
                                <x-nav-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/glyph-neue/50/FFFFFF/restriction-shield.png" 
                                         alt="Permissions" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Permissions') }}</span>
                                </x-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcanany

                {{-- Website Management Dropdown --}}
                @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters', 'view markees'])
                    <div class="px-2">
                        <button 
                            @click="toggleDropdown('websiteManagement')" 
                            class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                            :class="{
                                'justify-center': !sidebarOpen && window.innerWidth > 768, 
                                'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                            }"
                        >
                            <svg class="w-5 h-5" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('Website Management') }}
                            </span>
                            <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                                class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                :class="{'rotate-180': isDropdownOpen('websiteManagement')}" 
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="isDropdownOpen('websiteManagement')" x-transition class="mt-2 space-y-1">
                            @can('view main carousels')
                                <x-nav-link :href="route('main-carousels.index')" :active="request()->routeIs('main-carousels.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/deco-glyph/48/FFFFFF/image-file.png" class="w-4 h-4 mr-2 object-contain" alt="Main Carousels">
                                    <span>{{ __('Main Carousels') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view markees')
                                <x-nav-link :href="route('markees.index')" :active="request()->routeIs('markees.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/old-shop.png" class="w-4 h-4 mr-2 object-contain" alt="Markee">
                                    <span>{{ __('Markee on the Air') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view articles')
                                <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/external-glyph-design-circle/66/FFFFFF/external-News-journalism-solid-design-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Articles">
                                    <span>{{ __('Articles') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view event announcements')
                                <x-nav-link :href="route('event-announcements.index')" :active="request()->routeIs('event-announcements.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/event-accepted.png" class="w-4 h-4 mr-2 object-contain" alt="Events">
                                    <span>{{ __('Event Announcements') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view communities')
                                <x-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/fluency-systems-filled/50/FFFFFF/conference-call.png" class="w-4 h-4 mr-2 object-contain" alt="Communities">
                                    <span>{{ __('Communities') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view supporters')
                                <x-nav-link :href="route('supporters.index')" :active="request()->routeIs('supporters.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/collaborating-in-circle.png" class="w-4 h-4 mr-2 object-contain" alt="Supporters">
                                    <span>{{ __('Supporters') }}</span>
                                </x-nav-link>
                            @endcan
                            @can('view faqs')
                                <x-nav-link :href="route('faqs.index')" :active="request()->routeIs('faqs.index')" class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/16/FFFFFF/help.png" class="w-4 h-4 mr-2 object-contain" alt="FAQs">
                                    <span>{{ __('FAQs') }}</span>
                                </x-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcanany

                {{-- Member Engagement Dropdown --}}
                @canany(['view events', 'view announcements', 'view surveys'])
                    <div class="px-2">
                        <button 
                            @click="toggleDropdown('memberEngagement')" 
                            class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                            :class="{
                                'justify-center': !sidebarOpen && window.innerWidth > 768, 
                                'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                            }"
                        >
                            <svg class="w-5 h-5 object-contain" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('Member Engagement') }}
                            </span>
                            <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                                class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                :class="{'rotate-180': isDropdownOpen('memberEngagement')}" 
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="isDropdownOpen('memberEngagement')" x-transition class="mt-2 space-y-1">

                            @can('view events')
                                <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/sf-black-filled/64/FFFFFF/event-accepted.png" 
                                        alt="Events" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Events & Activities') }}</span>
                                </x-nav-link>
                            @endcan
                            
                            @can('view announcements')
                                <x-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/speaker_1.png" 
                                        alt="Announcements" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Announcements') }}</span>
                                </x-nav-link>
                            @endcan

                            @can('view surveys')
                                <x-nav-link :href="route('surveys.index')" :active="request()->routeIs('surveys.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/customer-survey.png" 
                                        alt="Surveys" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Surveys') }}</span>
                                </x-nav-link>
                            @endcan

                        </div>
                    </div>
                @endcanany

                {{-- Assessments Dropdown --}}
                @canany(['view quizzes', 'view certificates', 'view reviewers'])
                    <div class="px-2">
                        <button 
                            @click="toggleDropdown('assessments')" 
                            class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                            :class="{
                                'justify-center': !sidebarOpen && window.innerWidth > 768, 
                                'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                            }"
                        >
                            <svg class="w-5 h-5 object-contain" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('Assessments') }}
                            </span>
                            <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                                class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                :class="{'rotate-180': isDropdownOpen('assessments')}" 
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="isDropdownOpen('assessments')" x-transition class="mt-2 space-y-1">

                            @can('view quizzes')
                                <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/test.png" 
                                        alt="Examination" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Examination') }}</span>
                                </x-nav-link>
                            @endcan

                             @can('view reviewer')
                                <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/test.png" 
                                        alt="Examination" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Reviewers') }}</span>
                                </x-nav-link>
                            @endcan

                            @can('view certificates')
                                <x-nav-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-glyphs/50/FFFFFF/certificate.png" 
                                        alt="Certificates" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Certificates') }}</span>
                                </x-nav-link>
                            @endcan

                        </div>
                    </div>
                @endcanany

                {{-- Integrations Dropdown --}}
                @canany(['view emails', 'view documents'])
                    <div class="px-2">
                        <button 
                            @click="toggleDropdown('integrations')" 
                            class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                            :class="{
                                'justify-center': !sidebarOpen && window.innerWidth > 768, 
                                'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                            }"
                        >
                            <svg class="w-5 h-5 object-contain" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span x-show="sidebarOpen || window.innerWidth <= 768" class="flex-1 text-left">
                                {{ __('Integrations') }}
                            </span>
                            <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                                class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                :class="{'rotate-180': isDropdownOpen('integrations')}" 
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="isDropdownOpen('integrations')" x-transition class="mt-2 space-y-1">

                            @can('view emails')
                                <x-nav-link :href="route('emails.index')" :active="request()->routeIs('emails.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/24/FFFFFF/external-category-emails-bundle-email-bold-tal-revivo.png" 
                                        alt="Emails" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Emails') }}</span>
                                </x-nav-link>
                            @endcan

                            @can('view documents')
                                <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index')" 
                                    class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                    <img src="https://img.icons8.com/ios-filled/50/FFFFFF/documents.png" 
                                        alt="Documents" class="w-4 h-4 mr-2 object-contain">
                                    <span>{{ __('Documents') }}</span>
                                </x-nav-link>
                            @endcan

                        </div>
                    </div>
                @endcanany

                <!-- Profile Section -->
                <div class="px-2 pt-4">
                    <!-- Divider -->
                    <div class="flex justify-center" x-show="sidebarOpen || window.innerWidth <= 768">
                        <div class="border-t border-gray-200 my-3 w-3/4"></div>
                    </div>

                    <button 
                        @click="toggleDropdown('profile')" 
                        class="w-full flex items-center py-3 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none transition-colors duration-150"
                        :class="{
                            'justify-center': !sidebarOpen && window.innerWidth > 768, 
                            'justify-start px-3': sidebarOpen || window.innerWidth <= 768
                        }"
                    >
                        <svg class="w-5 h-5 object-contain" :class="{'mr-3': sidebarOpen || window.innerWidth <= 768}" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen || window.innerWidth <= 768">
                            {{ Auth::user()->first_name }}
                        </span>
                        <svg x-show="sidebarOpen || window.innerWidth <= 768" 
                            class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                            :class="{'rotate-180': isDropdownOpen('profile')}" 
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" 
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="isDropdownOpen('profile')" x-transition class="mt-2 space-y-1">

                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                            <img src="https://img.icons8.com/material/50/FFFFFF/user-male-circle--v1.png" 
                                alt="Profile" class="w-4 h-4 mr-2 object-contain">
                            <span>{{ __('Profile') }}</span>
                        </x-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); this.closest('form').submit();" 
                            class="flex items-center px-3 py-2 text-sm rounded-md text-gray-300 hover:text-white hover:bg-[#5E6FFB] ml-8">
                                <img src="https://img.icons8.com/material/50/FFFFFF/close-pane.png" 
                                    alt="Logout" class="w-4 h-4 mr-2 object-contain">
                                <span>{{ __('Log Out') }}</span>
                            </a>
                        </form>
                    </div>
                </div>


            </nav>
        </div>
    </div>
</div>
@endcan


@can('view admin dashboard')
<div class="flex flex-col flex-1 overflow-hidden">
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#101966] shadow-lg shadow-black/70 h-16">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
            
            <!-- Left Section -->
            <div class="flex items-center space-x-3">
                <!-- Sidebar Toggle (Visible on all, but different behavior for mobile) -->
                <button 
                    @click="
                        sidebarOpen = !sidebarOpen;
                        if (rightSidebarOpen) rightSidebarOpen = false;
                    " 
                    class="p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#5e6ffb]"
                >
                    <!-- Hamburger -->
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- X Close -->
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Logo + Name -->
                <div class="flex items-center ml-2 space-x-2">
                    <!-- Logo -->
                    <x-application-logo class="h-8 w-8 text-white" />

                    <!-- Organization Name (Badge hidden on mobile) -->
                    <div class="flex items-center">
                        <span class="text-sm sm:text-base font-medium text-white mr-2">
                            Radio Engineering Circle Inc.
                        </span>
                        <span class="hidden sm:inline-block px-1.5 py-0.5 text-xs font-bold bg-[#5e6ffb] text-white rounded-full">
                            DZ1REC
                        </span>
                    </div>
                </div>
            </div>

            <!-- Center Section (Hidden on Mobile) -->
            <div class="hidden sm:flex items-center">
                <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-sm sm:text-base font-medium text-white mr-2">
                    Membership Information Management System
                </span>
                <span class="px-1.5 py-0.5 text-xs font-bold bg-[#5e6ffb] text-white rounded-full">
                    MIMS
                </span>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-3">
                <!-- Admin Info (Hidden on Mobile) -->
                <div class="hidden sm:flex items-center">
                    <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-2">
                    <span class="font-medium text-white mr-2">Hi, Admin</span>
                </div>
                
                <!-- Right Sidebar Toggle -->
                <button 
                    @click="
                        rightSidebarOpen = !rightSidebarOpen;
                        if (sidebarOpen) sidebarOpen = false;
                    " 
                    class="p-1 rounded-md hover:bg-white/10 focus:outline-none transition-colors duration-150"
                    :class="{ 'bg-white/10': rightSidebarOpen }"
                >
                    <img 
                        width="24" 
                        height="24" 
                        :src="rightSidebarOpen ? 
                            'https://img.icons8.com/material-rounded/24/5e6ffb/left-navigation-toolbar.png' : 
                            'https://img.icons8.com/material-rounded/24/FFFFFF/left-navigation-toolbar.png'" 
                        alt="menubar"
                        class="transform transition-transform duration-200"
                        :class="{ 'rotate-180': rightSidebarOpen }"
                    >
                </button>
            </div>
        </div>
    </header>
</div>
@endcan