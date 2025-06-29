<nav x-data="{ open: false }" class="bg-[#101966] dark:bg-gray-800 p-8  ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                        <x-application-logo class="block h-20 w-auto fill-current text-gray-800 dark:text-gray-200" />
                 </div>


                <!-- Member Portal Links -->
                @role('Member')
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.membership-details')" :active="request()->routeIs('member.membership-details')">
                        {{ __('My Membership Information') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.announcements')" :active="request()->routeIs('member.announcements')">
                        {{ __('Organization Announcements') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.surveys')" :active="request()->routeIs('member.surveys')">
                        {{ __('Surveys') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.events')" :active="request()->routeIs('member.events')">
                        {{ __('Events') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.quizzes')" :active="request()->routeIs('member.quizzes')">
                        {{ __('Reviewers') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.certificates.index')" :active="request()->routeIs('member.certificates.index')">
                        {{ __('My Certificates') }}
                    </x-nav-link>
                </div>
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('member.documents')" :active="request()->routeIs('member.documents')">
                        {{ __('Documents') }}
                    </x-nav-link>
                </div>
                @endrole



                <!-- Navigation Links -->
                @can('view admin dashboard')
                <div class="bg-[#101966] dark:bg-gray-800 hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endcan

                <!-- User Management Dropdown -->
                @canany(['view users', 'view roles', 'view permissions'])
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-white dark:text-gray-400 bg-[#101966] dark:bg-gray-800 hover:text-[#5E6FFB] dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('User Management') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                    @can('view users')
                    <x-dropdown-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        {{ __('User') }}
                    </x-dropdown-link>
                    @endcan

                    @can('view roles')
                    <x-dropdown-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                        {{ __('Roles') }}
                    </x-dropdown-link>
                    @endcan

                    @can('view permissions')
                    <x-dropdown-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')">
                        {{ __('Permissions') }}

                    </x-dropdown-link>
                    @endcan
                    </x-slot>
                </x-dropdown>
            </div>
            @endcan

            <!-- Website Content manager -->
            @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-white dark:text-gray-400 bg-[#101966] dark:bg-gray-800 hover:text-[#5E6FFB] dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ __('Website Content Manager') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
 
                    <x-slot name="content">
                        @can('view faqs')
                        <x-dropdown-link :href="route('faqs.index')">
                            {{ __('FAQs') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view main carousels')
                        <x-dropdown-link :href="route('main-carousels.index')">
                            {{ __('Main Carousels') }}
                        </x-dropdown-link>
                        @endcan
                        
                        @can('view event announcements')
                        <x-dropdown-link :href="route('event-announcements.index')">
                            {{ __('Event Announcements') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view communities')
                        <x-dropdown-link :href="route('communities.index')">
                            {{ __('Communities') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view articles')
                        <x-dropdown-link :href="route('articles.index')">
                            {{ __('Articles') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view supporters')
                        <x-dropdown-link :href="route('supporters.index')">
                            {{ __('Supporters') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view markees')
                        <x-dropdown-link :href="route('markees.index')">
                            {{ __('Markee on the Air') }}
                        </x-dropdown-link>
                        @endcan

                    </x-slot> 
                         
                </x-dropdown>
            </div>
            @endcan


            <!-- Membership, Bureau & Section Management -->
            @canany(['view membership types', 'view bureaus', 'view sections', 'veiw applicants', 'view members', 'view licenses', 'view renewals', 'view payments'])
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-white dark:text-gray-400 bg-[#101966] dark:bg-gray-800 hover:text-[#5E6FFB] dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ __('Membership Management') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @can('view membership types')
                        <x-dropdown-link :href="route('membership-types.index')">
                            {{ __('Membership Types') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view bureaus')
                        <x-dropdown-link :href="route('bureaus.index')">
                            {{ __('Bureaus') }}
                        </x-dropdown-link>
                        @endcan
                        
                        @can('view sections')
                        <x-dropdown-link :href="route('sections.index')">
                            {{ __('Sections') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view applicants')
                        <x-dropdown-link :href="route('applicants.index')">
                            {{ __('Applicants') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view members')
                        <x-dropdown-link :href="route('members.index')">
                            {{ __('Members') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view licenses')
                        <x-dropdown-link :href="route('licenses.index')">
                            {{ __('Licenses') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view renewals')
                        <x-dropdown-link :href="route('renew.index')">
                            {{ __('Renewal Request') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view payments')
                        <x-dropdown-link :href="route('cashier.index')">
                            {{ __('Cashier') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view reports')
                        <x-dropdown-link :href="route('reports.index')">
                            {{ __('Reports') }}
                        </x-dropdown-link>
                        @endcan
                    </x-slot> 
                </x-dropdown>
            </div>
            @endcan


            <!-- Email, certificates and quiz -->
            @canany(['view certificates', 'view quizzes', 'view emails', 'view surveys', 'view announcements', 'view events', 'view documents', 'view reviewers'])   
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-white dark:text-gray-400 bg-[#101966] dark:bg-gray-800 hover:text-[#5E6FFB] dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ __('Integrations') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @can('view certificates')
                        <x-dropdown-link :href="route('certificates.index')">
                            {{ __('Certificate Management') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view emails')
                        <x-dropdown-link :href="route('emails.index')">
                            {{ __('Email Management') }}
                        </x-dropdown-link>
                        @endcan
                        
                        @can('view quizzes')
                        <x-dropdown-link :href="route('quizzes.index')">
                            {{ __('Licensing Reviewer Exam') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view surveys')
                        <x-dropdown-link :href="route('surveys.index')">
                            {{ __('Survey Management') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view announcements')
                        <x-dropdown-link :href="route('announcements.index')">
                            {{ __('Announcement Management') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view events')
                        <x-dropdown-link :href="route('events.index')">
                            {{ __('Event Management') }}
                        </x-dropdown-link>
                        @endcan

                        @can('view reviewers')
                        <x-dropdown-link :href="route('quizzes.index')">
                            {{ __('Reviewer Management') }}
                        </x-dropdown-link>
                        @endcan


                        @can('view documents')
                        <x-dropdown-link :href="route('documents.index')">
                            {{ __('Document Management') }}
                        </x-dropdown-link>
                        @endcan


                    </x-slot> 
                </x-dropdown>
            </div>
            @endcan
                 

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-white dark:text-gray-400 bg-[#101966] dark:bg-gray-800 hover:text-[#5E6FFB] dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ({{ Auth::user()->roles->pluck('name')->implode(', ') }})</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

    </div>
</nav>
