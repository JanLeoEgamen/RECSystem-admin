<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <!-- Header Title -->
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
                {{ __('Articles') }}
            </h2>

            <!-- Create Button -->
            @can('create articles')
            <a href="{{ route('articles.create') }}" 
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
                      text-center sm:text-right transition">
                Create
            </a>
            @endcan

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
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                    <option value="author_asc">Author (A-Z)</option>
                                    <option value="author_desc">Author (Z-A)</option>
                                    <option value="status_desc">Status (Active First)</option>
                                    <option value="status_asc">Status (Inactive First)</option>
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
                                                    <input type="checkbox" class="column-checkbox" data-column="title" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Title</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="image" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Image</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="author" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Article Author</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="uploaded_by" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Uploaded by</span>
                                                </label>
                                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                    <input type="checkbox" class="column-checkbox" data-column="status" checked>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Status</span>
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
                            <input type="text" id="searchInput" placeholder="Search articles..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <!-- Mobile View - Vertical layout -->
                    <div class="sm:hidden space-y-3 mb-4">
                        <!-- Search bar -->
                        <input type="text" id="mobileSearchInput" placeholder="Search articles..." 
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
                                <option value="title_asc">Title (A-Z)</option>
                                <option value="title_desc">Title (Z-A)</option>
                                <option value="author_asc">Author (A-Z)</option>
                                <option value="author_desc">Author (Z-A)</option>
                                <option value="status_desc">Status (Active First)</option>
                                <option value="status_asc">Status (Inactive First)</option>
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
                                                <input type="checkbox" class="column-checkbox" data-column="title" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Title</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="image" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Image</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="author" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Article Author</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="uploaded_by" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Uploaded by</span>
                                            </label>
                                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded cursor-pointer">
                                                <input type="checkbox" class="column-checkbox" data-column="status" checked>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Status</span>
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
                            <table id="articlesTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-title">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-image">Image</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-author">Article Author</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-uploaded_by">Uploaded by</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-status">Status</th>
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
                fetchArticles();

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
                    fetchArticles(1, $(this).val());
                });

                // Entries per page change handler
                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchArticles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                // Sort by change handler
                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchArticles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                // Column checkbox change handler
                $('.column-checkbox').on('change', function() {
                    const column = $(this).data('column');
                    const isChecked = $(this).is(':checked');
                    
                    // Show/hide the column
                    $(`.column-${column}`).toggle(isChecked);
                });

                function fetchArticles(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'title_asc': { sort: 'title', direction: 'asc' },
                        'title_desc': { sort: 'title', direction: 'desc' },
                        'author_asc': { sort: 'author', direction: 'asc' },
                        'author_desc': { sort: 'author', direction: 'desc' },
                        'status_asc': { sort: 'status', direction: 'asc' },
                        'status_desc': { sort: 'status', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('articles.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderArticles(response.data, response.from);
                            renderPagination(response);
                            
                            // Update both desktop and mobile result info
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderArticles(articles, startIndex) {
                    let tbody = $('#articlesTable tbody');
                    tbody.empty();
                    
                    articles.forEach((article, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-title">${article.title}</td>
                                <td class="px-6 py-4 text-center column-image">
                                    ${article.image_url 
                                        ? `<img src="${article.image_url}" alt="Article Image" class="h-20 w-20 object-cover rounded">` 
                                        : 'No Image'}
                                </td>
                                <td class="px-6 py-4 text-left column-author">${article.author}</td>
                                <td class="px-6 py-4 text-left column-uploaded_by">${article.uploaded_by}</td>
                                <td class="px-6 py-4 text-center column-status">
                                    ${article.status === 'Active' 
                                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>'
                                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Inactive</span>'}
                                </td>
                                <td class="px-6 py-4 text-left column-created">${article.created_at}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    <a href="/articles/${article.id}/edit" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                    </a>
                                    <button onclick="deleteArticle(${article.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
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
                                onclick="fetchArticles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchArticles(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchArticles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchArticles(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchArticles(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchArticles(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchArticles(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteArticle = function (id) {
                    if (confirm("Are you sure you want to delete?")) {
                        $.ajax({
                            url: '{{ route("articles.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchArticles();
                            }
                        });
                    }
                }
                window.fetchArticles = fetchArticles;
            });
        </script>
    </x-slot>
</x-app-layout>