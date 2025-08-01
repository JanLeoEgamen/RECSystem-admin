<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Users') }}
            </h2>
            @can('create users')
            <a href="{{ route('users.create') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-gray-10 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <label for="perPage" class="text-sm text-gray-700 dark:text-gray-300">Show</label>
                                <select id="perPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-24">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="text-sm text-gray-700 dark:text-gray-300">entries</span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <label for="sortBy" class="text-sm text-gray-700 dark:text-gray-300">Sort by</label>
                                <select id="sortBy" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                                    <option value="created_desc">Default</option>
                                    <option value="name_asc">Name (A-Z)</option>
                                    <option value="name_desc">Name (Z-A)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-2 ml-2">
                                <label for="columnFilter" class="text-sm text-gray-700 dark:text-gray-300">Columns</label>
                                <select id="columnFilter" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-12 text-sm focus:outline-none focus:ring focus:border-blue-300 w-[300px]">  <!-- Increased pr and custom width -->
                                    <option value="all" selected>Show All</option>
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                    <option value="roles">Roles</option>
                                    <option value="assignments">Assignments</option>
                                    <option value="created">Created</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 ml-6">  <!-- Increased ml here -->
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> users
                            </div>
                            <input type="text" id="searchInput" placeholder="Search users..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[800px]">
                            <table id="usersTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                            <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-6 py-3 text-center font-medium">#</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white column-name">Name</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white column-email">Email</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white column-roles">Roles</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white column-assignments">Assignments</th>
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

    <!-- Modal for viewing full assignments -->
    <div id="assignmentsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-300 dark:border-gray-600">
            <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Assignments</h3>
                <button onclick="document.getElementById('assignmentsModal').classList.add('hidden')" 
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalAssignmentsContent" class="p-4 max-h-[60vh] overflow-y-auto text-gray-700 dark:text-gray-300"></div>
            <div class="p-4 border-t dark:border-gray-700 text-right">
                <button onclick="document.getElementById('assignmentsModal').classList.add('hidden')" 
                    class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                fetchUsers();

                $('#searchInput').on('keyup', function () {
                    fetchUsers(1, $(this).val());
                });

                $('#perPage').on('change', function () {
                    fetchUsers(1, $('#searchInput').val(), $(this).val());
                });

                $('#sortBy').on('change', function() {
                    fetchUsers(1, $('#searchInput').val(), $('#perPage').val());
                });

                $('#columnFilter').on('change', function() {
                    updateVisibleColumns();
                });

                function updateVisibleColumns() {
                    const selectedColumn = $('#columnFilter').val();
                    
                    if (selectedColumn === 'all') {
                        $('th[class*="column-"], td[class*="column-"]').show();
                    } else {
                        $('th[class*="column-"], td[class*="column-"]').each(function() {
                            const columnClass = Array.from(this.classList).find(c => c.startsWith('column-'));
                            if (columnClass) {
                                const columnName = columnClass.replace('column-', '');
                                if (columnName === selectedColumn) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            }
                        });
                    }
                }

                function fetchUsers(page = 1, search = '', perPage = $('#perPage').val()) {
                    const sortValue = $('#sortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');
                    const sortParams = `&sort=${column}&direction=${direction}`;
                    
                    $.ajax({
                        url: `{{ route('users.index') }}?page=${page}&search=${search}&perPage=${perPage}${sortParams}`,
                        type: 'GET',
                        success: function (response) {
                            renderUsers(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord').text(response.from ?? 0);
                            $('#endRecord').text(response.to ?? 0);
                            $('#totalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderUsers(users, startIndex) {
                    let tbody = $('#usersTable tbody');
                    tbody.empty();
                    
                    users.forEach((user, index) => {
                        const rowNumber = startIndex + index;
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-name">${user.name}</td>
                                <td class="px-6 py-4 text-left column-email">${user.email}</td>
                                <td class="px-6 py-4 text-left column-roles">${user.roles}</td>
                                <td class="px-6 py-4 text-left column-assignments">
                                    ${user.assignments.length > 50 ? 
                                        user.assignments.substring(0, 50) + '... <button onclick="showFullAssignments(\'' + escapeHtml(user.assignments) + '\')" class="text-blue-500 hover:text-blue-700 text-xs">View All</button>' : 
                                        user.assignments}
                                </td>
                                <td class="px-6 py-4 text-left column-created">${user.created}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    <a href="/users/${user.id}/edit" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                    </a>
                                    <button onclick="deleteUser(${user.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                    
                    updateVisibleColumns();
                }

                function renderPagination(data) {
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';

                    // First and Previous buttons
                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchUsers(1, $('#searchInput').val(), $('#perPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchUsers(${data.current_page - 1}, $('#searchInput').val(), $('#perPage').val())">
                                Previous
                            </button>`;
                    }

                    // Page numbers - always show current page and adjacent pages
                    const totalPages = data.last_page;
                    const currentPage = data.current_page;
                    const pagesToShow = 3; // Show 3 pages around current

                    let startPage = Math.max(1, currentPage - Math.floor(pagesToShow / 2));
                    let endPage = Math.min(totalPages, startPage + pagesToShow - 1);

                    // Adjust if we're at the beginning or end
                    if (endPage - startPage + 1 < pagesToShow) {
                        startPage = Math.max(1, endPage - pagesToShow + 1);
                    }

                    // Always show page 1 if not already shown
                    if (startPage > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchUsers(1, $('#searchInput').val(), $('#perPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                    }

                    // Show page numbers
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchUsers(${i}, $('#searchInput').val(), $('#perPage').val())">
                                ${i}
                            </button>`;
                    }

                    // Always show last page if not already shown
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchUsers(${totalPages}, $('#searchInput').val(), $('#perPage').val())">
                                ${totalPages}
                            </button>`;
                    }

                    // Next and Last buttons
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchUsers(${data.current_page + 1}, $('#searchInput').val(), $('#perPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchUsers(${data.last_page}, $('#searchInput').val(), $('#perPage').val())">
                                Last &raquo;
                            </button>`;
                    }

                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteUser = function (id) {
                    if (confirm("Are you sure you want to delete?")) {
                        $.ajax({
                            url: '{{ route("users.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchUsers();
                            }
                        });
                    }
                }

                window.showFullAssignments = function(assignments) {
                    const modalContent = document.getElementById('modalAssignmentsContent');
                    const assignmentsArray = assignments.split('<br>').filter(a => a.trim() !== '');
                    
                    let html = '<div class="space-y-2">';
                    assignmentsArray.forEach(item => {
                        html += `
                            <div class="p-2 bg-gray-50 dark:bg-gray-700 rounded text-sm">
                                ${item}
                            </div>
                        `;
                    });
                    html += '</div>';
                    
                    modalContent.innerHTML = html;
                    document.getElementById('assignmentsModal').classList.remove('hidden');
                };

                window.fetchUsers = fetchUsers;
                
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