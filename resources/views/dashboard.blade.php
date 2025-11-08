<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .grid-row {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .row-1 {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .row-2 {
        grid-template-columns: 2fr 1fr;
    }
    
    .row-3 {
        grid-template-columns: 1fr 1fr;
    }
    
    .row-4 {
        grid-template-columns: 1fr 2fr;
    }
    
    .card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.005);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    
    .dark .card {
        background: #1f2937;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .dark .visitors-card {
        background: #1f2937;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @role('superadmin')
    <!-- Notification Toast Container - Only for Superadmin on Dashboard -->
    @if(count($notifications) > 0)
    <div x-data="{ 
        notifications: {{ json_encode($notifications) }},
        activeIndex: 0,
        show: true,
        hasCompletedCycle: false,
        init() {
            // Check if notifications should be shown based on localStorage
            let dashboardViewed = localStorage.getItem('dashboardNotificationsViewed');
            let reviewedNotifications = JSON.parse(localStorage.getItem('reviewedNotifications') || '[]');
            
            // Only hide if dashboard was viewed AND there are no new unreviewed notifications
            let hasUnreviewed = this.notifications.some(n => !reviewedNotifications.includes(n.id));
            this.show = hasUnreviewed || !dashboardViewed;
            
            // Auto-rotate notifications every 5 seconds
            setInterval(() => {
                if (this.notifications.length > 1 && this.show && !this.hasCompletedCycle) {
                    this.activeIndex++;
                    // Check if we've completed a full cycle
                    if (this.activeIndex >= this.notifications.length) {
                        this.hasCompletedCycle = true;
                        // Hide notification bar after completing the cycle
                        setTimeout(() => {
                            this.hideNotifications();
                        }, 3000); // Wait 3 seconds before hiding
                    }
                }
            }, 5000);
        },
        hideNotifications() {
            this.show = false;
            localStorage.setItem('dashboardNotificationsViewed', 'true');
        },
        viewInQuickActions() {
            this.hideNotifications();
            // Open right sidebar
            window.dispatchEvent(new CustomEvent('toggle-right-sidebar'));
        },
        getNotificationUrl(type) {
            // Map notification types to their respective routes
            const routeMap = {
                'student': '{{ route('student-applicants.index') }}',
                'regular': '{{ route('applicants.index') }}?student_filter=0',
                'licensed': '{{ route('applicants.index') }}?license_filter=licensed',
                'unlicensed': '{{ route('applicants.index') }}?license_filter=unlicensed'
            };
            
            return routeMap[type] || '{{ route('applicants.index') }}';
        }
    }" 
    x-show="show"
    @toggle-right-sidebar.window="hideNotifications()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-[-100%]"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-[-100%]"
    class="fixed top-16 left-0 right-0 z-40 px-2 sm:px-4 lg:px-8"
    style="display: none;">
        <div class="max-w-3xl mx-auto mt-2 sm:mt-4">
            <template x-for="(notification, index) in notifications" :key="index">
                <div x-show="activeIndex === index"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="relative overflow-hidden rounded-lg sm:rounded-xl shadow-lg sm:shadow-2xl"
                     :class="{
                         'bg-gradient-to-r from-blue-500 to-blue-600': notification.color === 'blue',
                         'bg-gradient-to-r from-purple-500 to-purple-600': notification.color === 'purple',
                         'bg-gradient-to-r from-green-500 to-green-600': notification.color === 'green',
                         'bg-gradient-to-r from-orange-500 to-orange-600': notification.color === 'orange'
                     }">
                    
                    <!-- Animated background pattern -->
                    <div class="absolute inset-0 opacity-10 hidden sm:block">
                        <svg class="w-full h-full" viewBox="0 0 400 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="350" cy="20" r="30" fill="white" opacity="0.3"/>
                            <circle cx="380" cy="60" r="20" fill="white" opacity="0.2"/>
                            <circle cx="30" cy="30" r="25" fill="white" opacity="0.3"/>
                            <circle cx="50" cy="70" r="15" fill="white" opacity="0.2"/>
                        </svg>
                    </div>

                    <div class="relative z-10 p-1.5 sm:p-3 md:p-4 flex items-center justify-between gap-2 sm:gap-4">
                        <!-- Left side: Icon and Message -->
                        <div class="flex items-center space-x-2 sm:space-x-3 flex-1 min-w-0">
                            <!-- Animated Icon Container -->
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <!-- Pulsing background -->
                                    <div class="absolute inset-0 bg-white rounded-full animate-ping opacity-20 hidden sm:block"></div>
                                    <div class="relative bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-1.5 sm:p-2 ring-1 sm:ring-2 ring-white ring-opacity-50">
                                        <!-- Student Icon -->
                                        <template x-if="notification.icon === 'student'">
                                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                            </svg>
                                        </template>
                                        <!-- User Icon -->
                                        <template x-if="notification.icon === 'user'">
                                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </template>
                                        <!-- License Icon -->
                                        <template x-if="notification.icon === 'license'">
                                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path>
                                                <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                            </svg>
                                        </template>
                                        <!-- Unlicense Icon -->
                                        <template x-if="notification.icon === 'unlicense'">
                                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-1 sm:space-x-2 mb-0.5">
                                    <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-bold bg-red-500 text-white uppercase tracking-wide new-badge-dashboard">
                                        New
                                    </span>
                                    <span class="text-white text-opacity-90 text-[10px] sm:text-xs font-medium hidden sm:inline" x-text="notification.type + ' applicants'"></span>
                                </div>
                                <p class="text-white font-semibold text-xs sm:text-sm md:text-base truncate sm:whitespace-normal" x-text="notification.message"></p>
                                <div class="mt-1 sm:mt-1.5 flex flex-wrap items-center gap-1 sm:gap-2">
                                    <a :href="getNotificationUrl(notification.type)" 
                                       class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-md sm:rounded-lg text-white text-[10px] sm:text-sm font-medium transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Review Now</span>
                                        <span class="sm:hidden">Review</span>
                                    </a>
                                    <button @click="viewInQuickActions()"
                                       class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 bg-white bg-opacity-10 hover:bg-opacity-20 backdrop-blur-sm rounded-md sm:rounded-lg text-white text-[10px] sm:text-sm font-medium transition-all duration-200 transform hover:scale-105 border border-white border-opacity-30">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span class="hidden sm:inline">View in Quick Actions</span>
                                        <span class="sm:hidden">Quick Actions</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right side: Close button & Navigation -->
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <!-- Navigation dots (if multiple notifications) -->
                            <template x-if="notifications.length > 1">
                                <div class="hidden md:flex items-center space-x-1.5">
                                    <template x-for="(n, i) in notifications" :key="i">
                                        <button @click="activeIndex = i"
                                                class="w-2 h-2 rounded-full transition-all duration-200"
                                                :class="activeIndex === i ? 'bg-white w-6' : 'bg-white bg-opacity-40 hover:bg-opacity-60'">
                                        </button>
                                    </template>
                                </div>
                            </template>

                            <!-- Close Button -->
                            <button @click="hideNotifications()" 
                                    class="flex-shrink-0 p-1 sm:p-1.5 rounded-lg bg-white bg-opacity-0 hover:bg-opacity-20 transition-all duration-200 group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Progress bar for auto-rotation -->
                    <template x-if="notifications.length > 1 && !hasCompletedCycle">
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 sm:h-1 bg-white bg-opacity-20">
                            <div class="h-full bg-white animate-progress" style="animation: progress 5s linear infinite;"></div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <style>
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }
        .animate-progress {
            animation: progress 5s linear infinite;
        }

        /* Pulsing animation for NEW badge */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        /* Shining effect for NEW badge */
        @keyframes shine {
            0% {
                background-position: -100% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        .new-badge-dashboard {
            position: relative;
            overflow: hidden;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            background: linear-gradient(
                90deg,
                #ef4444 0%,
                #ef4444 40%,
                #fff 50%,
                #ef4444 60%,
                #ef4444 100%
            );
            background-size: 200% 100%;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite, 
                       shine 3s linear infinite;
        }
    </style>

    @endif
    @endrole

    <!-- Welcome Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-down" style="animation-delay: 0.1s;">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-400 dark:border-gray-700">
            
            <!-- Left Section -->
            <div class="mb-4 sm:mb-0 sm:mr-6 flex-1">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Hello, {{ $fullName }}, Welcome Back!
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">
                    You're Logged In - The system is up-to-date
                </p>
            </div>

            <!-- Right Section -->
            <div class="text-left sm:text-right w-full sm:w-auto">
                <p class="text-lg text-gray-800 dark:text-gray-200">
                    <span id="dashboardDay" class="font-semibold"></span>
                    <span id="dashboardDate"></span>
                </p>
                <p id="dashboardTime" class="text-xl font-bold mt-1 text-gray-900 dark:text-white"></p>
            </div>
        </div>
    </div>


    <script>
        function updateDashboardTime() {
            const now = new Date();
            const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            const dayName = days[now.getDay()];
            const dateStr = now.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            document.getElementById('dashboardDay').textContent = `${dayName}, `;
            document.getElementById('dashboardDate').textContent = dateStr;
            document.getElementById('dashboardTime').textContent = timeStr;
        }

        updateDashboardTime();
        setInterval(updateDashboardTime, 1000);
    </script>

    @cannot('superadmin')
    <!-- Welcome Design for Non-Superadmin Roles -->
    <div class="py-8 animate-fade-in-down" style="animation-delay: 0.2s;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-gradient-to-br from-[#101966] via-[#5e6ffb] to-[#1A25A1] rounded-2xl shadow-2xl">
                <!-- Radio Wave Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Top-right radio waves -->
                        <g transform="translate(320, 50)">
                            <circle cx="0" cy="0" r="20" stroke="white" stroke-width="2" fill="none" opacity="0.3"/>
                            <circle cx="0" cy="0" r="35" stroke="white" stroke-width="1.5" fill="none" opacity="0.25"/>
                            <circle cx="0" cy="0" r="50" stroke="white" stroke-width="1" fill="none" opacity="0.2"/>
                            <circle cx="0" cy="0" r="65" stroke="white" stroke-width="0.8" fill="none" opacity="0.15"/>
                            <!-- Central transmitter dot -->
                            <circle cx="0" cy="0" r="4" fill="white" opacity="0.4"/>
                        </g>
                        
                        <!-- Bottom-left radio waves -->
                        <g transform="translate(80, 350)">
                            <circle cx="0" cy="0" r="25" stroke="white" stroke-width="2" fill="none" opacity="0.25"/>
                            <circle cx="0" cy="0" r="40" stroke="white" stroke-width="1.5" fill="none" opacity="0.2"/>
                            <circle cx="0" cy="0" r="55" stroke="white" stroke-width="1" fill="none" opacity="0.15"/>
                            <circle cx="0" cy="0" r="70" stroke="white" stroke-width="0.8" fill="none" opacity="0.1"/>
                            <!-- Central transmitter dot -->
                            <circle cx="0" cy="0" r="4" fill="white" opacity="0.3"/>
                        </g>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="relative z-10 px-8 py-12 text-center">
                    <div class="mb-6">
                        <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                            <span class="text-white font-semibold text-lg">
                                {{ ucfirst(auth()->user()->getRoleNames()->first()) }} Dashboard
                            </span>
                        </div>
                    </div>
                    
                    <p class="text-xl text-white text-opacity-90 mb-8 max-w-2xl mx-auto leading-relaxed">
                        You're successfully logged in to the Radio Engineering Circle Inc. management system. 
                        Everything is running smoothly and ready for your operations.
                    </p>
                    
                    <!-- Status Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 border border-white border-opacity-20">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-500 bg-opacity-20 rounded-lg mx-auto mb-4">
                                <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-semibold mb-2">System Status</h3>
                            <p class="text-white text-opacity-80 text-sm">All systems operational</p>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 border border-white border-opacity-20">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-semibold mb-2">Security</h3>
                            <p class="text-white text-opacity-80 text-sm">Your session is secure</p>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 border border-white border-opacity-20">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-500 bg-opacity-20 rounded-lg mx-auto mb-4">
                                <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-semibold mb-2">Performance</h3>
                            <p class="text-white text-opacity-80 text-sm">Running at optimal speed</p>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    @endcannot

    <div class="py-6 animate-fade-in-down" style="animation-delay: 0.2s;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @role('superadmin')
            <!-- Row 1: CARDS -->
            <div class=" grid-row row-1 mb-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Members -->
                <a href="{{ route('members.index') }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#101966] via-[#5e6ffb] to-[#E0F2FF] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.3s;">
                
                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 
                                    20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 
                                    20H2v-2a3 3 0 015.356-1.857M7 
                                    20v-2c0-.656.126-1.283.356-1.857m0 
                                    0a5.002 5.002 0 019.288 0M15 
                                    7a3 3 0 11-6 0 3 3 0 016 
                                    0zm6 3a2 2 0 11-4 0 2 2 
                                    0 014 0zM7 10a2 2 0 11-4 
                                    0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold truncate text-white/90 drop-shadow-md">Total Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $totalMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Active Members -->
                <a href="{{ route('members.index', ['status_filter' => 'active']) }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#16A34A] to-[#D1FAE5] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.4s;">

                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 
                                2a9 9 0 11-18 0 9 9 0 0118 
                                0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Active Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $activeMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Inactive Members -->
                <a href="{{ route('members.index', ['status_filter' => 'inactive']) }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#F94261] via-[#F75E77] to-[#FECACA] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.45s;">

                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 
                                5.656l3.536 3.536M5.636 
                                5.636l3.536 3.536m0 5.656l-3.536 
                                3.536"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Inactive Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $inactiveMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Expired Members -->
                <a href="{{ route('members.index', ['status_filter' => 'expired']) }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#F66C2E] via-[#F2904D] to-[#FFEAD5] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.5s;">
                
                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>
                
                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Expired Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $expiredMembers ?? 0 }}</div>
                            </dd>
                        </div>
                    </div>
                </a>
            </div>
            @endcan

            @role('superadmin')
            <!-- Row 2: Applicant Report and Membership Growth Analysis -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Applicant Report -->
                <div class="card dark:bg-gray-800 lg:col-span-1 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Recent Applicants</h3>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-[#101966] dark:bg-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tr-lg border-r border-gray-300 dark:border-gray-600">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-800">
                                @forelse($recentApplicants->take(6) as $applicant)
                                    <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border-r border-gray-300 dark:border-gray-800">
                                            {{ $applicant->first_name }} {{ $applicant->last_name }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-center border-r border-gray-300 dark:border-gray-600">
                                            @if($applicant->status === 'Pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Pending
                                                </span>
                                            @elseif($applicant->status === 'Approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Approved
                                                </span>
                                            @elseif($applicant->status === 'Rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    Rejected
                                                </span>
                                            @else
                                                {{-- Default to Pending --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                            No recent applicants.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- View All Applicants Link -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('applicants.index') }}" class="inline-flex items-center text-sm font-medium text-[#5e6ffb] hover:text-[#101966] dark:text-blue-400 dark:hover:text-blue-300">
                            View All Applicants
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Membership Growth Analysis -->
                <div class="card dark:bg-gray-800 lg:col-span-2 h-full flex flex-col">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Radio Engineering Circle Inc. Membership Growth Analysis
                    </h3>
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-500 dark:text-gray-300">
                            Showing data for {{ now()->year }}
                        </span>
                    </div>

                    <div class="flex justify-end items-center mb-4">
                        <button id="exportBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container flex-1">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            @endrole

            @role('superadmin')
            <!-- Row 3: Bar Chart and Line Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Membership Type Distribution -->
                <div class="card dark:bg-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Membership Type Distribution
                    </h3>
                    
                    <div class="flex justify-end items-center mb-4">
                        <button id="exportMembershipTypeBtn" 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container">
                        <canvas id="membershipTypeChart"></canvas>
                    </div>
                </div>

                <!-- Member Distribution by Section -->
                <div class="card dark:bg-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Member Distribution by Section
                    </h3>
                    
                    <div class="flex justify-end items-center mb-4">
                        <button id="exportSectionBtn" 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container">
                        <canvas id="sectionChart"></canvas>
                    </div>
                </div>
            </div>
            @endrole

            @role('superadmin')
            <!-- Row 4: Recent Members and Memberships Expiring Soon -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Recent Members -->
                <div class="card dark:bg-gray-800 lg:col-span-1 h-full flex flex-col">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                        Recent Members
                    </h3>
                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden">
                            <thead class="bg-[#101966]  dark:bg-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Membership Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-800">
                                @foreach($recentMembers as $member)
                                    <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border-r border-gray-300 dark:border-gray-800">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border-r border-gray-300 dark:border-gray-600">
                                            {{ $member->membershipType->type_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                    <!-- Memberships Expiring Soon  -->
                    <div class="card bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg lg:col-span-2 h-full flex flex-col">
                        <div class="px-4 py-5 sm:p-6 flex-1">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                Memberships Expiring Soon
                            </h3>
                            <div class="overflow-x-auto flex-1">
                                <table class="min-w-full border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden">
                                    <thead class="bg-[#101966] dark:bg-gray-600">
                                        <tr>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border border-gray-300 dark:border-gray-600">
                                                Name
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 dark:border-gray-600">
                                                Membership End
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tr-lg border border-gray-300 dark:border-gray-600">
                                                Type
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        @forelse($expiringSoonMembers as $member)
                                            <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900  transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border border-gray-300 dark:border-gray-800">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border border-gray-300 dark:border-gray-600">
                                                    {{ \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border border-gray-300 dark:border-gray-600">
                                                    {{ $member->membershipType->type_name ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                                    No memberships expiring soon.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Monthly Chart
        const exportBtn = document.getElementById('exportBtn');
        const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthlyData = @json(array_values($monthlyData));
        const monthlyActiveData = @json(array_values($monthlyActiveData));
        const monthlyInactiveData = @json(array_values($monthlyInactiveData));
        const monthlyExpiringData = @json(array_values($monthlyExpiringData));

        function isDarkMode() {
            return document.documentElement.classList.contains('dark') || 
                   document.body.classList.contains('dark') ||
                   window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        function getTextColor() {
            return isDarkMode() ? '#FFFFFF' : '#000000';
        }

        function getGridColor() {
            return isDarkMode() ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        }

        function getTooltipBg() {
            return isDarkMode() ? '#1F2937' : '#FFFFFF';
        }

        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Total Members',
                        data: monthlyData,
                        borderColor: '#5E6FFB',
                        backgroundColor: 'rgba(94, 111, 251, 0.2)',
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Active Members',
                        data: monthlyActiveData,
                        borderColor: '#22C55E',
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Inactive Members',
                        data: monthlyInactiveData,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Expiring Soon',
                        data: monthlyExpiringData,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderDash: [5, 5],
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Membership Analysis',
                        font: { size: 16 },
                        color: getTextColor()
                    },
                    tooltip: {
                        backgroundColor: getTooltipBg(),
                        titleColor: getTextColor(),
                        bodyColor: getTextColor(),
                        borderColor: getTextColor(),
                        borderWidth: isDarkMode() ? 0 : 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                label += context.parsed.y;
                                return label;
                            }
                        }
                    },
                    legend: { 
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            color: getTextColor()
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { 
                            display: true, 
                            text: 'Total Members',
                            color: getTextColor()
                        },
                        ticks: {
                            color: getTextColor(),
                            precision: 0,
                            callback: function(value) {
                                if (Number.isInteger(value)) return value;
                            },
                            stepSize: 1
                        },
                        grid: {
                            color: getGridColor()
                        },
                        min: 0
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { 
                            drawOnChartArea: false,
                            color: getGridColor()
                        },
                        title: { 
                            display: true, 
                            text: 'Active/Inactive/Expiring Members',
                            color: getTextColor()
                        },
                        ticks: {
                            color: getTextColor(),
                            precision: 0,
                            callback: function(value) {
                                if (Number.isInteger(value)) return value;
                            },
                            stepSize: 1
                        },
                        min: 0
                    },
                    x: {
                        ticks: {
                            color: getTextColor()
                        },
                        grid: {
                            color: getGridColor()
                        }
                    }
                }
            }
        });

        function updateChartColors() {
            const textColor = getTextColor();
            const gridColor = getGridColor();
            const tooltipBg = getTooltipBg();

            monthlyChart.options.plugins.title.color = textColor;
            monthlyChart.options.plugins.tooltip.backgroundColor = tooltipBg;
            monthlyChart.options.plugins.tooltip.titleColor = textColor;
            monthlyChart.options.plugins.tooltip.bodyColor = textColor;
            monthlyChart.options.plugins.tooltip.borderColor = textColor;
            monthlyChart.options.plugins.tooltip.borderWidth = isDarkMode() ? 0 : 1;
            monthlyChart.options.plugins.legend.labels.color = textColor;

            monthlyChart.options.scales.y.title.color = textColor;
            monthlyChart.options.scales.y.ticks.color = textColor;
            monthlyChart.options.scales.y.grid.color = gridColor;
            monthlyChart.options.scales.y1.title.color = textColor;
            monthlyChart.options.scales.y1.ticks.color = textColor;
            monthlyChart.options.scales.y1.grid.color = gridColor;
            monthlyChart.options.scales.x.ticks.color = textColor;
            monthlyChart.options.scales.x.grid.color = gridColor;

            monthlyChart.update();
        }

        // Monthly Chart Export
        exportBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'monthly_membership_data_' + new Date().getFullYear() + '.csv';
            let headers = ['Month', 'Total Members', 'Active Members', 'Inactive Members', 'Expiring Soon'];
            
            exportData = monthlyLabels.map((month, index) => [
                month,
                monthlyData[index] || 0,
                monthlyActiveData[index] || 0,
                monthlyInactiveData[index] || 0,
                monthlyExpiringData[index] || 0
            ]);
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');          
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Membership Type Chart Export
        const exportMembershipTypeBtn = document.getElementById('exportMembershipTypeBtn');
        exportMembershipTypeBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'membership_type_distribution.csv';
            let headers = ['Membership Type', 'Count', 'Percentage'];
            
            const total = Object.values(@json($membershipTypeCounts)).reduce((a, b) => a + b, 0);
            
            Object.entries(@json($membershipTypeCounts)).forEach(([type, count]) => {
                const percentage = ((count / total) * 100).toFixed(2);
                exportData.push([type, count, `${percentage}%`]);
            });
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Section Chart Export
        const exportSectionBtn = document.getElementById('exportSectionBtn');
        exportSectionBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'section_distribution.csv';
            let headers = ['Section', 'Count', 'Percentage'];
            
            const total = Object.values(@json($sectionCounts)).reduce((a, b) => a + b, 0);
            
            Object.entries(@json($sectionCounts)).forEach(([section, count]) => {
                const percentage = ((count / total) * 100).toFixed(2);
                exportData.push([section, count, `${percentage}%`]);
            });
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Membership Type Polar Chart
        const membershipTypeCtx = document.getElementById('membershipTypeChart').getContext('2d');
        const membershipTypeData = {
            labels: @json(array_keys($membershipTypeCounts)),
            datasets: [{
                data: @json(array_values($membershipTypeCounts)),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        const membershipTypeChart = new Chart(membershipTypeCtx, {
            type: 'polarArea',
            data: membershipTypeData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'white' : Chart.defaults.plugins.legend.labels.color;
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        titleColor: function(context) {
                            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                            return isDarkMode ? 'white' : Chart.defaults.plugins.tooltip.titleColor;
                        },
                        bodyColor: function(context) {
                            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                            return isDarkMode ? 'white' : Chart.defaults.plugins.tooltip.bodyColor;
                        }
                    }
                },
                scales: {
                    r: {
                        pointLabels: {
                            display: true,
                            centerPointLabels: true,
                            font: {
                                size: 12
                            },
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'white' : Chart.defaults.scales.radialLinear.pointLabels.color;
                            }
                        },
                        ticks: {
                            display: false,
                            stepSize: 1,
                            backdropColor: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(0, 0, 0, 0)' : Chart.defaults.scales.radialLinear.ticks.backdropColor;
                            }
                        },
                        angleLines: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(255, 255, 255, 0.2)' : Chart.defaults.scales.radialLinear.angleLines.color;
                            }
                        },
                        grid: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(255, 255, 255, 0.2)' : Chart.defaults.scales.radialLinear.grid.color;
                            }
                        }
                    }
                }
            }
        });

        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                membershipTypeChart.update();
            });
        }

        // Section Doughnut Chart 
        const sectionCtx = document.getElementById('sectionChart').getContext('2d');
        const sectionData = {
            labels: @json(array_keys($sectionCounts)),
            datasets: [{
                data: @json(array_values($sectionCounts)),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(199, 199, 199, 0.7)',
                    'rgba(83, 102, 255, 0.7)',
                    'rgba(40, 159, 64, 0.7)',
                    'rgba(210, 99, 132, 0.7)',
                    'rgba(20, 162, 235, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(40, 159, 64, 1)',
                    'rgba(210, 99, 132, 1)',
                    'rgba(20, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        };

        const sectionChart = new Chart(sectionCtx, {
            type: 'doughnut',
            data: sectionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: getTextColor()
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        backgroundColor: getTooltipBg(), 
                        titleColor: getTextColor(), 
                        bodyColor: getTextColor(), 
                        borderColor: getTextColor(), 
                        borderWidth: isDarkMode() ? 0 : 1 
                    }
                },
                cutout: '60%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        function updateAllChartColors() {
            updateChartColors(); 
            membershipTypeChart.update(); 
            sectionChart.update(); 
        }

        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', updateAllChartColors);
        }

        const observer = new MutationObserver(updateAllChartColors);
        observer.observe(document.documentElement, { 
            attributes: true, 
            attributeFilter: ['class'] 
        });
    });
</script>
</x-app-layout>