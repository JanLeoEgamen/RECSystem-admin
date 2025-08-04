<!-- Alpine.js Root for Mobile Menu -->
<div x-data="{ memberMenuOpen: false }" class="flex flex-col flex-1 overflow-hidden">

    <!-- TOPBAR Section --> 
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#101966] topbar-shadow h-16">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 relative">  
            
            <!-- Left Section -->
            <div class="flex items-center space-x-3">
                <!-- Sidebar Toggle (Admin Only) -->
                @can('view admin dashboard')
                <button 
                    @click="
                        if (window.innerWidth < 768) {
                            sidebarOpen = !sidebarOpen;
                            if (sidebarOpen) rightSidebarOpen = false;
                        } else {
                            sidebarOpen = !sidebarOpen;
                        }
                    " 
                    class="p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#5e6ffb]"
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
                    <x-application-logo class="h-8 w-8 text-white" />
                    <div class="flex items-center">
                        <span class="text-sm sm:text-base font-medium text-white mr-2">
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
                
                <span class="text-sm sm:text-base font-medium text-white mr-2 whitespace-nowrap">
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
                        <span class="font-medium text-white mr-2">Hello ka-circle!</span>
                    </div>
                    @endunlessrole
                @endcannot

                <!-- Visible only to admin -->
                @can('view admin dashboard')
                <div class="hidden sm:flex items-center">
                    <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-2">
                    <span class="font-medium text-white mr-2">Super Admin</span>
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
                        ] as $route => $label)
                            <x-nav-link :href="route($route)" :active="request()->routeIs($route)" 
                                class="member-nav-link px-3 py-1 text-sm whitespace-nowrap rounded-md">
                                {{ __($label) }}
                            </x-nav-link>
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
                    class="sm:hidden p-2 rounded-md text-white hover:bg-white/10 transition-colors duration-200"
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
            class="w-64 bg-[#101966] h-full p-4 flex flex-col space-y-2 transform transition-transform duration-300 right-sidebar-shadow"
            x-show="memberMenuOpen"
            x-transition:enter="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <div class="flex justify-end mb-4">
                <button @click="memberMenuOpen = false" class="text-white hover:text-[#5e6ffb] transition-colors duration-200">
                    ✕
                </button>
            </div>

            @foreach ([
                'member.dashboard' => 'Dashboard',
                'member.membership-details' => 'My Membership',
                'member.announcements' => 'Announcements',
                'member.surveys' => 'Surveys',
                'member.events' => 'Events',
                'member.quizzes' => 'Reviewers',
                'member.certificates.index' => 'Certificates',
                'member.documents' => 'Documents',
            ] as $route => $label)
                <x-nav-link :href="route($route)" :active="request()->routeIs($route)" 
                    class="member-mobile-link">
                    {{ __($label) }}
                </x-nav-link>
            @endforeach

            <!-- Mobile Profile Icon + Dropdown Links -->
            <div class="mt-4 border-t border-white/20 pt-2 space-y-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 w-full px-3 py-2 text-white hover:text-[#5e6ffb] transition">
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
