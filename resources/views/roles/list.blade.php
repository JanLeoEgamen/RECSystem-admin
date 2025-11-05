<x-app-layout> 
    <x-slot name="header">
        <x-page-header title="{{ __('Roles') }}">
            <x-slot name="createButton">
                <x-create-button 
                    :route="route('roles.create')" 
                    permission="create roles" />
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
                                    <option value="created_desc">Latest First</option>
                                    <option value="name_asc">Name (A-Z)</option>
                                    <option value="name_desc">Name (Z-A)</option>
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
                                        placeholder="Search name..." 
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
                                    placeholder="Search name..." 
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
                                <option value="created_desc">Latest First</option>
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
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
                        <table id="rolesTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                            <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-6 py-3 text-center font-medium">#</th>
                                    <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-name">Roles</th>
                                    <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-permissions">Permissions</th>
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

<div id="permissionsModal" class="hidden fixed inset-0 bg-black bg-opacity-40 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-3xl mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border-0">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700 rounded-t-2xl bg-[#101966] dark:bg-gray-800">
            <h3 class="text-xl font-semibold text-white tracking-wide">Permissions</h3>
            <button onclick="document.getElementById('permissionsModal').classList.add('hidden')" 
                class="text-gray-200 hover:text-red-400 transition-colors duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="modalPermissionsContent" class="p-6 max-h-[60vh] overflow-y-auto bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
            <!-- Permissions will be injected here -->
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-b-2xl text-right">
            <button onclick="document.getElementById('permissionsModal').classList.add('hidden')" 
                class="px-5 py-2 text-base font-medium bg-[#101966] text-white rounded-lg shadow hover:bg-blue-700 transition-colors duration-200">
                Close
            </button>
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

        .permission-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .permission-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .permission-badge svg {
            margin-right: 0.375rem;
            flex-shrink: 0;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            fetchRoles();

            $('#searchInput, #mobileSearchInput').on('keyup', function () {
                fetchRoles(1, $(this).val());
            });

            $('#perPage, #mobilePerPage').on('change', function () {
                fetchRoles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
            });

            $('#sortBy, #mobileSortBy').on('change', function() {
                fetchRoles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
            });

            function fetchRoles(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                const [column, direction] = sortValue.split('_');

                const sortMap = {
                    'name_asc': { sort: 'name', direction: 'asc' },
                    'name_desc': { sort: 'name', direction: 'desc' },
                    'created_asc': { sort: 'created_at', direction: 'asc' },
                    'created_desc': { sort: 'created_at', direction: 'desc' }
                };

                const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                $.ajax({
                    url: `{{ route('roles.index') }}`,
                    type: 'GET',
                    data: {
                        page: page,
                        search: search,
                        perPage: perPage,
                        sort: sortParams.sort,
                        direction: sortParams.direction
                    },
                    success: function (response) {
                        renderRoles(response.data, response.from);
                        renderPagination(response);
                        
                        $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                        $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                        $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                    }
                });
            }

            function renderRoles(roles, startIndex) {
                let tbody = $('#rolesTable tbody');
                tbody.empty();
                
                roles.forEach((role, index) => {
                    const rowNumber = startIndex + index;
                    
                    const protectedRoles = ['superadmin', 'Member', 'Applicant'];
                    const isProtectedRole = protectedRoles.includes(role.name);
                    const showEditButton = !isProtectedRole;
                    const showDeleteButton = !isProtectedRole;
                    
                    // Check if permissions is empty or contains no meaningful content
                    const hasPermissions = role.permissions && role.permissions.trim() !== '' && role.permissions.replace(/<br>/g, '').trim() !== '';
                    
                    let permissionsDisplay = '';
                    if (!hasPermissions) {
                        permissionsDisplay = '<span class="text-gray-500 dark:text-gray-400 italic text-sm">No permissions attached to this role</span>';
                    } else if (role.permissions.length > 50) {
                        permissionsDisplay = role.permissions.substring(0, 50) + '... <button onclick="showFullPermissions(\'' + escapeHtml(role.permissions) + '\')" class="text-blue-500 hover:text-blue-700 text-xs font-medium underline">View All</button>';
                    } else {
                        permissionsDisplay = role.permissions;
                    }
                    
                    let row = `
                        <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                            <td class="px-6 py-4 text-center">${rowNumber}</td>
                            <td class="px-6 py-4 text-left column-name">${role.name}</td>
                            <td class="px-6 py-4 text-left column-permissions">
                                ${permissionsDisplay}
                            </td>
                            <td class="px-6 py-4 text-center column-created">${role.created_at}</td>
                            <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                ${showEditButton ? `
                                    @can('edit roles')
                                    <a href="/roles/${role.id}/edit" class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                        <span class="text-blue-600 group-hover:text-white text-sm">Edit</span>
                                    </a>
                                    @endcan
                                ` : ''}
                                ${showDeleteButton ? `
                                    @can('delete roles')
                                    <button onclick="deleteRole(${role.id})" class="group flex items-center bg-red-100 hover:bg-red-600 px-3 py-2 rounded-full transition space-x-1"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-red-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="text-red-600 group-hover:text-white text-sm">Delete</span>
                                    </button>
                                    @endcan
                                ` : ''}
                                ${isProtectedRole ? `
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-md font-medium 
                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Protected
                                    </span>
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
                            onclick="fetchRoles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            &laquo; First
                        </button>
                        <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                            onclick="fetchRoles(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                            onclick="fetchRoles(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            1
                        </button>`;
                    if (startPage > 2) {
                        paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                    }
                }
                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += `
                        <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                            onclick="fetchRoles(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            ${i}
                        </button>`;
                }
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                    }
                    paginationHtml += `
                        <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                            onclick="fetchRoles(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            ${totalPages}
                        </button>`;
                }
                if (data.current_page < data.last_page) {
                    paginationHtml += `
                        <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                            onclick="fetchRoles(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            Next
                        </button>
                        <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                            onclick="fetchRoles(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                            Last &raquo;
                        </button>`;
                }
                paginationHtml += '</div>';
                $('#paginationLinks').html(paginationHtml);
            }

            window.deleteRole = function (id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                            url: '{{ route("roles.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Role has been deleted successfully.',
                                    icon: 'success',
                                    background: '#101966',
                                    color: '#fff'
                                });
                                fetchRoles();
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong while deleting the role.',
                                    icon: 'error',
                                    background: '#101966',
                                    color: '#fff'
                                });
                            }
                        });
                    }
                });
            }

            window.showFullPermissions = function(permissions) {
                const modalContent = document.getElementById('modalPermissionsContent');
                
                let permissionsArray = [];
                
                const sections = permissions.split('<br>');
                
                sections.forEach(section => {
                    const items = section.split(',').map(item => item.trim()).filter(item => item !== '');
                    permissionsArray = permissionsArray.concat(items);
                });
                
                if (permissionsArray.length === 0) {
                    modalContent.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400 italic">No permissions attached to this role</p>';
                } else {
                    const mid = Math.ceil(permissionsArray.length / 2);
                    const leftColumn = permissionsArray.slice(0, mid);
                    const rightColumn = permissionsArray.slice(mid);
                    
                    let html = '<div class="grid grid-cols-2 gap-4">';
                    
                    // Left Column
                    html += '<ul class="space-y-2 list-none pl-0">';
                    leftColumn.forEach(item => {
                        const cleanItem = item.trim();
                        if (cleanItem) {
                            html += `
                                <li class="flex items-start gap-3 p-3 text-gray-800 hover:text-gray-100 bg-blue-50 border border-blue-200 dark:bg-gray-700 rounded-lg hover:bg-[#101966] dark:hover:bg-gray-600 transition-colors duration-200">
                                    <span class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600"></span>
                                    <span class="dark:text-gray-100 text-sm leading-relaxed">${cleanItem}</span>
                                </li>
                            `;
                        }
                    });
                    html += '</ul>';
                    
                    // Right Column
                    html += '<ul class="space-y-2 list-none pl-0">';
                    rightColumn.forEach(item => {
                        const cleanItem = item.trim();
                        if (cleanItem) {
                            html += `
                                <li class="flex items-start gap-3 p-3 text-gray-800 hover:text-gray-100 bg-blue-50 border border-blue-200 dark:bg-gray-700 rounded-lg hover:bg-[#101966] dark:hover:bg-gray-600 transition-colors duration-200">
                                    <span class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600"></span>
                                    <span class="dark:text-gray-100 text-sm leading-relaxed">${cleanItem}</span>
                                </li>
                            `;
                        }
                    });
                    html += '</ul>';
                    
                    html += '</div>';
                    modalContent.innerHTML = html;
                }
                
                document.getElementById('permissionsModal').classList.remove('hidden');
            };

            window.fetchRoles = fetchRoles;
            
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }
        });
    </script>
</x-slot>
</x-app-layout>