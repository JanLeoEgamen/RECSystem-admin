<!-- TOPBAR.BLADE.PHP -->
 <style>
.max-h-80 {
    scrollbar-width: thin;
    scrollbar-color: #5e6ffb transparent;
}

.max-h-80::-webkit-scrollbar {
    width: 6px;
}

.max-h-80::-webkit-scrollbar-track {
    background: transparent;
}

.max-h-80::-webkit-scrollbar-thumb {
    background-color: #5e6ffb;
    border-radius: 3px;
}

.max-h-80::-webkit-scrollbar-thumb:hover {
    background-color: #4c5bdb;
}
</style>
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
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
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

                @role('superadmin')
                @can('view admin dashboard')
                <div class="hidden sm:flex items-center relative">
                    <!-- Search Bar  -->
                    <div x-data="{ 
                        query: '', 
                        results: [], 
                        loading: false, 
                        showResults: false,
                        selectedIndex: -1
                    }" class="relative mr-4" @click.away="showResults = false, selectedIndex = -1">
                        
                        <div class="relative">
                            <!-- Search Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-400" 
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
                                        showResults = true;
                                        selectedIndex = -1;
                                        fetch('{{ route('global.search') }}?q=' + encodeURIComponent(query))
                                            .then(res => res.json())
                                            .then(data => {
                                                results = data;
                                                loading = false;
                                            })
                                            .catch(err => {
                                                console.error('Search error:', err);
                                                loading = false;
                                                results = [];
                                            });
                                    } else {
                                        results = [];
                                        showResults = false;
                                        selectedIndex = -1;
                                    }
                                "
                                @keydown.arrow-down.prevent="
                                    if (results.length > 0) {
                                        selectedIndex = selectedIndex < results.length - 1 ? selectedIndex + 1 : 0;
                                    }
                                "
                                @keydown.arrow-up.prevent="
                                    if (results.length > 0) {
                                        selectedIndex = selectedIndex > 0 ? selectedIndex - 1 : results.length - 1;
                                    }
                                "
                                @keydown.enter.prevent="
                                    if (selectedIndex >= 0 && results[selectedIndex]) {
                                        window.location.href = results[selectedIndex].url;
                                    }
                                "
                                @keydown.escape="showResults = false, selectedIndex = -1, query = ''"
                                @focus="if (query.length > 0) showResults = true"
                                placeholder="Search anything..."
                                class="pl-8 pr-8 py-1 rounded-md text-sm w-56
                                    bg-white dark:bg-gray-800
                                    border border-gray-300 dark:border-gray-600
                                    text-gray-900 dark:text-gray-100
                                    placeholder-gray-500 dark:placeholder-gray-400
                                    focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                    dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                    transition-colors duration-200"
                            >

                            <!-- Loading Indicator -->
                            <div x-show="loading" class="absolute right-2 top-2" style="display: none;">
                                <svg class="animate-spin h-4 w-4 text-[#5e6ffb] dark:text-[#7c8dfb]" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </div>

                            <!-- Clear Button -->
                            <button 
                                x-show="query.length > 0 && !loading" 
                                @click="query = '', results = [], showResults = false, selectedIndex = -1"
                                class="absolute right-2 top-1 p-0.5 rounded-full 
                                    text-gray-400 dark:text-gray-500
                                    hover:bg-gray-200 dark:hover:bg-gray-600
                                    hover:text-gray-600 dark:hover:text-gray-300
                                    transition-colors duration-200"
                                style="display: none;"
                            >
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Results Dropdown -->
                        <div 
                            x-show="showResults && (results.length > 0 || (!loading && query.length > 0))" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-1 w-80 z-50 max-h-80 overflow-y-auto
                                bg-white dark:bg-gray-800
                                border border-gray-200 dark:border-gray-600
                                shadow-xl dark:shadow-2xl
                                rounded-md
                                backdrop-blur-sm"
                            style="display: none;"
                        >
                            <!-- Results -->
                            <template x-if="results.length > 0">
                                <div class="py-1">
                                    <template x-for="(item, index) in results" :key="item.route">
                                        <a 
                                            :href="item.url" 
                                            :class="{
                                                'bg-[#5e6ffb] text-white': selectedIndex === index,
                                                'text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700': selectedIndex !== index
                                            }"
                                            @mouseenter="selectedIndex = index"
                                            @mouseleave="selectedIndex = -1"
                                            class="flex items-center px-3 py-2 text-sm transition-colors duration-150"
                                        >
                                            <div class="flex-1">
                                                <div class="font-medium" x-text="item.label"></div>
                                                <div class="text-xs opacity-70 capitalize" x-text="item.category.replace('-', ' ')"></div>
                                            </div>
                                            <div class="text-xs">
                                                <template x-if="item.action === 'index'">
                                                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 px-2 py-0.5 rounded">View</span>
                                                </template>
                                                <template x-if="item.action === 'create'">
                                                    <span class="bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 px-2 py-0.5 rounded">Create</span>
                                                </template>
                                                <template x-if="item.action === 'edit'">
                                                    <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 px-2 py-0.5 rounded">Edit</span>
                                                </template>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            <!-- No Results -->
                            <template x-if="results.length === 0 && !loading && query.length > 0">
                                <div class="px-3 py-4 text-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        No results found for "<span x-text="query" class="font-medium"></span>"
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                        Try searching for: users, roles, permissions, articles, etc.
                                    </p>
                                </div>
                            </template>

                            <!-- Search Tips -->
                            <template x-if="query.length === 0">
                                <div class="px-3 py-2 text-xs border-t border-gray-200 dark:border-gray-600
                                    text-gray-500 dark:text-gray-400
                                    bg-gray-50 dark:bg-gray-900">
                                    <div class="font-medium mb-1 text-gray-700 dark:text-gray-300">Quick search tips:</div>
                                    <div>• Use arrow keys to navigate</div>
                                    <div>• Press Enter to select</div>
                                    <div>• Press Esc to close</div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-2">
                    <span class="font-medium text-white dark:text-gray-200 mr-2">Super Admin</span>
                </div>
                @endcan
                @endrole

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
                @role('superadmin')
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
                    <svg x-show="!rightSidebarOpen" class="w-4 h-4 md:w-5 md:h-5 text-white transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <svg x-show="rightSidebarOpen" class="w-4 h-4 md:w-5 md:h-5 text-[#5E6FFB] transform transition-transform duration-200 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </button>
                @endcan
                @endrole
            </div>
        </div>
    </header>

    <!-- Mobile Right Slide-in Menu (Member Only) -->
    
@role('Member')
    <div 
        class="fixed inset-0 z-50 flex justify-end sm:hidden"
        x-show="memberMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
       

        <!-- Modern Slide-in Menu -->
        <div 
            class="w-80 bg-gradient-to-b from-[#101966] via-[#1a2077] to-[#101966] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 h-full flex flex-col shadow-2xl"
            x-show="memberMenuOpen"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <!-- Header Section -->
            <div class="flex items-center justify-between p-6 border-b border-white/10 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 dark:bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="https://img.icons8.com/ios-glyphs/30/ffffff/user--v1.png" class="h-6 w-6"/>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-lg">{{ Auth::user()->first_name }}</p>
                        <p class="text-blue-200 dark:text-gray-300 text-sm">Member Portal</p>
                    </div>
                </div>
                <button 
                    @click="memberMenuOpen = false" 
                    class="p-2 rounded-full bg-white/10 hover:bg-white/20 dark:bg-gray-700 dark:hover:bg-gray-600 text-white transition-all duration-200 hover:rotate-90"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Section -->
            <div class="flex-1 overflow-y-auto p-4 space-y-1">
                @unless(auth()->user()->member->isExpired())
                    @php
                        $menuItems = [
                            'member.dashboard' => ['label' => 'Dashboard', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z M3 7l9 6 9-6'],
                            'member.membership-details' => ['label' => 'My Membership', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            'member.announcements' => ['label' => 'Announcements', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                            'member.surveys' => ['label' => 'Surveys', 'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            'member.events' => ['label' => 'Events', 'icon' => 'M8 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h4zM16 7V3a1 1 0 012 0v4m0 0a1 1 0 01-1 1h-4a1 1 0 01-1-1V7a1 1 0 011-1h4zM8 15v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1zM16 15v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1z'],
                            'member.quizzes' => ['label' => 'Reviewers', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                            'member.certificates.index' => ['label' => 'Certificates', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                            'member.documents' => ['label' => 'Documents', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            'members.activity_logs' => ['label' => 'My Logs', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ];
                    @endphp

                    @foreach ($menuItems as $route => $item)
                        <x-nav-link 
                            :href="$route === 'members.activity_logs' 
                                ? route($route, Auth::user()->member->id) 
                                : route($route)"
                            :active="request()->routeIs($route)" 
                            class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-white/10 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 group {{ request()->routeIs($route) ? 'bg-white/20 dark:bg-gray-700 border-l-4 border-white' : '' }}"
                            @click="memberMenuOpen = false"
                        >
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200 {{ request()->routeIs($route) ? 'text-white' : 'text-blue-200 dark:text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                            </div>
                            <span class="font-medium">{{ __($item['label']) }}</span>
                            @if(request()->routeIs($route))
                                <div class="ml-auto">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            @endif
                        </x-nav-link>
                    @endforeach
                @else
                    <!-- Enhanced Expired Message -->
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-xl shadow-lg border border-red-400">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div>
                                <p class="text-white font-semibold text-sm">Membership Expired</p>
                                <p class="text-red-100 text-xs mt-1">Please renew to access member features.</p>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>

            <!-- Footer Section with Profile Actions -->
            <div class="border-t border-white/10 dark:border-gray-700 p-4 space-y-2">
                <x-nav-link 
                    :href="route('profile.edit')" 
                    class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-white/10 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 group"
                    @click="memberMenuOpen = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-200 dark:text-gray-400 group-hover:text-white transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Profile Settings</span>
                </x-nav-link>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button 
                        type="submit"
                        class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-white dark:text-gray-200 hover:bg-red-500/20 dark:hover:bg-red-600/20 rounded-lg transition-all duration-200 group"
                        @click="memberMenuOpen = false"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-300 group-hover:text-red-400 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Log Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endrole

</div>