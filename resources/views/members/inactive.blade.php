<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Inactive Members') }}
            </h2>

            <div class="flex w-full md:w-auto justify-center md:justify-end">
                <a href="{{ route('members.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto text-center

                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Members
                </a>        
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="hidden sm:flex justify-between items-center mb-4 gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">No. of entries</span>
                                <select id="perPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-24">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Sort by</span>
                                <select id="sortBy" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                                    <option value="created_desc">Default</option>
                                    <option value="name_asc">Name (A-Z)</option>
                                    <option value="name_desc">Name (Z-A)</option>
                                    <option value="email_asc">Email (A-Z)</option>
                                    <option value="email_desc">Email (Z-A)</option>
                                    <option value="start_asc">Start Date (Oldest First)</option>
                                    <option value="start_desc">Start Date (Newest First)</option>
                                    <option value="end_asc">End Date (Oldest First)</option>
                                    <option value="end_desc">End Date (Newest First)</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> items
                            </div>
                            <div class="relative w-48">
                                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none" 
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>

                                <input type="text" id="searchInput" 
                                    placeholder="Search Name" class="pl-8 pr-2 py-2 border border-gray-300 dark:border-gray-600 
                                    dark:bg-gray-700 dark:text-gray-300 dark:placeholder-gray-400 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-full">
                            </div>
                        </div>
                    </div>
    
                    <div class="sm:hidden space-y-3 mb-4">
                        <div class="relative w-full">
                            <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none" 
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                            </svg>

                            <input type="text" id="mobileSearchInput" placeholder="Search Name" 
                                class="pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                dark:placeholder-gray-400 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-full">
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap w-1/3">No. of entries</span>
                            <select id="mobilePerPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-2/3">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap w-1/3">Sort by</span>
                            <select id="mobileSortBy" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-2/3">
                                <option value="created_desc">Default</option>
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="email_asc">Email (A-Z)</option>
                                <option value="email_desc">Email (Z-A)</option>
                                <option value="start_asc">Start Date (Oldest First)</option>
                                <option value="start_desc">Start Date (Newest First)</option>
                                <option value="end_asc">End Date (Oldest First)</option>
                                <option value="end_desc">End Date (Newest First)</option>
                            </select>
                        </div>

                        <div id="mobileResultInfo" class="text-sm text-gray-700 dark:text-gray-300 text-center">
                            Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> items
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="inactiveMembersTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-fullname">Full Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-email">Email</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-cellphone">Cellphone</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-start">Start</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-end">End</th>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
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
                background-color: rgba(239, 68, 68, 0.08);
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                border-left: 4px solid #ef4444;
            }

            .table-row-hover:hover td:first-child {
                border-left: 4px solid #ef4444;
                padding-left: calc(1.5rem - 4px);
            }
        </style>
        
        <script>
            $(document).ready(function () {
                fetchInactiveMembers();

                $('#columnFilterButton').on('click', function(e) {
                    e.stopPropagation();
                    $('#columnFilterDropdown').toggleClass('hidden');
                });

                $('#mobileColumnFilterButton').on('click', function(e) {
                    e.stopPropagation();
                    $('#mobileColumnFilterDropdown').toggleClass('hidden');
                });

                $(document).on('click', function() {
                    $('#columnFilterDropdown, #mobileColumnFilterDropdown').addClass('hidden');
                });

                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    const searchValue = $(this).val();
                    if ($(this).attr('id') === 'searchInput') {
                        $('#mobileSearchInput').val(searchValue);
                    } else {
                        $('#searchInput').val(searchValue);
                    }
                    fetchInactiveMembers(1, searchValue);
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    const perPageValue = $(this).val();
                    if ($(this).attr('id') === 'perPage') {
                        $('#mobilePerPage').val(perPageValue);
                    } else {
                        $('#perPage').val(perPageValue);
                    }
                    fetchInactiveMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), perPageValue);
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    const sortValue = $(this).val();
                    if ($(this).attr('id') === 'sortBy') {
                        $('#mobileSortBy').val(sortValue);
                    } else {
                        $('#sortBy').val(sortValue);
                    }
                    fetchInactiveMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                $(document).on('change', '.column-checkbox', function() {
                    const column = $(this).data('column');
                    const isChecked = $(this).is(':checked');
                    
                    $(`.column-checkbox[data-column="${column}"]`).prop('checked', isChecked);
                    
                    $(`.column-${column}`).toggle(isChecked);
                });

                function fetchInactiveMembers(page = 1, search = '', perPage = null) {
                    if (!perPage) {
                        perPage = $('#perPage').val() || $('#mobilePerPage').val() || '10';
                    }
                    
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    
                    console.log('Fetching with params:', { page, search, perPage, sortValue });
                    
                    const sortMap = {
                        'name_asc': { sort: 'first_name', direction: 'asc' },
                        'name_desc': { sort: 'first_name', direction: 'desc' },
                        'email_asc': { sort: 'email_address', direction: 'asc' },
                        'email_desc': { sort: 'email_address', direction: 'desc' },
                        'start_asc': { sort: 'membership_start', direction: 'asc' },
                        'start_desc': { sort: 'membership_start', direction: 'desc' },
                        'end_asc': { sort: 'membership_end', direction: 'asc' },
                        'end_desc': { sort: 'membership_end', direction: 'desc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('members.inactive') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        beforeSend: function() {
                            console.log('Loading inactive members...');
                        },
                        success: function (response) {
                            let data, from;
                            
                            if (response.data && Array.isArray(response.data)) {
                                data = response.data;
                                from = response.from || 1;
                            } else if (Array.isArray(response)) {
                                data = response;
                                from = ((page - 1) * perPage) + 1;
                                response = {
                                    data: data,
                                    current_page: page,
                                    last_page: Math.ceil(data.length / perPage),
                                    from: from,
                                    to: Math.min(from + data.length - 1, from + perPage - 1),
                                    total: data.length
                                };
                            } else {
                                console.error('Unexpected response format:', response);
                                data = [];
                                from = 1;
                                response = {
                                    data: [],
                                    current_page: 1,
                                    last_page: 1,
                                    from: 0,
                                    to: 0,
                                    total: 0
                                };
                            }
                            
                            renderInactiveMembers(data, from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching inactive members:', error);
                            console.error('Response:', xhr.responseText);
                            
                            let tbody = $('#inactiveMembersTable tbody');
                            tbody.html(`
                                <tr class="table-row-animate">
                                    <td colspan="7" class="px-6 py-4 text-center text-red-500 dark:text-red-400">
                                        Error loading data. Please try again. 
                                        <button onclick="fetchInactiveMembers()" class="ml-2 text-blue-500 hover:text-blue-700">Retry</button>
                                    </td>
                                </tr>
                            `);
                            
                            $('#paginationLinks').html('');
                            $('#startRecord, #mobileStartRecord').text('0');
                            $('#endRecord, #mobileEndRecord').text('0');
                            $('#totalRecords, #mobileTotalRecords').text('0');
                        }
                    });
                }

                function renderInactiveMembers(members, startIndex) {
                    let tbody = $('#inactiveMembersTable tbody');
                    tbody.empty();
                    
                    if (!members || members.length === 0) {
                        tbody.append(`
                            <tr class="table-row-animate">
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No inactive members found
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    
                    members.forEach((member, index) => {
                        const rowNumber = (startIndex || 1) + index;

                        let row = `
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-fullname">${member.full_name || ''}</td>
                                <td class="px-6 py-4 text-left column-email">${member.email_address || ''}</td>
                                <td class="px-6 py-4 text-left column-cellphone">${member.cellphone_no || ''}</td>
                                <td class="px-6 py-4 text-left column-start">${member.membership_start || ''}</td>
                                <td class="px-6 py-4 text-left column-end">${member.membership_end || ''}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    <a href="/members/${member.id}/edit" 
                                        class="group flex items-center bg-indigo-100 hover:bg-indigo-500 px-2 py-1 sm:px-3 sm:py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 sm:h-4 sm:w-4 text-indigo-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        <span class="text-indigo-600 group-hover:text-white text-xs sm:text-sm">Edit</span>
                                    </a>
                                    <button class="group flex items-center bg-red-100 hover:bg-red-600 px-3 py-2 rounded-full transition space-x-1 delete-member-btn" 
                                            data-id="${member.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-red-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="text-red-600 group-hover:text-white text-sm">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });

                    tbody[0].offsetHeight;
                }

                function renderPagination(data) {
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';

                    if (!data || !data.last_page || data.last_page <= 1) {
                        $('#paginationLinks').html('');
                        return;
                    }

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchInactiveMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchInactiveMembers(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchInactiveMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchInactiveMembers(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchInactiveMembers(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchInactiveMembers(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchInactiveMembers(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.fetchInactiveMembers = fetchInactiveMembers;

                $(document).on('click', '.delete-member-btn', function(e) {
                    e.preventDefault();
                    const memberId = $(this).data('id');
                    
                    if (!memberId) return;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will permanently delete the member's record.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#5e6ffb',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                background: '#101966',
                                color: '#fff',
                                allowOutsideClick: false
                            }).then(() => {
                                $.ajax({
                                    url: "{{ route('members.forceDelete') }}",
                                    method: 'POST',
                                    data: {
                                        '_method': 'DELETE',
                                        'id': memberId,
                                        '_token': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        if (data.status) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Deleted!',
                                                text: data.message || 'Member deleted successfully.',
                                                confirmButtonColor: "#5e6ffb",
                                                background: '#101966',
                                                color: '#fff'
                                            }).then(() => {
                                                fetchInactiveMembers();
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: data.message || 'Failed to delete member.',
                                                confirmButtonColor: "#5e6ffb",
                                                background: '#101966',
                                                color: '#fff'
                                            });
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Delete error:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Failed to delete member. Please try again.',
                                            confirmButtonColor: "#5e6ffb",
                                            background: '#101966',
                                            color: '#fff'
                                        });
                                    }
                                });
                            });
                        }
                    });
                });

                @if(session('success'))
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "{{ session('success') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ session('error') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>