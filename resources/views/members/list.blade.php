<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> 
            <div>
                <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                    {{ __('Members') }}
                </h2>
                <p id="filterStatusText" class="text-sm text-gray-300 dark:text-gray-400 mt-1 text-center sm:text-left hidden">
                    Showing: <span id="filterStatusLabel" class="font-semibold"></span>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">
                @can('create members')
                <a href="{{ route('members.showMemberCreateForm') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium
                    rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto text-center

                    dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
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

                                <!-- Status Filter -->
                                <div class="flex flex-col space-y-2">
                                    <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Status Filter
                                    </label>
                                    <select id="statusFilter" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 hover:border-purple-300 cursor-pointer">
                                        <option value="all" selected>All Members</option>
                                        <option value="active">✓ Active</option>
                                        <option value="expiring">⏰ Expiring Soon</option>
                                        <option value="expired">✕ Expired</option>
                                        <option value="inactive">⊘ Inactive</option>
                                        <option value="lifetime">★ Lifetime</option>
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
                                        <option value="last_name_asc">Name (A-Z)</option>
                                        <option value="last_name_desc">Name (Z-A)</option>
                                        <option value="rec_number_asc">REC No. ↑</option>
                                        <option value="rec_number_desc">REC No. ↓</option>
                                        <option value="membership_start_asc">Start Date (Old)</option>
                                        <option value="membership_start_desc">Start Date (New)</option>
                                        <option value="membership_end_asc">End Date (Soon)</option>
                                        <option value="membership_end_desc">End Date (Late)</option>
                                        <option value="status_asc">Status (Active First)</option>
                                        <option value="status_desc">Status (Inactive First)</option>
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
                                            placeholder="Search member name..." 
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Showing <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="startRecord">0</span> to 
                                        <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="endRecord">0</span> of 
                                        <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="totalRecords">0</span> members
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
                                        placeholder="Search member name..." 
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

                            <!-- Status Filter -->
                            <div class="flex flex-col space-y-2">
                                <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter by Status
                                </label>
                                <select id="mobileStatusFilter" class="form-select bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 dark:text-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="all" selected>All Members</option>
                                    <option value="active">✓ Active</option>
                                    <option value="expiring">⏰ Expiring Soon</option>
                                    <option value="expired">✕ Expired</option>
                                    <option value="inactive">⊘ Inactive</option>
                                    <option value="lifetime">★ Lifetime</option>
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
                                    <option value="last_name_asc">Name (A-Z)</option>
                                    <option value="last_name_desc">Name (Z-A)</option>
                                    <option value="rec_number_asc">REC No. ↑</option>
                                    <option value="rec_number_desc">REC No. ↓</option>
                                    <option value="membership_start_asc">Start Date (Old)</option>
                                    <option value="membership_start_desc">Start Date (New)</option>
                                    <option value="membership_end_asc">End Date (Soon)</option>
                                    <option value="membership_end_desc">End Date (Late)</option>
                                    <option value="status_asc">Status (Active First)</option>
                                    <option value="status_desc">Status (Inactive First)</option>
                                </select>
                            </div>

                            <!-- Results Info -->
                            <div class="pt-3 border-t border-blue-200 dark:border-gray-500">
                                <div id="mobileResultInfo" class="flex items-center justify-center text-xs text-gray-600 dark:text-gray-300 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Showing <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="mobileStartRecord">0</span> to 
                                    <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="mobileEndRecord">0</span> of 
                                    <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="mobileTotalRecords">0</span> members
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-full">
                            <table id="membersTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium whitespace-nowrap">#</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-personal whitespace-nowrap">Full Name</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-contact whitespace-nowrap">Email</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-contact whitespace-nowrap">Cellphone</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-membership whitespace-nowrap">REC No.</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-membership whitespace-nowrap">Membership Type</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-membership whitespace-nowrap">Start Date</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-membership whitespace-nowrap">End Date</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-membership whitespace-nowrap">Status</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-address whitespace-nowrap">Address</th>
                                        <th class="px-3 sm:px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white whitespace-nowrap">Action</th>
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

            /* Filter Card Animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .bg-gradient-to-r {
                animation: fadeInUp 0.5s ease-out;
            }

            /* Select Hover Effects */
            select.form-select:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            select.form-select {
                transition: all 0.2s ease-in-out;
            }

            /* Input Focus Effects */
            input[type="text"]:focus {
                transform: translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            input[type="text"] {
                transition: all 0.2s ease-in-out;
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
                // Check for URL parameters and set initial filter
                const urlParams = new URLSearchParams(window.location.search);
                const statusParam = urlParams.get('status_filter');
                
                if (statusParam) {
                    $('#statusFilter').val(statusParam);
                    $('#mobileStatusFilter').val(statusParam);
                    updateFilterLabel(statusParam);
                }
                
                fetchMembers();
                
                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    const searchValue = $(this).val();
                    if ($(this).attr('id') === 'searchInput') {
                        $('#mobileSearchInput').val(searchValue);
                    } else {
                        $('#searchInput').val(searchValue);
                    }
                    fetchMembers(1, searchValue);
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    const perPageValue = $(this).val();
                    if ($(this).attr('id') === 'perPage') {
                        $('#mobilePerPage').val(perPageValue);
                    } else {
                        $('#perPage').val(perPageValue);
                    }
                    fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), perPageValue);
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    const sortValue = $(this).val();
                    if ($(this).attr('id') === 'sortBy') {
                        $('#mobileSortBy').val(sortValue);
                    } else {
                        $('#sortBy').val(sortValue);
                    }
                    fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                $('#statusFilter, #mobileStatusFilter').on('change', function() {
                    const statusValue = $(this).val();
                    if ($(this).attr('id') === 'statusFilter') {
                        $('#mobileStatusFilter').val(statusValue);
                    } else {
                        $('#statusFilter').val(statusValue);
                    }
                    updateFilterLabel(statusValue);
                    fetchMembers(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function updateFilterLabel(status) {
                    const filterText = $('#filterStatusText');
                    const filterLabel = $('#filterStatusLabel');
                    
                    if (status === 'all') {
                        filterText.addClass('hidden');
                    } else {
                        const statusLabels = {
                            'active': 'Active Members Only',
                            'expiring': 'Expiring Members Only',
                            'expired': 'Expired Members Only',
                            'inactive': 'Inactive Members Only',
                            'lifetime': 'Lifetime Members Only'
                        };
                        filterLabel.text(statusLabels[status] || status);
                        filterText.removeClass('hidden');
                    }
                }

                function fetchMembers(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const statusFilter = $('#statusFilter').val() || $('#mobileStatusFilter').val() || 'all';
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
                            direction: sortParams.direction,
                            status_filter: statusFilter
                        },
                        success: function (response) {
                            renderMembers(response.data, response.from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderMembers(members, startIndex) {
                    let tbody = $('#membersTable tbody');
                    tbody.empty();
                    
                    if (members.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium mb-2">No members found</p>
                                        <p class="text-sm">There are no members matching your search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    
                    members.forEach((member, index) => {
                        const rowNumber = startIndex + index;
                        const fullName = `${member.first_name} ${member.last_name}`;
                        
                        // Create status badge based on actual status
                        let statusBadge = '';
                        if (member.is_lifetime_member) {
                            statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-tight text-purple-700 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-100">Lifetime</span>';
                        } else if (member.status === 'Active') {
                            statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-100">Active</span>';
                        } else if (member.status === 'Expiring') {
                            statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-100">Expiring</span>';
                        } else if (member.status === 'Expired') {
                            statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:bg-orange-900 dark:text-orange-100">Expired</span>';
                        } else {
                            statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-100">Inactive</span>';
                        }

                        let row = `
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
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
                                <td class="px-3 sm:px-6 py-4 text-center">
                                    <div class="flex justify-center items-center space-x-1 sm:space-x-2 whitespace-nowrap">
                                        ${member.can_view ? `
                                        <a href="/members/${member.id}" 
                                            class="group flex items-center bg-blue-100 hover:bg-blue-500 px-2 py-1 sm:px-3 sm:py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 sm:h-4 sm:w-4 text-blue-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-blue-600 group-hover:text-white text-xs sm:text-sm">View</span>
                                        </a>
                                        ` : ''}
                                        ${member.can_edit ? `
                                        <a href="/members/${member.id}/edit" 
                                            class="group flex items-center bg-indigo-100 hover:bg-indigo-500 px-2 py-1 sm:px-3 sm:py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 sm:h-4 sm:w-4 text-indigo-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="text-indigo-600 group-hover:text-white text-xs sm:text-sm">Edit</span>
                                        </a>
                                        ` : ''}
                                        ${member.can_renew ? `
                                        <a href="/members/${member.id}/renew" 
                                            class="group flex items-center bg-green-100 hover:bg-green-500 px-2 py-1 sm:px-3 sm:py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 sm:h-4 sm:w-4 text-green-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span class="text-green-600 group-hover:text-white text-xs sm:text-sm">Renew</span>
                                        </a>
                                        ` : ''}
                                        ${member.can_delete ? `
                                        <button onclick="deactivateMember(${member.id})" dusk="deactivate-member-${member.id}" 
                                            class="group flex items-center bg-yellow-100 hover:bg-yellow-500 px-2 py-1 sm:px-3 sm:py-2 rounded-full transition space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                class="h-3 w-3 sm:h-4 sm:w-4 text-yellow-600 group-hover:text-white transition" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                                            </svg>
                                            <span class="text-yellow-600 group-hover:text-white text-xs sm:text-sm">Deactivate</span>
                                        </button>
                                        ` : ''}
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }

                function renderPagination(data) {
                    // Hide pagination if no data
                    if (!data.data || data.data.length === 0 || data.total === 0) {
                        $('#paginationLinks').html('');
                        return;
                    }

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

                window.deactivateMember = function (id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will deactivate the member's account.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#5e6ffb',
                        confirmButtonText: 'Yes, deactivate it!',
                        background: '#101966',
                        color: '#fff',
                        customClass: {
                            icon: 'swal-icon-red-bg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
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
                                    Swal.fire({
                                        title: 'Deactivated!',
                                        text: 'Member has been deactivated successfully.',
                                        icon: 'success',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    fetchMembers();
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Deactivation failed',
                                        icon: 'error',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to deactivate member.',
                                    icon: 'error',
                                    background: '#101966',
                                    color: '#fff'
                                });
                            });
                        }
                    });
                }

                window.fetchMembers = fetchMembers;
            });
        </script>
    </x-slot>
</x-app-layout>