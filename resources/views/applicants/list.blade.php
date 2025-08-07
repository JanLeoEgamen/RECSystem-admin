<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <!-- Header Title -->
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
                {{ __('Applicants') }}
            </h2>

            <!-- Create Button -->
            <div class="flex items-center flex-wrap gap-4 justify-center sm:justify-end">
                @can('create applicants')
                <a href="{{ route('applicants.showApplicantCreateForm') }}" 
                   class="inline-block px-5 py-2 
                          text-white dark:text-gray-900
                          hover:text-[#101966] dark:hover:text-white
                          bg-white/10 dark:bg-gray-200/20 
                          hover:bg-white dark:hover:bg-gray-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-white dark:focus:ring-gray-500
                          border border-white dark:border-gray-500 
                          font-medium rounded-lg 
                          text-base sm:text-xl leading-normal 
                          text-center transition">
                    Create
                </a>
                @endcan

                @can('view applicants')
                <a href="{{ route('applicants.rejected') }}" dusk="go-to-rejected"
                   class="inline-block px-5 py-2 
                          text-white dark:text-gray-900
                          hover:text-[#101966] dark:hover:text-white
                          bg-white/10 dark:bg-gray-200/20 
                          hover:bg-white dark:hover:bg-gray-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-white dark:focus:ring-gray-500
                          border border-white dark:border-gray-500 
                          font-medium rounded-lg 
                          text-base sm:text-xl leading-normal 
                          text-center transition">
                    Rejected Applicants
                </a>

                <a href="{{ route('applicants.approved') }}" dusk="go-to-approved"
                   class="inline-block px-5 py-2 
                          text-white dark:text-gray-900
                          hover:text-[#101966] dark:hover:text-white
                          bg-white/10 dark:bg-gray-200/20 
                          hover:bg-white dark:hover:bg-gray-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-white dark:focus:ring-gray-500
                          border border-white dark:border-gray-500 
                          font-medium rounded-lg 
                          text-base sm:text-xl leading-normal 
                          text-center transition">
                    Approved Applicants
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-gray-10 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                                    <option value="full_name_asc">Name (A-Z)</option>
                                    <option value="full_name_desc">Name (Z-A)</option>
                                    <option value="sex_asc">Sex (A-Z)</option>
                                    <option value="sex_desc">Sex (Z-A)</option>
                                    <option value="birthdate_asc">Birthdate (Oldest)</option>
                                    <option value="birthdate_desc">Birthdate (Youngest)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
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
                                                    <input type="checkbox" class="column-checkbox" data-column="full_name" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Full Name</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="sex" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Sex</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="birthdate" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Birthdate</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="cellphone_no" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Contact No.</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="created" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Created</span>
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
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> items
                            </div>
                            <input type="text" id="searchInput" placeholder="Search applicants..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <!-- Mobile View - Vertical layout -->
                    <div class="sm:hidden space-y-3 mb-4">
                        <!-- Search bar -->
                        <input type="text" id="mobileSearchInput" placeholder="Search applicants..." 
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
                                <option value="full_name_asc">Name (A-Z)</option>
                                <option value="full_name_desc">Name (Z-A)</option>
                                <option value="sex_asc">Sex (A-Z)</option>
                                <option value="sex_desc">Sex (Z-A)</option>
                                <option value="birthdate_asc">Birthdate (Oldest)</option>
                                <option value="birthdate_desc">Birthdate (Youngest)</option>
                                <option value="created_asc">Created (Oldest First)</option>
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
                                                <input type="checkbox" class="column-checkbox" data-column="full_name" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Full Name</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="sex" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Sex</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="birthdate" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Birthdate</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="cellphone_no" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Contact No.</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="created" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Created</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Result Info -->
                        <div id="mobileResultInfo" class="text-sm text-gray-700 dark:text-gray-300 text-center">
                            Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> items
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="applicantsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-full_name">Full Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-sex">Sex</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-birthdate">Birthdate</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-cellphone_no">Contact No.</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-created">Created</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white">Action</th>
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
                fetchApplicants();

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
                    fetchApplicants(1, $(this).val());
                });

                // Entries per page change handler
                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                // Sort by change handler
                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                // Column checkbox change handler
                $('.column-checkbox').on('change', function() {
                    const column = $(this).data('column');
                    const isChecked = $(this).is(':checked');
                    
                    // Show/hide the column
                    $(`.column-${column}`).toggle(isChecked);
                });

                function fetchApplicants(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'full_name_asc': { sort: 'full_name', direction: 'asc' },
                        'full_name_desc': { sort: 'full_name', direction: 'desc' },
                        'sex_asc': { sort: 'sex', direction: 'asc' },
                        'sex_desc': { sort: 'sex', direction: 'desc' },
                        'birthdate_asc': { sort: 'birthdate', direction: 'asc' },
                        'birthdate_desc': { sort: 'birthdate', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('applicants.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderApplicants(response.data, response.from);
                            renderPagination(response);
                            
                            // Update both desktop and mobile result info
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderApplicants(applicants, startIndex) {
                    let tbody = $('#applicantsTable tbody');
                    tbody.empty();
                    
                    applicants.forEach((applicant, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-full_name">${applicant.full_name}</td>
                                <td class="px-6 py-4 text-left column-sex">${applicant.sex}</td>
                                <td class="px-6 py-4 text-left column-birthdate">${applicant.birthdate}</td>
                                <td class="px-6 py-4 text-left column-cellphone_no">${applicant.cellphone_no}</td>
                                <td class="px-6 py-4 text-left column-created">${applicant.created_at}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    ${applicant.can_view ? `
                                    <a href="/applicants/${applicant.id}" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${applicant.can_edit ? `
                                    <a href="/applicants/${applicant.id}/edit" class="group bg-indigo-100 hover:bg-indigo-200 p-2 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-indigo-600 group-hover:text-indigo-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${applicant.can_delete ? `
                                    <button onclick="deleteApplicant(${applicant.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition" title="Delete"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    ` : ''}
                                    ${applicant.can_assess ? `
                                    <a href="/applicants/${applicant.id}/assess" class="group bg-green-100 hover:bg-green-200 p-2 rounded-full transition" title="Assess">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-green-600 group-hover:text-green-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApplicants(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                            <button class="px-3 py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchApplicants(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchApplicants(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApplicants(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApplicants(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteApplicant = function (id) {
                    if (confirm("Are you sure you want to delete this applicant?")) {
                        $.ajax({
                            url: '{{ route("applicants.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                alert("Successfully deleted.");
                                fetchApplicants();
                            }
                        });
                    }
                }
                window.fetchApplicants = fetchApplicants;
            });
        </script>
    </x-slot>
</x-app-layout>