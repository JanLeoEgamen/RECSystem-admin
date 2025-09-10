<!-- TOPBAR.BLADE.PHP -->
<!-- Alpine.js Root for Mobile Menu -->
<div x-data="{ memberMenuOpen: false }" class="flex flex-col flex-1 overflow-hidden">

    <!-- TOPBAR Section --> 
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#101966] dark:bg-gray-900 topbar-shadow h-16">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 relative">  
            
            <!-- Left Section -->
            <div class="flex items-center space-x-3">
                <!-- Sidebar Toggle (Admin Only) -->
                @can('view admin dashboard')
                <button 
                    @click="
                        sidebarOpen = !sidebarOpen;

                        if (sidebarOpen) {
                            rightSidebarOpen = false;

                            const url = new URL(window.location);
                            url.searchParams.set('from_menu', 'true');
                            window.history.replaceState({}, '', url);

                            setTimeout(() => {
                                document.querySelectorAll('.sidebar-item').forEach((el, index) => {
                                    el.classList.remove('animate'); 
                                    void el.offsetWidth;
                                    el.classList.add('animate'); 
                                });
                            }, 10);
                        }
                    " 
                    class="p-2 rounded-md text-white dark:text-gray-200 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#5e6ffb]"
                >
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endcan

                <!-- Logo and DZ1REC Badge -->
                <div class="flex items-center ml-2 space-x-2">
                    <x-application-logo class="h-8 w-8 text-white dark:text-gray-200" />
                    <div class="flex items-center">
                        <span class="text-sm sm:text-base font-medium text-white dark:text-gray-200 mr-2">
                            Radio Engineering Circle Inc.
                        </span>
                        <span class="hidden lg:inline-block px-2.5 py-0.5 text-xs font-bold bg-[#5e6ffb] text-white rounded-full">
                            DZ1REC
                        </span>
                    </div>
                </div>
            </div>

            @can('view admin dashboard')
            <!-- Center Section - Hidden on Mobile -->
            <div class="absolute left-1/2 transform -translate-x-1/2 hidden sm:flex items-center">
                <img src="https://img.icons8.com/glyph-neue/64/FFFFFF/groups.png" 
                    alt="Membership Icon" 
                    class="w-6 h-6 mr-2 object-contain">
                
                <span class="text-sm sm:text-base font-medium text-white dark:text-gray-200 mr-2 whitespace-nowrap">
                    Membership Information Management System
                </span>
                
                <span class="px-3 py-0.5 text-xs font-bold bg-[#5e6ffb] text-white rounded-full">
                    MIMS
                </span>
            </div>
            @endcan

            <!-- Right Section -->
            <div class="flex items-center space-x-3">
                <!-- Hello ka-circle (Only for Non-Admin, Non-Member) -->
                @cannot('view admin dashboard')
                    @unlessrole('Member')
                    <div class="hidden sm:flex items-center">
                        <img 
                            src="https://img.icons8.com/glyph-neue/64/FFFFFF/radio-waves.png" 
                            alt="radio-waves" 
                            class="w-6 h-6 mr-2 object-contain"
                        >
                        <span class="font-medium text-white dark:text-gray-200 mr-2">Hello ka-circle!</span>
                    </div>
                    @endunlessrole
                @endcannot

                @can('view admin dashboard')
                <div class="hidden sm:flex items-center relative">

                    <!-- Search Bar  -->
                    <div x-data="{ query: '', results: [], loading: false }" class="relative mr-4" @click.away="results = []">
                        <div class="relative">
                            <!-- Search Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>
                            </div>

                            <input 
                                type="text" 
                                x-model="query"
                                @input.debounce.300ms="
                                    if (query.length > 0) {
                                        loading = true;
                                        fetch('{{ route('global.search') }}?q=' + query)
                                            .then(res => res.json())
                                            .then(data => {
                                                results = data;
                                                loading = false;
                                            })
                                            .catch(() => loading = false);
                                    } else {
                                        results = [];
                                    }
                                "
                                placeholder="Search..."
                                class="pl-8 pr-8 py-1 rounded-md text-black dark:text-white text-sm 
                                    focus:ring focus:ring-[#5e6ffb] 
                                    dark:bg-gray-900 dark:border dark:border-gray-700 w-56"
                            >

                            <div x-show="loading" class="absolute right-2 top-2">
                                <svg class="animate-spin h-4 w-4 text-[#5e6ffb] dark:text-gray-300" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </div>
                        </div>

                        <div 
                            x-show="(results.length > 0 || (!loading && query.length > 0))" 
                            class="absolute left-0 mt-1 w-56 bg-white dark:bg-gray-800 shadow-lg rounded-md z-50 
                                max-h-60 overflow-y-auto scrollbar-left">
                            <template x-if="results.length > 0">
                                <div>
                                    <template x-for="item in results" :key="item.route">
                                        <a 
                                            :href="item.url" 
                                            class="block px-3 py-1 text-sm hover:bg-[#5e6ffb] hover:text-white dark:hover:bg-[#5e6ffb] dark:hover:text-white dark:text-white"
                                            x-text="item.label"
                                        ></a>
                                    </template>
                                </div>
                            </template>

                            <template x-if="results.length === 0 && !loading && query.length > 0">
                                <div class="px-3 py-2 text-sm text-red-500 dark:text-red-400 font-medium flex items-center">
                                    <svg class="h-4 w-4 mr-1 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Nothing found
                                </div>
                            </template>
                        </div>
                    </div>

                    <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-2">
                    <span class="font-medium text-white dark:text-gray-200 mr-2">Super Admin</span>
                </div>
                @endcan


                <!-- Member Portal Links + Profile Icon Dropdown -->
                @role('Member')
                <!-- Desktop/Tablet view -->
                <div class="hidden sm:flex sm:ml-auto sm:mr-4 items-center space-x-4">
                    <nav class="flex gap-4 md:gap-6">
                        @foreach ([
                            'member.dashboard' => 'Dashboard',
                            'member.membership-details' => 'My Membership',
                            'member.announcements' => 'Announcements',
                            'member.surveys' => 'Surveys',
                            'member.events' => 'Events',
                            'member.quizzes' => 'Reviewers',
                            'member.certificates.index' => 'Certificates',
                            'member.documents' => 'Documents',
                            'members.activity_logs' => 'My Logs',
                        ] as $route => $label)
                            @unless(auth()->user()->member->isExpired())
                                <x-nav-link 
                                    :href="$route === 'members.activity_logs' 
                                        ? route($route, Auth::user()->member->id) 
                                        : route($route)"
                                    :active="request()->routeIs($route)" 
                                    class="member-nav-link px-3 py-1 text-sm whitespace-nowrap rounded-md dark:text-gray-200"
                                >
                                    {{ __($label) }}
                                </x-nav-link>
                            @endunless
                        @endforeach
                    </nav>

                    <!-- Profile Icon Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/user--v1.png" class="h-5 w-5"/>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                

                <!-- Mobile menu button -->
                <button 
                    @click="memberMenuOpen = true" 
                    class="sm:hidden p-2 rounded-md text-white dark:text-gray-200 hover:bg-white/10 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                @endrole


                <!-- Right Sidebar Toggle (Admin only) -->
                @can('view admin dashboard')
                <button 
                    @click="
                        if (window.innerWidth < 768) {
                            rightSidebarOpen = !rightSidebarOpen;
                            if (rightSidebarOpen) sidebarOpen = false;
                        } else {
                            rightSidebarOpen = !rightSidebarOpen;
                        }
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
                        class="transform transition-transform duration-200"
                        :class="{ 'rotate-180': rightSidebarOpen }"
                    >
                </button>
                @endcan
            </div>
        </div>
    </header>

    <!-- Mobile Right Slide-in Menu (Member Only) -->
    @role('Member')
    <div 
        class="fixed inset-0 z-50 flex justify-end sm:hidden"
        x-show="memberMenuOpen"
        x-transition.opacity
    >
        <!-- Backdrop -->
        <div class="flex-1 bg-black/30 backdrop-blur-sm" @click="memberMenuOpen = false"></div>

        <!-- Slide-in Menu -->
        <div 
            class="w-64 bg-[#101966] dark:bg-gray-900 h-full p-4 flex flex-col space-y-2 transform transition-transform duration-300 right-sidebar-shadow"
            x-show="memberMenuOpen"
            x-transition:enter="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <div class="flex justify-end mb-4">
                <button @click="memberMenuOpen = false" class="text-white dark:text-gray-200 hover:text-[#5e6ffb] transition-colors duration-200">
                    ✕
                </button>
            </div>

            @unless(auth()->user()->member->isExpired())
                @foreach ([
                    'member.dashboard' => 'Dashboard',
                    'member.membership-details' => 'My Membership',
                    'member.announcements' => 'Announcements',
                    'member.surveys' => 'Surveys',
                    'member.events' => 'Events',
                    'member.quizzes' => 'Reviewers',
                    'member.certificates.index' => 'Certificates',
                    'member.documents' => 'Documents',
                    'members.activity_logs' => 'My Logs',
                ] as $route => $label)
                    <x-nav-link 
                        :href="$route === 'members.activity_logs' 
                            ? route($route, Auth::user()->member->id) 
                            : route($route)"
                        :active="request()->routeIs($route)" 
                        class="member-nav-link px-3 py-1 text-sm whitespace-nowrap rounded-md dark:text-gray-200"
                    >
                        {{ __($label) }}
                    </x-nav-link>
                @endforeach
            @else
                <!-- Optionally show a message when membership is expired -->
                <div class="px-3 py-2 text-sm text-white bg-red-600 rounded-md">
                    Your membership has expired. Please renew to access these features.
                </div>
            @endunless

            <!-- Mobile Profile Icon + Dropdown Links -->
            <div class="mt-4 border-t border-white/20 dark:border-gray-700 pt-2 space-y-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 w-full px-3 py-2 text-white dark:text-gray-200 hover:text-[#5e6ffb] transition">
                            <img src="https://img.icons8.com/ios-glyphs/30/ffffff/user--v1.png" class="h-5 w-5"/>
                            <span>{{ Auth::user()->first_name }}</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
    @endrole

</div>