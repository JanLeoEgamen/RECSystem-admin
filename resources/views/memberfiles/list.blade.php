<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Member Files
            </h2>
            @can('create member files')
            <a href="{{ route('memberfiles.create') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Assign New File
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium mb-1">Search</label>
                                <input type="text" id="search" placeholder="Search files..." class="w-full rounded-lg border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="member-filter" class="block text-sm font-medium mb-1">Filter by Member</label>
                                <select id="member-filter" class="w-full rounded-lg border-gray-300 shadow-sm">
                                    <option value="">All Members</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status-filter" class="block text-sm font-medium mb-1">Filter by Status</label>
                                <select id="status-filter" class="w-full rounded-lg border-gray-300 shadow-sm">
                                    <option value="">All Status</option>
                                    <option value="uploaded">Uploaded</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer sortable" data-sort="title">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer sortable" data-sort="member">
                                        Member
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer sortable" data-sort="due_date">
                                        Due Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer sortable" data-sort="status">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Uploaded File
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer sortable" data-sort="created_at">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="files-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <div id="pagination" class="mt-4">
                        <!-- Pagination will be loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentPage = 1;
                let currentSort = 'created_at';
                let currentDirection = 'desc';
                let searchTerm = '';
                let memberFilter = '';
                let statusFilter = '';

                // Load files data
                function loadFiles(page = 1) {
                    const params = new URLSearchParams({
                        page: page,
                        sort: currentSort,
                        direction: currentDirection,
                        search: searchTerm,
                        member_id: memberFilter,
                        status: statusFilter
                    });

                    fetch(`{{ route('memberfiles.index') }}?${params}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                        updatePagination(data);
                        currentPage = page;
                    })
                    .catch(error => {
                        console.error('Error loading files:', error);
                    });
                }

                // Update table with data
// Update table with data
function updateTable(data) {
    const tbody = document.getElementById('files-table-body');
    tbody.innerHTML = '';

    if (data.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    No files found.
                </td>
            </tr>
        `;
        return;
    }

    // Get base URL from PHP
    const baseUrl = '{{ url("/memberfiles") }}';
    
    data.data.forEach(file => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                ${file.title}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                ${file.member}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                ${file.due_date}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${file.status === 'Uploaded' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                    ${file.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                ${file.uploaded_file ? file.uploaded_file + ' (' + file.uploaded_at + ')' : 'Not uploaded yet'}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                ${file.created_at}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <a href="${baseUrl}/${file.id}/view" 
                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                    View
                </a>
                ${'@can(\'edit member files\')' ? `
                <a href="${baseUrl}/${file.id}/edit" 
                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                    Edit
                </a>
                ` : ''}
                ${'@can(\'delete member files\')' ? `
                <button onclick="deleteFile(${file.id})" 
                   class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                    Delete
                </button>
                ` : ''}
            </td>
        `;
        tbody.appendChild(row);
    });
}

                // Update pagination
                function updatePagination(data) {
                    const paginationDiv = document.getElementById('pagination');
                    paginationDiv.innerHTML = '';

                    if (data.total <= data.per_page) return;

                    let html = '<div class="flex items-center justify-between">';
                    
                    // Previous button
                    html += `<div>
                        <button onclick="loadFiles(${currentPage - 1})" 
                            ${currentPage === 1 ? 'disabled' : ''}
                            class="px-3 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300 dark:hover:bg-gray-600'}">
                            Previous
                        </button>
                    </div>`;

                    // Page info
                    html += `<div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing ${data.from} to ${data.to} of ${data.total} results
                    </div>`;

                    // Next button
                    html += `<div>
                        <button onclick="loadFiles(${currentPage + 1})" 
                            ${currentPage === data.last_page ? 'disabled' : ''}
                            class="px-3 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 ${currentPage === data.last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300 dark:hover:bg-gray-600'}">
                            Next
                        </button>
                    </div>`;

                    html += '</div>';
                    paginationDiv.innerHTML = html;
                }

                // Delete file function
                window.deleteFile = function(id) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will delete the file assignment and all associated uploads.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("memberfiles.destroy") }}', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ id: id })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Deleted!",
                                        text: data.message,
                                        confirmButtonColor: "#5e6ffb",
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    loadFiles(currentPage);
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error!",
                                        text: data.message,
                                        confirmButtonColor: "#5e6ffb",
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Failed to delete file assignment.",
                                    confirmButtonColor: "#5e6ffb",
                                    background: '#101966',
                                    color: '#fff'
                                });
                            });
                        }
                    });
                };

                // Event listeners
                document.getElementById('search').addEventListener('input', function(e) {
                    searchTerm = e.target.value;
                    loadFiles(1);
                });

                document.getElementById('member-filter').addEventListener('change', function(e) {
                    memberFilter = e.target.value;
                    loadFiles(1);
                });

                document.getElementById('status-filter').addEventListener('change', function(e) {
                    statusFilter = e.target.value;
                    loadFiles(1);
                });

                document.querySelectorAll('.sortable').forEach(header => {
                    header.addEventListener('click', function() {
                        const sort = this.dataset.sort;
                        if (currentSort === sort) {
                            currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                        } else {
                            currentSort = sort;
                            currentDirection = 'desc';
                        }
                        loadFiles(1);
                    });
                });

                // Initial load
                loadFiles(1);
            });
        </script>
    </x-slot>
</x-app-layout>