<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Approved Applicants') }}
            </h2>

            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto text-center sm:text-right">
                <a href="{{ route('applicants.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium 
                        rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto mt-4 sm:mt-0

                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

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
                    <!-- Desktop Filter Section -->
                    <div class="hidden sm:block mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 shadow-sm border border-blue-100 dark:border-gray-600">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <!-- Entries Per Page -->
                                <div class="flex flex-col space-y-2">
                                    <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Entries
                                    </label>
                                    <select id="perPage" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300 cursor-pointer">
                                        <option value="10" selected>10 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="50">50 per page</option>
                                        <option value="100">100 per page</option>
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div class="flex flex-col space-y-2">
                                    <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                        </svg>
                                        Sort Order
                                    </label>
                                    <select id="sortBy" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300 cursor-pointer">
                                        <option value="updated_desc">Latest First (Approved Date)</option>
                                        <option value="full_name_asc">Name (A-Z)</option>
                                        <option value="full_name_desc">Name (Z-A)</option>
                                        <option value="sex_asc">Sex (A-Z)</option>
                                        <option value="sex_desc">Sex (Z-A)</option>
                                        <option value="birthdate_asc">Birthdate (Oldest)</option>
                                        <option value="birthdate_desc">Birthdate (Youngest)</option>
                                        <option value="created_asc">Created (Oldest First)</option>
                                        <option value="created_desc">Created (Newest First)</option>
                                        <option value="updated_asc">Approved (Oldest First)</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="flex flex-col space-y-2">
                                    <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="searchInput" 
                                            placeholder="Search Name..." 
                                            class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 dark:placeholder-gray-400 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-orange-300">
                                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" 
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Results Info -->
                            <div class="mt-4 pt-3 border-t border-blue-200 dark:border-gray-500">
                                <div class="flex items-center justify-between text-xs">
                                    <div id="resultInfo" class="flex items-center text-gray-600 dark:text-gray-300 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Filter Section -->
                    <div class="sm:hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 shadow-sm border border-blue-100 dark:border-gray-600 space-y-4">
                            <!-- Search -->
                            <div class="flex flex-col space-y-2">
                                <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </label>
                                <div class="relative">
                                    <input type="text" id="mobileSearchInput" 
                                        placeholder="Search Name..." 
                                        class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 dark:placeholder-gray-400 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" 
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Entries Per Page -->
                            <div class="flex flex-col space-y-2">
                                <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    Entries Per Page
                                </label>
                                <select id="mobilePerPage" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="10" selected>10 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="50">50 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div class="flex flex-col space-y-2">
                                <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>
                                    Sort Order
                                </label>
                                <select id="mobileSortBy" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <option value="updated_desc">Latest First (Approved Date)</option>
                                    <option value="full_name_asc">Name (A-Z)</option>
                                    <option value="full_name_desc">Name (Z-A)</option>
                                    <option value="sex_asc">Sex (A-Z)</option>
                                    <option value="sex_desc">Sex (Z-A)</option>
                                    <option value="birthdate_asc">Birthdate (Oldest)</option>
                                    <option value="birthdate_desc">Birthdate (Youngest)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
                                    <option value="created_desc">Created (Newest First)</option>
                                    <option value="updated_asc">Approved (Oldest First)</option>
                                </select>
                            </div>

                            <!-- Results Info -->
                            <div class="pt-3 border-t border-blue-200 dark:border-gray-500">
                                <div id="mobileResultInfo" class="flex items-center justify-center text-xs text-gray-600 dark:text-gray-300 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> items</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="approvedApplicantsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-full_name">Full Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-sex">Sex</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-birthdate">Birthdate</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-cellphone_no">Contact No.</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-approved">Approved On</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Action</th>
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
                fetchApprovedApplicants();

                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchApprovedApplicants(1, $(this).val());
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchApprovedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchApprovedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function fetchApprovedApplicants(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
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
                        url: `{{ route('applicants.approved') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderApprovedApplicants(response.data, response.from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderApprovedApplicants(applicants, startIndex) {
                    let tbody = $('#approvedApplicantsTable tbody');
                    tbody.empty();
                    
                    if (applicants.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div class="text-lg font-medium">No approved applicants found</div>
                                        <div class="text-sm">There are currently no approved applicants to display.</div>
                                    </div>
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    
                    applicants.forEach((applicant, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-center column-full_name">${applicant.full_name}</td>
                                <td class="px-6 py-4 text-center column-sex">${applicant.sex}</td>
                                <td class="px-6 py-4 text-center column-birthdate">${applicant.birthdate}</td>
                                <td class="px-6 py-4 text-center column-cellphone_no">${applicant.cellphone_no}</td>
                                <td class="px-6 py-4 text-center column-approved">${applicant.updated_at}</td>
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
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }

                function renderPagination(data) {
                    if (data.total === 0) {
                        $('#paginationLinks').hide();
                        return;
                    }
                    
                    $('#paginationLinks').show();
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApprovedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApprovedApplicants(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchApprovedApplicants(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchApprovedApplicants(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchApprovedApplicants(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApprovedApplicants(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchApprovedApplicants(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.fetchApprovedApplicants = fetchApprovedApplicants;
            });
        </script>
    </x-slot>
</x-app-layout>