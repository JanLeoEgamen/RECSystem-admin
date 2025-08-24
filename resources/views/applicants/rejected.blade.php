<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            
            <!-- Title -->
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Rejected Applicants') }}
            </h2>

            <!-- Back Button -->
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto text-center sm:text-right">
                <a href="{{ route('applicants.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto mt-4 sm:mt-0">

                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    Back to Applicants
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
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
                                    <option value="updated_desc">Default (Rejected Date)</option>
                                    <option value="full_name_asc">Name (A-Z)</option>
                                    <option value="full_name_desc">Name (Z-A)</option>
                                    <option value="sex_asc">Sex (A-Z)</option>
                                    <option value="sex_desc">Sex (Z-A)</option>
                                    <option value="birthdate_asc">Birthdate (Oldest)</option>
                                    <option value="birthdate_desc">Birthdate (Youngest)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
                                    <option value="created_desc">Created (Newest First)</option>
                                    <option value="updated_asc">Rejected (Oldest First)</option>
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
                                                    <input type="checkbox" class="column-checkbox" data-column="rejected" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Rejected On</span>
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
                            <input type="text" id="searchInput" placeholder="Search rejected applicants..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <!-- Mobile View - Vertical layout -->
                    <div class="sm:hidden space-y-3 mb-4">
                        <!-- Search bar -->
                        <input type="text" id="mobileSearchInput" placeholder="Search rejected applicants..." 
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
                                <option value="updated_desc">Default (Rejected Date)</option>
                                <option value="full_name_asc">Name (A-Z)</option>
                                <option value="full_name_desc">Name (Z-A)</option>
                                <option value="sex_asc">Sex (A-Z)</option>
                                <option value="sex_desc">Sex (Z-A)</option>
                                <option value="birthdate_asc">Birthdate (Oldest)</option>
                                <option value="birthdate_desc">Birthdate (Youngest)</option>
                                <option value="created_asc">Created (Oldest First)</option>
                                <option value="created_desc">Created (Newest First)</option>
                                <option value="updated_asc">Rejected (Oldest First)</option>
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
                                                <input type="checkbox" class="column-checkbox" data-column="rejected" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Rejected On</span>
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
                            <table id="rejectedApplicantsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-full_name">Full Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-sex">Sex</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-birthdate">Birthdate</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-cellphone_no">Contact No.</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-rejected">Rejected On</th>
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
        <style>
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .table-row-animate {
                opacity: 0;
                animation: slideInLeft 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            }

            .table-row-animate:nth-child(1) { animation-delay: 0.1s; }
            .table-row-animate:nth-child(2) { animation-delay: 0.2s; }
            .table-row-animate:nth-child(3) { animation-delay: 0.3s; }
            .table-row-animate:nth-child(4) { animation-delay: 0.4s; }
            .table-row-animate:nth-child(5) { animation-delay: 0.5s; }
            .table-row-animate:nth-child(6) { animation-delay: 0.6s; }
            .table-row-animate:nth-child(7) { animation-delay: 0.7s; }
            .table-row-animate:nth-child(8) { animation-delay: 0.8s; }
            .table-row-animate:nth-child(9) { animation-delay: 0.9s; }
            .table-row-animate:nth-child(10) { animation-delay: 1.0s; }
            .table-row-animate:nth-child(n+11) { animation-delay: 1.1s; }

            .table-row-hover {
                transition: all 0.3s ease-out;
            }
            
            .table-row-hover:hover {
                background-color: rgba(59, 130, 246, 0.08);
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                border-left: 4px solid #3b82f6;
            }

            .table-row-hover:hover td:first-child {
                border-left: 4px solid #3b82f6;
                padding-left: calc(1.5rem - 4px);
            }
        </style>
        <script>
            $(document).ready(function () {
                fetchRejectedApplicants();

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
                    fetchRejectedApplicants(1, $(this).val());
                });

                // Entries per page change handler
                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchRejectedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                // Sort by change handler
                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchRejectedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                // Column checkbox change handler
                $('.column-checkbox').on('change', function() {
                    const column = $(this).data('column');
                    const isChecked = $(this).is(':checked');
                    
                    // Show/hide the column
                    $(`.column-${column}`).toggle(isChecked);
                });

                function fetchRejectedApplicants(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'updated_desc';

                    const sortMap = {
                        'full_name_asc': { sort: 'full_name', direction: 'asc' },
                        'full_name_desc': { sort: 'full_name', direction: 'desc' },
                        'sex_asc': { sort: 'sex', direction: 'asc' },
                        'sex_desc': { sort: 'sex', direction: 'desc' },
                        'birthdate_asc': { sort: 'birthdate', direction: 'asc' },
                        'birthdate_desc': { sort: 'birthdate', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' },
                        'updated_asc': { sort: 'updated_at', direction: 'asc' },
                        'updated_desc': { sort: 'updated_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'updated_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('applicants.rejected') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderRejectedApplicants(response.data, response.from);
                            renderPagination(response);
                            
                            // Update both desktop and mobile result info
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderRejectedApplicants(applicants, startIndex) {
                    let tbody = $('#rejectedApplicantsTable tbody');
                    tbody.empty();
                    
                    applicants.forEach((applicant, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-full_name">${applicant.full_name}</td>
                                <td class="px-6 py-4 text-left column-sex">${applicant.sex}</td>
                                <td class="px-6 py-4 text-left column-birthdate">${applicant.birthdate}</td>
                                <td class="px-6 py-4 text-left column-cellphone_no">${applicant.cellphone_no}</td>
                                <td class="px-6 py-4 text-left column-rejected">${applicant.updated_at}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    ${applicant.can_view ? `
                                    <a href="/applicants/${applicant.id}" 
                                        class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1" 
                                        title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                                        -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-blue-600 group-hover:text-white text-sm">View</span>
                                        </a>
                                    ` : ''}
                                    ${applicant.can_edit ? `
                                    <button onclick="restoreApplicant(${applicant.id})" 
                                        class="group flex items-center bg-green-100 hover:bg-green-500 px-3 py-2 rounded-full transition space-x-1" 
                                        title="Restore">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-green-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="text-green-600 group-hover:text-white text-sm">Restore</span>
                                    </button>
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
                                onclick="fetchRejectedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchRejectedApplicants(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchRejectedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchRejectedApplicants(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchRejectedApplicants(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchRejectedApplicants(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchRejectedApplicants(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.restoreApplicant = function (id) {
                    if (confirm("Are you sure you want to restore this applicant to pending status?")) {
                        let url = "{{ route('applicants.restore', ':id') }}".replace(':id', id);
                        
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function (response) {
                                if (response.status) {
                                    alert("Applicant restored successfully.");
                                    fetchRejectedApplicants();
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function() {
                                alert("An error occurred while restoring the applicant.");
                            }
                        });
                    }
                }
                window.fetchRejectedApplicants = fetchRejectedApplicants;
            });
        </script>
    </x-slot>
</x-app-layout>