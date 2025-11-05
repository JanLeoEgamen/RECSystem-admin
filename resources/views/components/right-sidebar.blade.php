@php
    // Get notifications if not passed as prop
    if (!isset($notifications)) {
        $notifications = [];
        if (auth()->check() && auth()->user()->hasRole('superadmin')) {
            $pendingStudentApplicants = \App\Models\Applicant::where('status', 'pending')
                ->where('is_student', true)
                ->count();
            
            $pendingNonStudentApplicants = \App\Models\Applicant::where('status', 'pending')
                ->where('is_student', false)
                ->count();

            $pendingLicensedApplicants = \App\Models\Applicant::where('status', 'pending')
                ->where('has_license', true)
                ->count();
            
            $pendingUnlicensedApplicants = \App\Models\Applicant::where('status', 'pending')
                ->where('has_license', false)
                ->count();

            if ($pendingStudentApplicants > 0) {
                $notifications[] = [
                    'id' => 'student_applicants',
                    'type' => 'student',
                    'message' => $pendingStudentApplicants . ' student ' . ($pendingStudentApplicants === 1 ? 'applicant' : 'applicants') . ' awaiting approval',
                    'count' => $pendingStudentApplicants,
                    'icon' => 'student',
                    'color' => 'blue'
                ];
            }

            if ($pendingNonStudentApplicants > 0) {
                $notifications[] = [
                    'id' => 'regular_applicants',
                    'type' => 'regular',
                    'message' => $pendingNonStudentApplicants . ' regular ' . ($pendingNonStudentApplicants === 1 ? 'applicant' : 'applicants') . ' awaiting approval',
                    'count' => $pendingNonStudentApplicants,
                    'icon' => 'user',
                    'color' => 'purple'
                ];
            }

            if ($pendingLicensedApplicants > 0) {
                $notifications[] = [
                    'id' => 'licensed_applicants',
                    'type' => 'licensed',
                    'message' => $pendingLicensedApplicants . ' licensed ' . ($pendingLicensedApplicants === 1 ? 'applicant' : 'applicants') . ' pending review',
                    'count' => $pendingLicensedApplicants,
                    'icon' => 'license',
                    'color' => 'green'
                ];
            }

            if ($pendingUnlicensedApplicants > 0) {
                $notifications[] = [
                    'id' => 'unlicensed_applicants',
                    'type' => 'unlicensed',
                    'message' => $pendingUnlicensedApplicants . ' unlicensed ' . ($pendingUnlicensedApplicants === 1 ? 'applicant' : 'applicants') . ' pending review',
                    'count' => $pendingUnlicensedApplicants,
                    'icon' => 'unlicense',
                    'color' => 'orange'
                ];
            }
        }
    }
@endphp

@role('superadmin')
@can('view admin dashboard')
<!-- Right Sidebar -->
<aside 
    x-show="rightSidebarOpen"
    @click.away="rightSidebarOpen = false"
    class="fixed inset-y-0 right-0 z-40 w-64 md:w-72 xl:w-80 flex flex-col bg-[#101966] dark:bg-gray-900 right-sidebar-shadow"
    style="margin-top: 4rem; height: calc(100vh - 4rem); display: none;"
    x-transition:enter="transform transition-all duration-300 ease-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transform transition-all duration-300 ease-in"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
