<x-app-layout>

<x-slot name="header">
    <div class="relative"> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Activity Logs for ') . $member->first_name . ' ' . $member->last_name }}
            </h2>

            <div class="px-4 py-2 bg-[#101966] dark:bg-[#5e6ffb] rounded-full backdrop-blur-sm">
                <span class="text-white text-sm font-medium">Member ID: {{ $member->id }}</span>
            </div>  
        </div>
    </div>
</x-slot>

@vite('resources/css/activity-logs.css')

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Privacy Reminder -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-6 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-1">Privacy Notice</h3>
                        <p class="text-sm text-amber-700 dark:text-amber-300">The activity logs contain sensitive information that are only accessible to you as the member and the organization. This data is kept strictly confidential.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Logs</h3>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100" id="totalLogsCount">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-up" style="animation-delay: 0.3s;">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Recent Activity</h3>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100" id="recentActivityCount">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Log Types</h3>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100" id="logTypesCount">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-up" style="animation-delay: 0.5s;">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Activity</h3>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100" id="lastActivityTime">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 mb-8 border border-gray-100 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.6s;">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#101966] dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    Filter & Search
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                        <select id="logTypeFilter" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-[#101966] focus:ring-[#101966] focus:ring-opacity-50 transition-all duration-200">
                            <option value="">All Types</option>
                            @foreach($logTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Action</label>
                        <select id="logActionFilter" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-[#101966] focus:ring-[#101966] focus:ring-opacity-50 transition-all duration-200">
                            <option value="">All Actions</option>
                            @foreach($logActions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                        <div class="relative">
                            <input type="text" id="logSearchFilter" placeholder="Search logs..." 
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 pl-10 shadow-sm focus:border-[#101966] focus:ring-[#101966] focus:ring-opacity-50 transition-all duration-200">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Actions</label>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <button id="refreshLogs" class="flex-1 px-4 py-2 bg-gradient-to-r from-[#101966] to-[#2d3a8c] text-white rounded-lg hover:from-[#0d1455] hover:to-[#253285] transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh
                            </button>
                            <button id="clearFilters" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.7s;">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-[#101966] to-[#2d3a8c]  dark:bg-gradient-to-r from-[#1A25A1] to-[#5e6ffb] border-b border-gray-200 dark:border-gray-600 relative">
                    <div class="absolute inset-x-0 bottom-0 h-px bg-white/20"></div>
                    <h3 class="text-base sm:text-lg font-semibold text-white flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="hidden sm:inline">Activity Timeline</span>
                        <span class="sm:hidden">Timeline</span>
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table id="activityLogsTable" class="w-full">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors duration-200" onclick="sortLogs('created_at_raw')">
                                    <div class="flex items-center space-x-1">
                                        <span class="hidden sm:inline">Date & Time</span>
                                        <span class="sm:hidden">Date</span>
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors duration-200" onclick="sortLogs('type')">
                                    <div class="flex items-center space-x-1">
                                        <span>Type</span>
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors duration-200" onclick="sortLogs('action')">
                                    <div class="flex items-center space-x-1">
                                        <span>Action</span>
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Details</th>
                                <th class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors duration-200" onclick="sortLogs('performed_by')">
                                    <div class="flex items-center space-x-1">
                                        <span class="hidden sm:inline">Performed By</span>
                                        <span class="sm:hidden">User</span>
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="activityLogsTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div id="activityLogsPagination" class="flex justify-center items-center"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Help Button -->
    <div class="floating-btn">
        <button onclick="showHelpModal()" class="interactive-btn p-4 bg-gradient-to-r from-[#101966] to-blue-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>

    <x-slot name="script">
        @if(!app()->runningUnitTests())
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endif
        <script>
            // Help modal function
            window.showHelpModal = function() {
                Swal.fire({
                    title: 'Activity Logs Help',
                    html: `
                        <div class="text-left space-y-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">📊 Understanding Activity Logs</h4>
                                <p class="text-sm text-blue-800 dark:text-blue-300">Activity logs track all your interactions within the system, including logins, document views, and other activities.</p>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">🔍 Filtering Options</h4>
                                <p class="text-sm text-green-800 dark:text-green-300">Use the filters above to narrow down logs by date range, activity type, or action performed.</p>
                            </div>
                            <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                                <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">🔒 Privacy & Security</h4>
                                <p class="text-sm text-amber-800 dark:text-amber-300">Your activity logs are private and only accessible to you and authorized administrators for security purposes.</p>
                            </div>
                        </div>
                    `,
                    background: '#ffffff',
                    color: '#374151',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'Got it!'
                });
            };

            const memberId = {{ $member->id }};
            let currentSortField = 'created_at_raw';
            let currentSortDirection = 'desc';
            let allLogs = [];

            // Wait for everything to be ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM fully loaded, fetching logs...');
                fetchActivityLogs(1);
                initializeEventListeners();
            });

            function initializeEventListeners() {
                // Event listeners
                $('#refreshLogs').on('click', () => {
                    showRefreshAnimation();
                    fetchActivityLogs(1);
                });
                
                $('#clearFilters').on('click', clearAllFilters);
                $('#logTypeFilter, #logActionFilter').on('change', () => fetchActivityLogs(1));
                $('#logSearchFilter').on('keyup', _.debounce(() => fetchActivityLogs(1), 500));
            }

            function showRefreshAnimation() {
                const refreshBtn = $('#refreshLogs');
                const originalContent = refreshBtn.html();
                refreshBtn.html(`
                    <svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refreshing...
                `);
                
                setTimeout(() => {
                    refreshBtn.html(originalContent);
                }, 2000);
            }

            function clearAllFilters() {
                $('#logTypeFilter').val('');
                $('#logActionFilter').val('');
                $('#logSearchFilter').val('');
                fetchActivityLogs(1);
                
                // Show toast notification
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Filters cleared',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }

            function fetchActivityLogs(page = 1) {
                console.log('Fetching logs, page:', page);
                
                const type = $('#logTypeFilter').val();
                const action = $('#logActionFilter').val();
                const search = $('#logSearchFilter').val();
                const perPage = 20;
                
                showLoading();
                
                // Set timeout for slow requests
                const timeoutTimer = setTimeout(() => {
                    $('#activityLogsTableBody').html(`
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-2">
                                    <svg class="w-8 h-8 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-yellow-600 dark:text-yellow-400 font-medium">Loading is taking longer than expected...</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Please check your connection</p>
                                </div>
                            </td>
                        </tr>
                    `);
                }, 5000);
                
                $.ajax({
                    url: `{{ route('members.activity_logs') }}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { 
                        page, 
                        type, 
                        action, 
                        search,
                        sort: currentSortField,
                        direction: currentSortDirection,
                        perPage 
                    },
                    success: function (response) {
                        clearTimeout(timeoutTimer);
                        console.log('Logs received:', response);
                        
                        if (response.error) {
                            showErrorState(response.error);
                            return;
                        }
                        
                        allLogs = response.data;
                        updateStats(response);
                        renderLogs(response);
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        clearTimeout(timeoutTimer);
                        console.error('Error fetching logs:', error);
                        console.error('Response:', xhr.responseText);
                        
                        let errorMessage = 'Failed to load logs. Please try refreshing.';
                        let errorIcon = 'error';
                        
                        if (xhr.status === 404) {
                            errorMessage = 'No member profile found for your account.';
                            errorIcon = 'warning';
                        } else if (xhr.status === 403) {
                            errorMessage = 'You do not have permission to view these logs.';
                            errorIcon = 'warning';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error occurred. Please contact support.';
                        }
                        
                        showErrorState(errorMessage, errorIcon);
                        hideLoading();
                    }
                });
            }

            function updateStats(data) {
                const debugInfo = data.debug_info || {};
                const totalLogs = debugInfo.total_logs_in_db || data.total || 0;
                const recentCount = allLogs.filter(log => {
                    const logDate = new Date(log.created_at_raw);
                    const sevenDaysAgo = new Date();
                    sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
                    return logDate >= sevenDaysAgo;
                }).length;
                
                const uniqueTypes = [...new Set(allLogs.map(log => log.type))].length;
                const lastActivity = allLogs.length > 0 ? allLogs[0].created_at : 'Never';
                
                // Animate the numbers
                animateNumber('#totalLogsCount', totalLogs);
                animateNumber('#recentActivityCount', recentCount);
                animateNumber('#logTypesCount', uniqueTypes);
                $('#lastActivityTime').text(lastActivity);
            }

            function animateNumber(selector, finalNumber) {
                const element = $(selector);
                const duration = 1000;
                const frameDuration = 1000 / 60;
                const totalFrames = Math.round(duration / frameDuration);
                const easeOutQuad = t => t * (2 - t);

                let frame = 0;
                const countTo = parseInt(finalNumber);
                const timer = setInterval(() => {
                    frame++;
                    const progress = easeOutQuad(frame / totalFrames);
                    const currentCount = Math.round(countTo * progress);

                    element.text(currentCount);

                    if (frame === totalFrames) {
                        clearInterval(timer);
                    }
                }, frameDuration);
            }

            function sortLogs(field) {
                if (currentSortField === field) {
                    currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortField = field;
                    currentSortDirection = 'asc';
                }
                fetchActivityLogs(1);
                
                // Visual feedback for sorting
                $('.cursor-pointer').removeClass('bg-blue-50');
                $(`th[onclick="sortLogs('${field}')"]`).addClass('bg-blue-50');
            }

            function renderLogs(data) {
                const tbody = $('#activityLogsTableBody');
                tbody.empty();

                // Show debug info if available
                if (data.debug_info) {
                    console.log('Debug info:', data.debug_info);
                }

                if (!data.data || !data.data.length) {
                    showEmptyState(data.debug_info);
                    return;
                }

                data.data.forEach((log, index) => {
                    const typeColor = getTypeColor(log.type);
                    const actionColor = getActionColor(log.action);
                        
                    tbody.append(`
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 animate-fadeIn" style="animation-delay: ${index * 0.05}s">
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">${log.created_at}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: ${log.id}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${typeColor}">
                                    ${log.type}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${actionColor}">
                                    ${log.action}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-gray-100 max-w-xs truncate" title="${log.details || 'No details'}">
                                    ${log.details || '<span class="text-gray-400 dark:text-gray-500">No details</span>'}
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-xs font-bold">${log.performed_by.charAt(0).toUpperCase()}</span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">${log.performed_by}</div>
                                </div>
                            </td>
                        </tr>
                    `);
                });                renderPagination(data);
            }

            function showEmptyState(debugInfo) {
                let message = 'No activity logs found.';
                if (debugInfo) {
                    message += ` (Member ID: ${debugInfo.member_id}, Total in DB: ${debugInfo.total_logs_in_db})`;
                }
                
                $('#activityLogsTableBody').html(`
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">No Activity Logs</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">${message}</p>
                                </div>
                                <button onclick="fetchActivityLogs(1)" class="px-4 py-2 bg-[#101966] text-white rounded-lg hover:bg-[#0d1455] transition-colors duration-200">
                                    Try Again
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            }

            function showErrorState(message, icon = 'error') {
                $('#activityLogsTableBody').html(`
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Error Loading Logs</h3>
                                    <p class="text-red-600 dark:text-red-400 mt-1">${message}</p>
                                </div>
                                <button onclick="fetchActivityLogs(1)" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    Retry
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            }

            function getTypeColor(type) {
                const colors = {
                    'system': 'bg-gray-100 text-gray-800',
                    'registration': 'bg-green-100 text-green-800',
                    'payment': 'bg-blue-100 text-blue-800',
                    'renewal': 'bg-purple-100 text-purple-800',
                    'profile': 'bg-yellow-100 text-yellow-800',
                    'event': 'bg-indigo-100 text-indigo-800',
                    'certificate': 'bg-pink-100 text-pink-800'
                };
                return colors[type.toLowerCase()] || 'bg-gray-100 text-gray-800';
            }

            function getActionColor(action) {
                const colors = {
                    'created': 'bg-green-100 text-green-800',
                    'updated': 'bg-blue-100 text-blue-800',
                    'deleted': 'bg-red-100 text-red-800',
                    'approved': 'bg-green-100 text-green-800',
                    'rejected': 'bg-red-100 text-red-800',
                    'pending': 'bg-orange-100 text-orange-800',
                    'completed': 'bg-green-100 text-green-800',
                    'failed': 'bg-red-100 text-red-800',
                    'test': 'bg-purple-100 text-purple-800',
                    'login': 'bg-green-500 text-white', // Solid green for login
                    'log in': 'bg-green-500 text-white', // Solid green for log in
                    'logout': 'bg-red-200 text-red-800', // Soft red for logout
                    'log out': 'bg-red-200 text-red-800' // Soft red for log out
                };
                return colors[action.toLowerCase()] || 'bg-gray-100 text-gray-800';
            }

            function renderPagination(data) {
                if (!data.last_page || data.last_page <= 1) {
                    $('#activityLogsPagination').html('');
                    return;
                }

                let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';
                
                // Previous button
                if (data.current_page > 1) {
                    paginationHtml += `
                        <button onclick="fetchActivityLogs(1)" 
                            class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button onclick="fetchActivityLogs(${data.current_page - 1})" 
                            class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            Previous
                        </button>
                    `;
                }
                
                // Page numbers
                const startPage = Math.max(1, data.current_page - 2);
                const endPage = Math.min(data.last_page, data.current_page + 2);
                
                for (let i = startPage; i <= endPage; i++) {
                    const isActive = i === data.current_page;
                    paginationHtml += `
                        <button onclick="fetchActivityLogs(${i})" 
                            class="px-3 py-2 rounded-lg border transition-colors duration-200 ${isActive 
                                ? 'bg-gradient-to-r from-[#101966] to-[#2d3a8c] text-white border-[#101966]' 
                                : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600'
                            }">
                            ${i}
                        </button>
                    `;
                }
                
                // Next button
                if (data.current_page < data.last_page) {
                    paginationHtml += `
                        <button onclick="fetchActivityLogs(${data.current_page + 1})" 
                            class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            Next
                        </button>
                        <button onclick="fetchActivityLogs(${data.last_page})" 
                            class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    `;
                }
                
                paginationHtml += '</div>';
                $('#activityLogsPagination').html(paginationHtml);
            }

            function showLoading() {
                $('#activityLogsTableBody').html(`
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="relative">
                                    <div class="w-12 h-12 border-4 border-blue-200 dark:border-blue-800 rounded-full"></div>
                                    <div class="w-12 h-12 border-4 border-[#101966] border-t-transparent rounded-full animate-spin absolute top-0"></div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Loading Activity Logs</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Please wait while we fetch your data...</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            }

            function hideLoading() {
                // Handled by the renderLogs function
            }
        </script>
        
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out forwards;
                opacity: 0;
            }
            
            /* Floating Help Button */
            .floating-btn {
                position: fixed;
                bottom: 2rem;
                left: 2rem;
                z-index: 50;
            }
            
            .interactive-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .interactive-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            .interactive-btn:active {
                transform: scale(0.95);
            }
            
            /* Custom scrollbar */
            .overflow-x-auto::-webkit-scrollbar {
                height: 6px;
            }
            
            .overflow-x-auto::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            
            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 3px;
            }
            
            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
        </style>
    </x-slot>
</x-app-layout>