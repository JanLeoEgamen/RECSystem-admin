<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Edit Users Manual') }}">
            <x-slot name="createButton">
                <x-create-button 
                    :route="route('manual.create')" 
                    permission="create manuals" />
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Desktop Filter Section -->
                    <div class="hidden sm:block mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 shadow-sm border border-blue-100 dark:border-gray-600">
                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
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

                                <!-- Type Filter -->
                                <div class="flex flex-col space-y-2">
                                    <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Type
                                    </label>
                                    <select id="typeFilter" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 hover:border-purple-300 cursor-pointer">
                                        <option value="">All Types</option>
                                        <option value="tutorial_video">Tutorial Video</option>
                                        <option value="faq">FAQ</option>
                                        <option value="user_guide">User Guide</option>
                                        <option value="support">Support</option>
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
                                        <option value="created_desc">Latest First</option>
                                        <option value="title_asc">Title (A-Z)</option>
                                        <option value="title_desc">Title (Z-A)</option>
                                        <option value="type_asc">Type (A-Z)</option>
                                        <option value="created_asc">Created (Oldest First)</option>
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
                                            placeholder="Search content..." 
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
                                        placeholder="Search content..." 
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

                            <!-- Type Filter -->
                            <div class="flex flex-col space-y-2">
                                <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Type
                                </label>
                                <select id="mobileTypeFilter" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="">All Types</option>
                                    <option value="tutorial_video">Tutorial Video</option>
                                    <option value="faq">FAQ</option>
                                    <option value="user_guide">User Guide</option>
                                    <option value="support">Support</option>
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
                                    <option value="created_desc">Latest First</option>
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                    <option value="type_asc">Type (A-Z)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
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
                            <table id="manualTable" class="w-full bg-white dark:bg-gray-800 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Type</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Description</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Status</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Created</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900">
                                    <!-- Table rows will be inserted here by JavaScript -->
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

            .type-badge {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
            }

            .type-tutorial_video {
                @apply bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100;
            }

            .type-faq {
                @apply bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100;
            }

            .type-user_guide {
                @apply bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100;
            }

            .type-support {
                @apply bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                fetchManualContents();
                
                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchManualContents(1, $(this).val());
                });
                
                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchManualContents(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });
                
                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchManualContents(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                $('#typeFilter, #mobileTypeFilter').on('change', function() {
                    fetchManualContents(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function fetchManualContents(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const typeFilter = $('#typeFilter').val() || $('#mobileTypeFilter').val() || '';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'title_asc': { sort: 'title', direction: 'asc' },
                        'title_desc': { sort: 'title', direction: 'desc' },
                        'type_asc': { sort: 'type', direction: 'asc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('manual.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            type: typeFilter,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderManualContents(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderManualContents(contents, startIndex) {
                    let tbody = $('#manualTable tbody');
                    tbody.empty();
                    
                    if (contents.length === 0) {
                        tbody.append(`
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-500 mb-2">No manual contents found</p>
                                        <p class="text-gray-400">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    contents.forEach((content, index) => {
                        const rowNumber = startIndex + index;
                        const createdDate = new Date(content.created_at).toLocaleDateString();
                        const statusBadge = content.is_active ? 
                            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Active</span>' : 
                            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Inactive</span>';
                        
                        const typeClass = `type-${content.type}`;
                        const typeDisplay = content.type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        
                        const row = `
                            <tr class="border-b dark:border-gray-700 table-row-animate table-row-hover">
                                <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">${rowNumber}</td>
                                <td class="px-6 py-4 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">${content.title}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center dark:border-gray-700">
                                    <span class="type-badge ${typeClass}">${typeDisplay}</span>
                                </td>
                                <td class="px-6 py-4  dark:border-gray-700 border-gray-200">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">${content.description || 'No description'}</div>
                                </td>
                                <td class="px-6 py-4 text-center  dark:border-gray-700">${statusBadge}</td>
                                <td class="px-6 py-4 text-center  dark:border-gray-700">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">${createdDate}</div>
                                </td>
                                <td class="px-6 py-4 text-center dark:border-gray-700">
                                    <div class="flex justify-center space-x-2">
                                        <a href="/manual/${content.id}/edit" 
                                           class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                            </svg>
                                            <span class="text-blue-600 group-hover:text-white text-sm">Edit</span>
                                        </a>
                                        <button onclick="deleteManualContent(${content.id})" 
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

                function renderPagination(response) {
                    let pagination = $('#paginationLinks');
                    pagination.empty();

                    if (response.last_page <= 1) return;

                    let links = '';

                    // Previous button
                    if (response.current_page > 1) {
                        links += `<button onclick="fetchManualContents(${response.current_page - 1})" 
                                  class="px-3 py-2 mx-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                  Previous</button>`;
                    }

                    // Page numbers
                    for (let i = 1; i <= response.last_page; i++) {
                        if (i === response.current_page) {
                            links += `<span class="px-3 py-2 mx-1 text-sm font-medium text-blue-600 border border-blue-300 bg-blue-50 rounded-lg dark:border-gray-700 dark:bg-gray-700 dark:text-white">${i}</span>`;
                        } else {
                            links += `<button onclick="fetchManualContents(${i})" 
                                      class="px-3 py-2 mx-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">${i}</button>`;
                        }
                    }

                    // Next button
                    if (response.current_page < response.last_page) {
                        links += `<button onclick="fetchManualContents(${response.current_page + 1})" 
                                  class="px-3 py-2 mx-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                  Next</button>`;
                    }

                    pagination.html(links);
                }

                window.fetchManualContents = fetchManualContents;
            });

            function deleteManualContent(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/manual/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    );
                                    // Refresh the table
                                    fetchManualContents();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the content.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>