>
    <!-- Sidebar Header -->
    <div class="px-4 py-3 flex items-center justify-center relative">
        <h2 class="text-base md:text-lg font-semibold text-white dark:text-gray-200 flex items-center">
            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Quick Actions
        </h2>
        <button @click="rightSidebarOpen = false" class="p-1 rounded-md hover:bg-white/10 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-gray-200 absolute right-4">
            <svg class="h-4 w-4 md:h-5 md:w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-left p-3 md:p-4 space-y-3 md:space-y-4"
         x-data="{ 
             notifications: [],
             activeNotification: 0,
             init() {
                 // Get reviewed notifications from localStorage
                 let reviewedNotifications = JSON.parse(localStorage.getItem('reviewedNotifications') || '[]');
                 
                 // Filter out already reviewed notifications
                 let allNotifications = @js($notifications);
                 this.notifications = allNotifications.filter(notification => {
                     return !reviewedNotifications.includes(notification.id);
                 });
             },
             getApplicantFilterUrl(type) {
                 const baseUrl = '{{ route('applicants.index') }}';
                 
                 // Map notification types to filter parameters
                 const filterMap = {
                     'student': 'student_filter=1',
                     'regular': 'student_filter=0',
                     'licensed': 'license_filter=licensed',
                     'unlicensed': 'license_filter=unlicensed'
                 };
                 
                 const filter = filterMap[type] || '';
                 return filter ? `${baseUrl}?${filter}` : baseUrl;
             },
             removeNotification(index) {
                 let notificationId = this.notifications[index].id;
                 
                 // Remove from current array
                 this.notifications.splice(index, 1);
                 
                 // Store reviewed notification ID in localStorage
                 let reviewedNotifications = JSON.parse(localStorage.getItem('reviewedNotifications') || '[]');
                 if (!reviewedNotifications.includes(notificationId)) {
                     reviewedNotifications.push(notificationId);
                 }
                 localStorage.setItem('reviewedNotifications', JSON.stringify(reviewedNotifications));
             },
             clearReviewedNotifications() {
                 localStorage.removeItem('reviewedNotifications');
                 localStorage.removeItem('dashboardNotificationsViewed');
                 window.location.reload();
             }
         }"
         @toggle-right-sidebar.window="$el.closest('aside').style.display = 'flex'; rightSidebarOpen = true">

        <!-- Notifications Section -->
        @if(count($notifications) > 0)
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-lg md:rounded-xl lg:rounded-2xl p-3 sm:p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.05s">

            <div class="flex justify-between items-center mb-3 sm:mb-4 md:mb-6">
                <h3 class="text-xs sm:text-sm md:text-md font-bold text-white dark:text-gray-100 flex items-center">
                    <div class="relative mr-1.5 sm:mr-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#5E6FFB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <!-- Notification badge -->
                        <template x-if="notifications.length > 0">
                            <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5 sm:h-3 sm:w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 sm:h-3 sm:w-3 bg-red-500 text-white text-[7px] sm:text-[8px] items-center justify-center font-bold" x-text="notifications.length"></span>
                            </span>
                        </template>
                    </div>
                    <span class="hidden sm:inline">Notifications</span>
                    <span class="sm:hidden">Notifs</span>
                </h3>
                <button @click="clearReviewedNotifications()"
                        class="flex items-center gap-1 text-[10px] sm:text-xs text-blue-300 hover:text-blue-200 underline transition-colors duration-200"
                        title="Reset all notifications">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </button>
            </div>

            <!-- Notifications List -->
            <div class="space-y-2 sm:space-y-3">
                <!-- Empty state when no notifications -->
                <template x-if="notifications.length === 0">
                    <div class="text-center py-6 sm:py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-white bg-opacity-10 rounded-full mb-3 sm:mb-4">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white text-opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-white text-opacity-70 text-xs sm:text-sm font-medium mb-1">All caught up!</p>
                        <p class="text-white text-opacity-50 text-[10px] sm:text-xs">No pending notifications at the moment.</p>
                    </div>
                </template>

                <!-- Notification cards -->
                <template x-for="(notification, index) in notifications" :key="index">
                    <div class="relative overflow-hidden rounded-md sm:rounded-lg p-2 sm:p-3 transition-all duration-300 hover:scale-[1.02]"
                         :class="{
                             'bg-gradient-to-r from-blue-500/20 to-blue-600/20 border border-blue-400/30': notification.color === 'blue',
                             'bg-gradient-to-r from-purple-500/20 to-purple-600/20 border border-purple-400/30': notification.color === 'purple',
                             'bg-gradient-to-r from-green-500/20 to-green-600/20 border border-green-400/30': notification.color === 'green',
                             'bg-gradient-to-r from-orange-500/20 to-orange-600/20 border border-orange-400/30': notification.color === 'orange'
                         }">

                        <div class="relative z-10 flex items-start space-x-2 sm:space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-md sm:rounded-lg p-1.5 sm:p-2">
                                        <!-- Student Icon -->
                                        <template x-if="notification.icon === 'student'">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                            </svg>
                                        </template>
                                        <!-- User Icon -->
                                        <template x-if="notification.icon === 'user'">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </template>
                                        <!-- License Icon -->
                                        <template x-if="notification.icon === 'license'">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path>
                                                <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                            </svg>
                                        </template>
                                        <!-- Unlicense Icon -->
                                        <template x-if="notification.icon === 'unlicense'">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-1 sm:space-x-2 mb-1">
                                    <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-red-500 text-white uppercase tracking-wide new-badge">
                                        New
                                    </span>
                                    <span class="text-white text-opacity-80 text-[8px] sm:text-[10px] font-medium uppercase tracking-wide" x-text="notification.type"></span>
                                </div>
                                <p class="text-white text-xs sm:text-sm font-semibold mb-1.5 sm:mb-2 line-clamp-2" x-text="notification.message"></p>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-1.5 sm:space-x-2">
                                    <a :href="getApplicantFilterUrl(notification.type)" 
                                       @click="removeNotification(index)"
                                       class="inline-flex items-center px-1.5 sm:px-2 py-0.5 sm:py-1 bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded text-white text-[10px] sm:text-xs font-medium transition-all duration-200">
                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-0.5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Review</span>
                                        <span class="sm:hidden">View</span>
                                    </a>
                                    <span class="text-white text-opacity-60 text-[8px] sm:text-[10px] hidden sm:inline" x-text="'Priority: ' + (index + 1)"></span>
                                </div>
                            </div>

                            <!-- Count Badge -->
                            <div class="flex-shrink-0">
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs sm:text-sm" x-text="notification.count"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Info Footer -->
            <template x-if="notifications.length > 0">
                <div class="mt-3 sm:mt-4 p-2 sm:p-3 bg-white bg-opacity-5 rounded-md sm:rounded-lg border border-white border-opacity-10">
                    <div class="flex items-start space-x-1.5 sm:space-x-2">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-white text-opacity-70 text-[10px] sm:text-xs">
                            These notifications require your immediate attention. Click <span class="hidden sm:inline">"Review"</span><span class="sm:hidden">"View"</span> to process applicants.
                        </p>
                    </div>
                </div>
            </template>
        </div>
        @endif

        <!-- Membership Section -->
        @canany(['view applicants', 'view members', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.1s">

            <div class="flex justify-center items-center mb-4 md:mb-6">
                <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 0 014 0z"/>
                    </svg>
                    Membership
                </h3>
            </div>
            
            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                <!-- DELETED ADD APPLICANT CAUSE ITS BEEN HIDDEN -->
                
                <!-- Add Member -->
                <div class="group sidebar-item animate" style="animation-delay: 0.2s">
                    <a href="{{ route('members.showMemberCreateForm') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500/20 dark:bg-blue-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-blue-500/30 dark:group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">
                                Add<span class="block md:hidden"></span><span class="hidden md:inline"> </span>Member
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Add Report -->
                <div class="group sidebar-item animate" style="animation-delay: 0.2s">
                    <a href="{{ route('reports.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500/20 dark:bg-blue-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-blue-500/30 dark:group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">
                                Create<span class="block md:hidden"></span><span class="hidden md:inline"> </span>Report
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Assess Applicants -->
                <div class="group sidebar-item animate" style="animation-delay: 0.25s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-amber-500/20 dark:bg-amber-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-amber-500/30 dark:group-hover:bg-amber-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-amber-300 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">Assess Applicants</span>
                        </div>
                    </a>
                </div>

                <!-- Renew Members -->
                <div class="group sidebar-item animate" style="animation-delay: 0.3s">
                    <a href="#"
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-purple-500/20 dark:bg-purple-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-purple-500/30 dark:group-hover:bg-purple-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-purple-300 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">Renew Members</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endcanany

        <!-- Website Content Section -->
        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.35s">

            <div class="flex justify-center items-center mb-4 md:mb-6">
                <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-[#5E6FFB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 3a9 9 0 100 18 9 9 0 000-18zm0 0c3.866 0 7 4.03 7 9s-3.134 9-7 9-7-4.03-7-9 3.134-9 7-9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3.6 9h16.8M3.6 15h16.8" />
                    </svg>
                    Website Content
                </h3>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                @can('view event-announcements')
                <div class="group sidebar-item animate" style="animation-delay: 0.4s">
                    <a href="{{ route('event-announcements.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 dark:bg-red-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-red-500/30 dark:group-hover:bg-red-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-red-300 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Event</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view articles')
                <div class="group sidebar-item animate" style="animation-delay: 0.45s">
                    <a href="{{ route('articles.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-green-500/20 dark:bg-green-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-green-500/30 dark:group-hover:bg-green-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-green-300 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h6l2 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 3v4M13 3h-2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Article</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view markees')
                <div class="group sidebar-item animate" style="animation-delay: 0.5s">
                    <a href="{{ route('markees.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-pink-500/20 dark:bg-pink-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-pink-500/30 dark:group-hover:bg-pink-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-pink-300 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v16M19 7l-7 4-7-4V3l7 4 7-4v4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Markee</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view faqs')
                <div class="group sidebar-item animate" style="animation-delay: 0.55s">
                    <a href="{{ route('faqs.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-yellow-500/20 dark:bg-yellow-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-yellow-500/30 dark:group-hover:bg-yellow-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-yellow-300 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.257 11.238a4 4 0 116.486 3.122M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New FAQ</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view communities')
                <div class="group sidebar-item animate" style="animation-delay: 0.6s">
                    <a href="{{ route('communities.index') }}" 
                       class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500/20 dark:bg-blue-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-blue-500/30 dark:group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Community</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view supporters')
                <div class="group sidebar-item animate" style="animation-delay: 0.65s">
                    <a href="{{ route('supporters.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-teal-500/20 dark:bg-teal-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-teal-500/30 dark:group-hover:bg-teal-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-teal-300 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.382 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">
                                New<span class="block md:hidden"></span><span class="hidden md:inline"> </span>Supporters
                            </span>
                        </div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- User Management Section -->
        @canany(['view bureaus', 'view sections', 'view users', 'view roles', 'view permissions'])
        <div class="bg-gradient-to-br from-[#3b3f7a]/90 via-[#4C5091]/90 to-[#2e3060]/90
                dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
                backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg md:shadow-2xl border border-white/10 dark:border-gray-700 sidebar-item animate" 
            style="animation-delay: 0.7s">

            <div class="flex items-center mb-4 md:mb-6">
                <div class="relative"></div>
                <div class="ml-4">
                    <h3 class="text-sm md:text-md font-bold text-white dark:text-gray-100 mb-1 flex items-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-3 text-[#5E6FFB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                        User Management
                    </h3>
                </div>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                @can('view bureaus')
                <div class="group sidebar-item animate" style="animation-delay: 0.75s">
                    <a href="{{ route('bureaus.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-orange-500/20 dark:bg-orange-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-orange-500/30 dark:group-hover:bg-orange-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-orange-300 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M4 21V5a1 1 0 011-1h14a1 1 0 011 1v16M9 21V9h6v12"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Bureau</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view sections')
                <div class="group sidebar-item animate" style="animation-delay: 0.8s">
                    <a href="{{ route('sections.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-cyan-500/20 dark:bg-cyan-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-cyan-500/30 dark:group-hover:bg-cyan-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-cyan-300 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h4V8H3z M9 14v7h4v-11H9z M15 10v11h4V10h-4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Section</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view users')
                <div class="group sidebar-item animate" style="animation-delay: 0.85s">
                    <a href="{{ route('users.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-lime-500/20 dark:bg-lime-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-lime-500/30 dark:group-hover:bg-lime-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-lime-300 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM21 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New User</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view roles')
                <div class="group sidebar-item animate" style="animation-delay: 0.9s">
                    <a href="{{ route('roles.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-rose-500/20 dark:bg-rose-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-rose-500/30 dark:group-hover:bg-rose-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-rose-300 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 3l9 4-9 4-9-4 9-4z"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Role</span>
                        </div>
                    </a>
                </div>
                @endcan

                @can('view permissions')
                <div class="group sidebar-item animate" style="animation-delay: 0.95s">
                    <a href="{{ route('permissions.index') }}" 
                    class="action-card block p-2 md:p-3 bg-white/10 hover:bg-white/20 dark:bg-gray-800/40 dark:hover:bg-gray-700/50 rounded-lg border border-white/10 dark:border-gray-700 hover:border-white/30 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-violet-500/20 dark:bg-violet-600/30 rounded-md flex items-center justify-center mb-1 md:mb-2 group-hover:bg-violet-500/30 dark:group-hover:bg-violet-600/40 transition-colors">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-violet-300 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <span class="text-white dark:text-gray-200 font-medium text-xs">New Permission</span>
                        </div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
        @endcanany
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-3 text-center">
        <div class="text-xs text-gray-400 dark:text-gray-500 mb-1">System Version: BETA</div>
        <div class="text-xs text-gray-400 dark:text-gray-500">Last Updated: {{ now()->format('M d, Y') }}</div>
    </div>
</aside>

<style>
.action-card {
    position: relative;
    overflow: hidden;
}
.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
}
.action-card:hover::before {
    left: 100%;
}
.action-card:active {
    transform: scale(0.98) !important;
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-2px); }
}
.group:hover .action-card {
    animation: float 2s ease-in-out infinite;
}

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

.new-badge {
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

@media (max-width: 768px) {
    .right-sidebar-shadow {
        box-shadow: -4px 0 10px rgba(0, 0, 0, 0.2);
    }
}

@media (max-width: 640px) {
    .scrollbar-left::-webkit-scrollbar {
        width: 4px;
    }
}

/* Hide horizontal scrollbar on right sidebar */
aside .overflow-y-auto {
    overflow-x: hidden !important;
}

aside .overflow-y-auto::-webkit-scrollbar-x {
    display: none;
}

aside .overflow-y-auto {
    -ms-overflow-style: none;
    scrollbar-width: thin;
}
</style>
@endcan
@endrole