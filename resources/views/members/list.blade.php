<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> 
            <!-- Title -->
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Members') }}
            </h2>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">
                @can('create members')
                <a href="{{ route('members.showMemberCreateForm') }}" 
                class="px-4 py-2 sm:px-5 sm:py-2 
                        text-white dark:text-gray-900
                        hover:text-[#101966] dark:hover:text-white
                        bg-white/10 dark:bg-gray-200/20 
                        hover:bg-white dark:hover:bg-gray-600
                        focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-white dark:focus:ring-gray-500
                        border border-white dark:border-gray-500 
                        font-medium rounded-lg 
                        text-sm sm:text-base leading-normal 
                        text-center transition w-full sm:w-auto">
                    Create
                </a>
                @endcan

                <a href="{{ route('members.active') }}" dusk="go-to-active"
                class="px-4 py-2 sm:px-5 sm:py-2 
                        text-white dark:text-gray-900
                        hover:text-[#101966] dark:hover:text-white
                        bg-white/10 dark:bg-gray-200/20 
                        hover:bg-white dark:hover:bg-gray-600
                        focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-white dark:focus:ring-gray-500
                        border border-white dark:border-gray-500 
                        font-medium rounded-lg 
                        text-sm sm:text-base leading-normal 
                        text-center transition w-full sm:w-auto">
                    Active Members
                </a>

                <a href="{{ route('members.inactive') }}" dusk="go-to-inactive"
                class="px-4 py-2 sm:px-5 sm:py-2 
                        text-white dark:text-gray-900
                        hover:text-[#101966] dark:hover:text-white
                        bg-white/10 dark:bg-gray-200/20 
                        hover:bg-white dark:hover:bg-gray-600
                        focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-white dark:focus:ring-gray-500
                        border border-white dark:border-gray-500 
                        font-medium rounded-lg 
                        text-sm sm:text-base leading-normal 
                        text-center transition w-full sm:w-auto">
                    Inactive Members
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-gray-10 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    <!-- Desktop View - Filters in one line -->
                    <div class="hidden sm:flex justify-between items-center mb-4 gap-4">
                        <!-- Left side filters -->
                        <div class="flex items-center space-x-4">
                            <!-- Entries per page -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">No. of entries</span>
                                <select id="perPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-24">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <!-- Sort by -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Sort by</span>
                                <select id="sortBy" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                                    <option value="created_desc">Default</option>
                                    <option value="last_name_asc">Last Name (A-Z)</option>
                                    <option value="last_name_desc">Last Name (Z-A)</option>
                                    <option value="rec_number_asc">Record No. (Asc)</option>
                                    <option value="rec_number_desc">Record No. (Desc)</option>
                                    <option value="membership_start_asc">Start Date (Oldest)</option>
                                    <option value="membership_start_desc">Start Date (Newest)</option>
                                    <option value="membership_end_asc">End Date (Soonest)</option>
                                    <option value="membership_end_desc">End Date (Latest)</option>
                                    <option value="status_asc">Status (Active First)</option>
                                    <option value="status_desc">Status (Inactive First)</option>
                                </select>
                            </div>

                            <!-- Column Filter -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Columns</span>
                                <div class="relative">
                                    <button id="columnFilterButton" class="flex items-center justify-between px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                                        <span>Select columns</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Column Filter Dropdown -->
                                    <div id="columnFilterDropdown" class="hidden absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-700">
                                        <div class="p-2">
                                            <div class="space-y-2">
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="personal" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Personal Info</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="contact" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Contact Info</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="membership" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Membership Info</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="address" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Address Info</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - search and result info -->
                        <div class="flex items-center space-x-4">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> members
                            </div>
                            <input type="text" id="searchInput" placeholder="Search members..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <!-- Mobile View - Vertical layout -->
                    <div class="sm:hidden space-y-3 mb-4">
                        <!-- Search bar -->
                        <input type="text" id="mobileSearchInput" placeholder="Search members..." 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">

                        <!-- Entries per page -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap w-1/3">No. of entries</span>
                            <select id="mobilePerPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-2/3">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <!-- Sort by -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap w-1/3">Sort by</span>
                            <select id="mobileSortBy" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-2/3">
                                <option value="created_desc">Default</option>
                                <option value="last_name_asc">Last Name (A-Z)</option>
                                <option value="last_name_desc">Last Name (Z-A)</option>
                                <option value="rec_number_asc">Record No. (Asc)</option>
                                <option value="rec_number_desc">Record No. (Desc)</option>
                                <option value="membership_start_asc">Start Date (Oldest)</option>
                                <option value="membership_start_desc">Start Date (Newest)</option>
                                <option value="membership_end_asc">End Date (Soonest)</option>
                                <option value="membership_end_desc">End Date (Latest)</option>
                                <option value="status_asc">Status (Active First)</option>
                                <option value="status_desc">Status (Inactive First)</option>
                            </select>
                        </div>

                        <!-- Column Filter -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap w-1/3">Columns</span>
                            <div class="relative w-2/3">
                                <button id="mobileColumnFilterButton" class="flex items-center justify-between px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-full">
                                    <span>Select columns</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <!-- Column Filter Dropdown -->
                                <div id="mobileColumnFilterDropdown" class="hidden absolute left-0 mt-1 w-full bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-700">
                                    <div class="p-2">
                                        <div class="space-y-2">
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="personal" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Personal Info</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="contact" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Contact Info</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="membership" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Membership Info</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="address" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Address Info</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Result Info -->
                        <div id="mobileResultInfo" class="text-sm text-gray-700 dark:text-gray-300 text-center">
                            Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> members
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-full">
                            <table id="membersTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium whitespace-nowrap">#</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-personal whitespace-nowrap">Full Name</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-contact whitespace-nowrap">Email</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-contact whitespace-nowrap">Cellphone</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-membership whitespace-nowrap">Record No.</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-membership whitespace-nowrap">Membership Type</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-membership whitespace-nowrap">Start Date</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-membership whitespace-nowrap">End Date</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-membership whitespace-nowrap">Status</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white column-address whitespace-nowrap">Address</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l border-white whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>                   
                    </div>
                    <div class="mt-4 flex justify-center" id="paginationLinks"></div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                fetchMembers();

                // Toggle column filter dropdown (desktop)
                $('#columnFilterButton').on('click', function(e) {
                    e.stopPropagation();
                    $('#columnFilterDropdown').toggleClass('hidden');
                });

                // Toggle column filter dropdown (mobile)
                $('#mobileColumnFilterButton').on('click', function(e) {
                    e.stopPropagation();
                    $('#mobileColumnFilterDropdown').toggleClass('hidden');
                });

                // Close dropdowns when clicking outside
                $(document).on('click', function() {
                    $('#columnFilterDropdown, #mobileColumnFilterDropdown').addClass('hidden');
                });

                // Search functionality for both desktop and mobile
                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchMembers(1, $(this).val());
                });

                // Entries per page change handler
                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                // Sort by change handler
                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                // Column checkbox change handler
                $('.column-checkbox').on('change', function() {
                    const column = $(this).data('column');
                    const isChecked = $(this).is(':checked');
                    
                    // Show/hide the column
                    $(`.column-${column}`).toggle(isChecked);
                });

                function fetchMembers(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'last_name_asc': { sort: 'last_name', direction: 'asc' },
                        'last_name_desc': { sort: 'last_name', direction: 'desc' },
                        'rec_number_asc': { sort: 'rec_number', direction: 'asc' },
                        'rec_number_desc': { sort: 'rec_number', direction: 'desc' },
                        'membership_start_asc': { sort: 'membership_start', direction: 'asc' },
                        'membership_start_desc': { sort: 'membership_start', direction: 'desc' },
                        'membership_end_asc': { sort: 'membership_end', direction: 'asc' },
                        'membership_end_desc': { sort: 'membership_end', direction: 'desc' },
                        'status_asc': { sort: 'status', direction: 'asc' },
                        'status_desc': { sort: 'status', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('members.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderMembers(response.data, response.from);
                            renderPagination(response);
                            
                            // Update both desktop and mobile result info
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderMembers(members, startIndex) {
                    let tbody = $('#membersTable tbody');
                    tbody.empty();
                    
                    members.forEach((member, index) => {
                        const rowNumber = startIndex + index;
                        const fullName = `${member.first_name} ${member.last_name}`;
                        const statusBadge = member.is_lifetime_member 
                            ? '<span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-100">Lifetime</span>'
                            : member.status === 'Active'
                                ? '<span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-100">Active</span>'
                                : '<span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-100">Inactive</span>';

                        let row = `
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-3 sm:px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-3 sm:px-6 py-4 text-left column-personal whitespace-nowrap">${fullName}</td>
                                <td class="px-3 sm:px-6 py-4 text-left column-contact whitespace-nowrap">${member.email_address}</td>
                                <td class="px-3 sm:px-6 py-4 text-left column-contact whitespace-nowrap">${member.cellphone_no}</td>
                                <td class="px-3 sm:px-6 py-4 text-center column-membership whitespace-nowrap">${member.rec_number}</td>
                                <td class="px-3 sm:px-6 py-4 text-center column-membership whitespace-nowrap">${member.membership_type}</td>
                                <td class="px-3 sm:px-6 py-4 text-center column-membership whitespace-nowrap">${member.membership_start}</td>
                                <td class="px-3 sm:px-6 py-4 text-center column-membership whitespace-nowrap">${member.membership_end || '-'}</td>
                                <td class="px-3 sm:px-6 py-4 text-center column-membership whitespace-nowrap">${statusBadge}</td>
                                <td class="px-3 sm:px-6 py-4 text-left column-address whitespace-nowrap">${member.street_address || ''}</td>
                                <td class="px-3 sm:px-6 py-4 text-center flex justify-center items-center space-x-1 sm:space-x-2 whitespace-nowrap">
                                    ${member.can_view ? `
                                    <a href="/members/${member.id}" class="group bg-blue-100 hover:bg-blue-200 p-1 sm:p-2 rounded-full transition" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_edit ? `
                                    <a href="/members/${member.id}/edit" class="group bg-indigo-100 hover:bg-indigo-200 p-1 sm:p-2 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600 group-hover:text-indigo-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_renew ? `
                                    <a href="/members/${member.id}/renew" class="group bg-green-100 hover:bg-green-200 p-1 sm:p-2 rounded-full transition" title="Renew">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 sm:h-5 sm:w-5 text-green-600 group-hover:text-green-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_delete ? `
                                        <a href="javascript:void(0)" onclick="deactivateMember(${member.id})" dusk="deactivate-member-${member.id}" class="p-1 sm:p-2 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-full transition-colors duration-200 flex items-center" title="Deactivate">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                                            </svg>
                                        </a>
                                    ` : ''}
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }

                function renderPagination(data) {
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-1 sm:space-x-2">';

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-xs sm:text-sm"
                                onclick="fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-xs sm:text-sm"
                                onclick="fetchMembers(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Previous
                            </button>`;
                    }

                    const totalPages = data.last_page;
                    const currentPage = data.current_page;
                    const pagesToShow = 3;

                    let startPage = Math.max(1, currentPage - Math.floor(pagesToShow / 2));
                    let endPage = Math.min(totalPages, startPage + pagesToShow - 1);

                    if (endPage - startPage + 1 < pagesToShow) {
                        startPage = Math.max(1, endPage - pagesToShow + 1);
                    }
                    if (startPage > 1) {
                        paginationHtml += `
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'} text-xs sm:text-sm"
                                onclick="fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-1 sm:px-2 dark:text-white text-xs sm:text-sm">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'} text-xs sm:text-sm"
                                onclick="fetchMembers(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-1 sm:px-2 dark:text-white text-xs sm:text-sm">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'} text-xs sm:text-sm"
                                onclick="fetchMembers(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-xs sm:text-sm"
                                onclick="fetchMembers(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-2 py-1 sm:px-3 sm:py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-xs sm:text-sm"
                                onclick="fetchMembers(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteMember = function (id) {
                    if (confirm("Are you sure you want to delete this member?")) {
                        $.ajax({
                            url: '{{ route("members.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchMembers();
                            }
                        });
                    }
                }
                window.fetchMembers = fetchMembers;

                window.deactivateMember = function (id) {
                    if (!confirm('Are you sure you want to deactivate this member?')) return;

                    fetch(`/members/${id}/deactivate`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        if (data.status) {
                            fetchMembers();
                        } else {
                            alert(data.message || 'Deactivation failed');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to deactivate member.');
                    });
                }

            });
            
        </script>
    </x-slot>
</x-app-layout>