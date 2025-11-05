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

/* Tooltip animation */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.2s ease-out;
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
                <div class="relative group" x-data="{ 
                    leftSidebarNotificationCount: 0,
                    init() {
                        this.updateLeftSidebarNotificationCount();
                        window.addEventListener('storage', () => {
                            this.updateLeftSidebarNotificationCount();
                        });
                        setInterval(() => {
                            this.updateLeftSidebarNotificationCount();
                        }, 1000);
                    },
                    updateLeftSidebarNotificationCount() {
                        let count = 0;
                        
                        // New Users (last 7 days)
                        const lastViewedUsers = '{{ session('viewed_users') }}';
                        @php
                            $newUserCount = \App\Models\User::where('created_at', '>=', now()->subDays(7))
                                ->when(session('viewed_users'), function($query) {
                                    return $query->where('created_at', '>', session('viewed_users'));
                                })
                                ->count();
                        @endphp
                        const newUserCount = {{ $newUserCount }};
                        if (newUserCount > 0) count++;
                        
                        // Student Applicants
                        @php
                            $studentApplicantCount = \App\Models\Applicant::where('is_student', true)
                                ->where('status', 'pending')
                                ->when(session('viewed_student_applicants'), function($query) {
                                    return $query->where('created_at', '>', session('viewed_student_applicants'));
                                })
                                ->count();
                        @endphp
                        const studentApplicantCount = {{ $studentApplicantCount }};
                        if (studentApplicantCount > 0) count++;
                        
                        // Regular Applicants
                        @php
                            $applicantCount = \App\Models\Applicant::where('status', 'pending')
                                ->when(session('viewed_applicants'), function($query) {
                                    return $query->where('created_at', '>', session('viewed_applicants'));
                                })
                                ->count();
                        @endphp
                        const applicantCount = {{ $applicantCount }};
                        if (applicantCount > 0) count++;
                        
                        // Unlicensed Members
                        @php
                            $unlicensedCount = \App\Models\Member::whereNull('license_number')
                                ->when(session('viewed_licenses'), function($query) {
                                    return $query->where('created_at', '>', session('viewed_licenses'));
                                })
                                ->count();
                        @endphp
                        const unlicensedCount = {{ $unlicensedCount }};
                        if (unlicensedCount > 0) count++;
                        
                        // Pending Renewals
                        @php
                            $renewalCount = \App\Models\Renewal::where('status', 'pending')
                                ->when(session('viewed_renewals'), function($query) {
                                    return $query->where('created_at', '>', session('viewed_renewals'));
                                })
                                ->count();
                        @endphp
                        const renewalCount = {{ $renewalCount }};
                        if (renewalCount > 0) count++;
                        
                        // Pending Payments
                        @php
                            $pendingPaymentCount = \App\Models\Applicant::where('payment_status', 'pending')
                                ->when(session('viewed_payments'), function($query) {
                                    return $query->where('updated_at', '>', session('viewed_payments'));
                                })
                                ->count();
                        @endphp
                        const pendingPaymentCount = {{ $pendingPaymentCount }};
                        if (pendingPaymentCount > 0) count++;
                        
                        this.leftSidebarNotificationCount = count;
                    }
                }">
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
                        class="p-2 rounded-md text-white dark:text-gray-200 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#5e6ffb] relative"
                        title="Navigation Tool"
                    >
                        <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        
                        <!-- Notification Badge for Left Sidebar -->
                        <span x-show="leftSidebarNotificationCount > 0" class="absolute -top-1 -right-1 flex h-4 w-4 md:h-5 md:w-5" style="display: none;">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 md:h-5 md:w-5 bg-red-500 text-white text-[9px] md:text-[10px] items-center justify-center font-bold" x-text="leftSidebarNotificationCount">
                            </span>
                        </span>
                    </button>
                    
                    <!-- Tooltip for Navigation Tool -->
                    <div class="absolute top-full left-0 mt-2 hidden group-hover:block z-50 animate-fade-in">
                        <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-lg">
                            <!-- Arrow -->
                            <div class="absolute bottom-full left-4 -mb-1">
                                <div class="w-2 h-2 bg-gray-900 transform rotate-45"></div>
                            </div>
                            <div class="font-semibold">Navigation Tool</div>
                            <div x-show="leftSidebarNotificationCount > 0" class="text-red-300 text-[10px] mt-0.5" style="display: none;">
                                <span x-text="leftSidebarNotificationCount"></span> pending notification<span x-show="leftSidebarNotificationCount > 1">s</span>
                            </div>
                        </div>
                    </div>
                </div>
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
            <!-- Center Section - Hidden on Mobile and Medium Screens -->
            <div class="absolute left-1/2 transform -translate-x-1/2 hidden lg:flex items-center">
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

                    <div class="relative group flex items-center">
                        <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-2">
                        <span class="font-medium text-white dark:text-gray-200 mr-2">Super Admin</span>
                        
                        <!-- Tooltip for Super Admin -->
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 hidden group-hover:block z-50 pointer-events-none animate-fade-in">
                            <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-lg relative">
                                <!-- Arrow -->
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2">
                                    <div class="w-2 h-2 bg-gray-900 transform rotate-45 -mb-1"></div>
                                </div>
                                <div class="font-semibold">Currently accessing Super Admin account</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @endrole

                <!-- Member Portal Navigation -->
                @include('components.member-topbar')


                <!-- Right Sidebar Toggle (Admin only) -->
                @role('superadmin')
                @can('view admin dashboard')
                <div class="relative group" x-data="{ 
                    notificationCount: 0,
                    init() {
                        this.updateNotificationCount();
                        window.addEventListener('storage', () => {
                            this.updateNotificationCount();
                        });
                        setInterval(() => {
                            this.updateNotificationCount();
                        }, 1000);
                    },
                    updateNotificationCount() {
                        const reviewedNotifications = JSON.parse(localStorage.getItem('reviewedNotifications') || '[]');
                        let count = 0;
                        @if(\App\Models\Applicant::where('status', 'pending')->where('is_student', true)->count() > 0)
                        if (!reviewedNotifications.includes('student_applicants')) count++;
                        @endif
                        @if(\App\Models\Applicant::where('status', 'pending')->where('is_student', false)->count() > 0)
                        if (!reviewedNotifications.includes('regular_applicants')) count++;
                        @endif
                        @if(\App\Models\Applicant::where('status', 'pending')->where('has_license', true)->count() > 0)
                        if (!reviewedNotifications.includes('licensed_applicants')) count++;
                        @endif
                        @if(\App\Models\Applicant::where('status', 'pending')->where('has_license', false)->count() > 0)
                        if (!reviewedNotifications.includes('unlicensed_applicants')) count++;
                        @endif
                        this.notificationCount = count;
                    }
                }">
                    <button 
                        @click="
                            if (window.innerWidth < 768) {
                                rightSidebarOpen = !rightSidebarOpen;
                                if (rightSidebarOpen) {
                                    sidebarOpen = false;
                                    window.dispatchEvent(new CustomEvent('toggle-right-sidebar'));
                                }
                            } else {
                                rightSidebarOpen = !rightSidebarOpen;
                                if (rightSidebarOpen) {
                                    window.dispatchEvent(new CustomEvent('toggle-right-sidebar'));
                                }
                            }
                        "
                        @toggle-right-sidebar.window="rightSidebarOpen = true; if (window.innerWidth < 768) sidebarOpen = false;"
                        class="relative p-1 rounded-md hover:bg-white/10 focus:outline-none transition-colors duration-150"
                        :class="{ 'bg-white/10': rightSidebarOpen }"
                        title="Quick Actions"
                    >
                        <svg x-show="!rightSidebarOpen" class="w-4 h-4 md:w-5 md:h-5 text-white transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <svg x-show="rightSidebarOpen" class="w-4 h-4 md:w-5 md:h-5 text-[#5E6FFB] transform transition-transform duration-200 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        
                        <!-- Notification Badge -->
                        <span x-show="notificationCount > 0" class="absolute -top-1 -right-1 flex h-4 w-4 md:h-5 md:w-5" style="display: none;">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 md:h-5 md:w-5 bg-red-500 text-white text-[9px] md:text-[10px] items-center justify-center font-bold" x-text="notificationCount">
                            </span>
                        </span>
                    </button>
                    
                    <!-- Tooltip -->
                    <div class="absolute top-full right-0 mt-2 hidden group-hover:block z-50 animate-fade-in">
                        <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-lg">
                            <!-- Arrow -->
                            <div class="absolute bottom-full right-4 -mb-1">
                                <div class="w-2 h-2 bg-gray-900 transform rotate-45"></div>
                            </div>
                            <div class="font-semibold">Quick Actions</div>
                            <div x-show="notificationCount > 0" class="text-red-300 text-[10px] mt-0.5" style="display: none;">
                                <span x-text="notificationCount"></span> pending notification<span x-show="notificationCount > 1">s</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @endrole
            </div>
        </div>
    </header>

    <!-- Mobile slide-in menu is now handled in member-topbar component -->

</div>