<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-4xl text-white leading-tight">
                {{ __('Activity Logs for ') . $member->first_name . ' ' . $member->last_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-10 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <div class="flex flex-wrap gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-300">Type</label>
                        <select id="logTypeFilter" class="rounded px-3 py-1 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                            <option value="">All</option>
                            @foreach($logTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-300">Action</label>
                        <select id="logActionFilter" class="rounded px-3 py-1 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                            <option value="">All</option>
                            @foreach($logActions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-300">Search</label>
                        <input type="text" id="logSearchFilter" placeholder="Search logs..." 
                               class="rounded px-3 py-1 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                    </div>
                    <div class="flex items-end">
                        <button id="refreshLogs" class="px-4 py-2 bg-[#101966] text-white rounded">Refresh</button>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table id="activityLogsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                        <thead class="bg-[#101966] text-white">
                            <tr>
                                <th class="px-4 py-2 cursor-pointer" onclick="sortLogs('created_at_raw')">Date/Time</th>
                                <th class="px-4 py-2 cursor-pointer" onclick="sortLogs('type')">Type</th>
                                <th class="px-4 py-2 cursor-pointer" onclick="sortLogs('action')">Action</th>
                                <th class="px-4 py-2">Details</th>
                                <th class="px-4 py-2 cursor-pointer" onclick="sortLogs('performed_by')">Performed By</th>
                        </thead>
                        <tbody>
                            <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
                <div id="activityLogsPagination" class="mt-4 flex justify-center"></div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        @if(!app()->runningUnitTests())
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @endif
        <script>
            const memberId = {{ $member->id }};
            let currentSortField = 'created_at_raw';
            let currentSortDirection = 'desc';

            // Wait for everything to be ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM fully loaded, fetching logs...');
                fetchActivityLogs(1);
            });

            function fetchActivityLogs(page = 1) {
                console.log('Fetching logs, page:', page);
                
                const type = $('#logTypeFilter').val();
                const action = $('#logActionFilter').val();
                const search = $('#logSearchFilter').val();
                const perPage = 20;
                
                showLoading();
                
                // Set timeout for slow requests
                const timeoutTimer = setTimeout(() => {
                    $('#activityLogsTable tbody').html(`
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-yellow-600">
                                Loading is taking longer than expected...
                            </td>
                        </tr>
                    `);
                }, 5000);
                
                $.ajax({
                    url: `/member/my-activity-logs`,
                    type: 'GET',
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
                        renderLogs(response);
                    },
                    error: function(xhr, status, error) {
                        clearTimeout(timeoutTimer);
                        console.error('Error fetching logs:', error);
                        $('#activityLogsTable tbody').html(`
                            <tr>
                                <td colspan="6" class="text-center px-4 py-6 text-red-500">
                                    Failed to load logs. Please try refreshing.
                                </td>
                            </tr>
                        `);
                    },
                    complete: function() {
                        clearTimeout(timeoutTimer);
                        hideLoading();
                    }
                });
            }

            function sortLogs(field) {
                if (currentSortField === field) {
                    currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortField = field;
                    currentSortDirection = 'asc';
                }
                fetchActivityLogs(1);
            }

            function renderLogs(data) {
                const tbody = $('#activityLogsTable tbody');
                tbody.empty();

                if (!data.data.length) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-500">No activity logs found.</td>
                        </tr>
                    `);
                } else {
                    data.data.forEach((log, i) => {
                        const metaBtn = log.meta && Object.keys(log.meta).length > 0
                            ? `<button class="px-2 py-1 text-xs border rounded" 
                                      onclick="showMeta(${log.id}, ${JSON.stringify(log.meta)})">View</button>`
                            : '-';
                            
                        tbody.append(`
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-2 text-center">${log.created_at}</td>
                                <td class="px-4 py-2 text-center">${log.type}</td>
                                <td class="px-4 py-2 text-center">${log.action}</td>
                                <td class="px-4 py-2 text-center">${log.details || '-'}</td>
                                <td class="px-4 py-2 text-center">${log.performed_by}</td>
                            </tr>
                        `);
                    });
                }

                renderPagination(data);
            }

            function renderPagination(data) {
                let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';
                
                // Previous button
                if (data.current_page > 1) {
                    paginationHtml += `<button onclick="fetchActivityLogs(1)" 
                        class="px-3 py-1 rounded border bg-white hover:bg-gray-200">First</button>`;
                    paginationHtml += `<button onclick="fetchActivityLogs(${data.current_page - 1})" 
                        class="px-3 py-1 rounded border bg-white hover:bg-gray-200">Previous</button>`;
                }
                
                // Page numbers
                const startPage = Math.max(1, data.current_page - 2);
                const endPage = Math.min(data.last_page, data.current_page + 2);
                
                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += `<button onclick="fetchActivityLogs(${i})" 
                        class="px-3 py-1 rounded border ${i === data.current_page ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}">${i}</button>`;
                }
                
                // Next button
                if (data.current_page < data.last_page) {
                    paginationHtml += `<button onclick="fetchActivityLogs(${data.current_page + 1})" 
                        class="px-3 py-1 rounded border bg-white hover:bg-gray-200">Next</button>`;
                    paginationHtml += `<button onclick="fetchActivityLogs(${data.last_page})" 
                        class="px-3 py-1 rounded border bg-white hover:bg-gray-200">Last</button>`;
                }
                
                paginationHtml += '</div>';
                $('#activityLogsPagination').html(paginationHtml);
            }

            function showMeta(id, meta) {
                Swal.fire({
                    title: 'Log Details',
                    html: `<div class="text-left"><pre class="text-sm overflow-auto max-h-96">${JSON.stringify(meta, null, 2)}</pre></div>`,
                    width: '800px',
                    showCloseButton: true,
                    showConfirmButton: false
                });
            }

            function showLoading() {
                $('#activityLogsTable tbody').html(`
                    <tr>
                        <td colspan="6" class="text-center px-4 py-6">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Loading logs...</span>
                            </div>
                        </td>
                    </tr>
                `);
            }

            function hideLoading() {
                // Handled by the renderLogs function
            }

            // Event listeners
            $('#refreshLogs').on('click', () => fetchActivityLogs(1));
            $('#logTypeFilter, #logActionFilter').on('change', () => fetchActivityLogs(1));
            $('#logSearchFilter').on('keyup', _.debounce(() => fetchActivityLogs(1), 500));

            // Initial load
            document.addEventListener('DOMContentLoaded', function() {
                fetchActivityLogs(1);
            });
        </script>
    </x-slot>
</x-app-layout>