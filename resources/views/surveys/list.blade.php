<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Surveys') }}">
            <x-slot name="createButton">
                <x-create-button 
                    :route="route('surveys.create')" 
                    permission="create surveys" />
            </x-slot>
        </x-page-header>
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
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                    <option value="is_published_desc">Status (Published First)</option>
                                    <option value="is_published_asc">Status (Draft First)</option>
                                    <option value="responses_count_desc">Responses (High to Low)</option>
                                    <option value="responses_count_asc">Responses (Low to High)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> markees
                            </div>
                            <div class="relative w-48">
                                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none" 
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>

                                <input type="text" id="searchInput" 
                                    placeholder="Search Title" class="pl-8 pr-2 py-2 border border-gray-300 dark:border-gray-600 
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

                            <input type="text" id="mobileSearchInput" placeholder="Search Title" 
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
                                <option value="title_asc">Title (A-Z)</option>
                                <option value="title_desc">Title (Z-A)</option>
                                <option value="is_published_desc">Status (Published First)</option>
                                <option value="is_published_asc">Status (Draft First)</option>
                                <option value="responses_count_desc">Responses (High to Low)</option>
                                <option value="responses_count_asc">Responses (Low to High)</option>
                                <option value="created_asc">Created (Oldest First)</option>
                            </select>
                        </div>

                        <div id="mobileResultInfo" class="text-sm text-gray-700 dark:text-gray-300 text-center">
                            Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> items
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="surveysTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-title">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-is_published">Status</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-responses_count">Responses</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-author">Author</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-created">Created</th>
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
            .swal2-icon {
                border: 4px solid #ff0000 !important;
                background-color: transparent !important;
                color: #ff0000 !important;
            }

            .swal2-icon.swal2-warning .swal2-icon-content,
            .swal2-icon.swal2-error .swal2-icon-content,
            .swal2-icon.swal2-success .swal2-icon-content,
            .swal2-icon.swal2-info .swal2-icon-content,
            .swal2-icon.swal2-question .swal2-icon-content {
                color: #ff0000 !important;
            }

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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                fetchSurveys();
                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchSurveys(1, $(this).val());
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchSurveys(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchSurveys(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function fetchSurveys(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'title_asc': { sort: 'title', direction: 'asc' },
                        'title_desc': { sort: 'title', direction: 'desc' },
                        'is_published_asc': { sort: 'is_published', direction: 'asc' },
                        'is_published_desc': { sort: 'is_published', direction: 'desc' },
                        'responses_count_asc': { sort: 'responses_count', direction: 'asc' },
                        'responses_count_desc': { sort: 'responses_count', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('surveys.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderSurveys(response.data, response.from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderSurveys(surveys, startIndex) {
                    let tbody = $('#surveysTable tbody');
                    tbody.empty();
                    
                    surveys.forEach((survey, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-title">${survey.title}</td>
                                <td class="px-6 py-4 text-center column-is_published">
                                    ${survey.is_published 
                                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>'}
                                </td>
                                <td class="px-6 py-4 text-center column-responses_count">${survey.responses_count}</td>
                                <td class="px-6 py-4 text-center column-author">${survey.author}</td>
                                <td class="px-6 py-4 text-center column-created">${survey.created_at}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        ${survey.can_view_responses ? `
                                        <a href="/surveys/${survey.id}/responses" 
                                            class="group flex items-center bg-purple-100 hover:bg-purple-500 px-3 py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-purple-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-purple-600 group-hover:text-white text-sm">Responses</span>
                                        </a>
                                        ` : ''}
                                        <a href="/surveys/${survey.id}/edit" 
                                            class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                            </svg>
                                            <span class="text-blue-600 group-hover:text-white text-sm">Edit</span>
                                        </a>
                                        <button onclick="deleteSurvey(${survey.id})" 
                                            class="group flex items-center bg-red-100 hover:bg-red-600 px-3 py-2 rounded-full transition space-x-1"> 
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-red-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span class="text-red-600 group-hover:text-white text-sm">Delete</span>
                                        </button>
                                    </div>
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
                                onclick="fetchSurveys(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchSurveys(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchSurveys(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchSurveys(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchSurveys(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchSurveys(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchSurveys(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteSurvey = function (id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the survey and all its responses. This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#5e6ffb',
                        confirmButtonText: 'Yes, delete it!',
                        background: '#101966',
                        color: '#fff',
                        customClass: {
                            icon: 'swal-icon-red-bg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("surveys.destroy") }}',
                                type: 'DELETE',
                                data: { id: id },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Survey and all its responses have been deleted successfully.',
                                        icon: 'success',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    fetchSurveys();
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Something went wrong while deleting the survey.',
                                        icon: 'error',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            });
                        }
                    });
                }

                window.fetchSurveys = fetchSurveys;
            });
        </script>
    </x-slot>
</x-app-layout>