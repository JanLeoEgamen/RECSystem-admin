<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                p-4 sm:p-6 rounded-lg shadow-lg
                bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

        <!-- Header Title -->
        <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
            {{ __('Announcements') }}
        </h2>

        <!-- Create Button -->
        @can('create announcements')
        <a href="{{ route('announcements.create') }}" 
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
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                    <option value="is_published_desc">Status (Published First)</option>
                                    <option value="is_published_asc">Status (Draft First)</option>
                                    <option value="created_asc">Created (Oldest First)</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-2 ml-2">
                                <label for="columnFilter" class="text-sm text-gray-700 dark:text-gray-300">Columns</label>
                                <select id="columnFilter" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-12 text-sm focus:outline-none focus:ring focus:border-blue-300 w-[150px]">
                                    <option value="all" selected>Show All</option>
                                    <option value="title">Title</option>
                                    <option value="is_published">Status</option>
                                    <option value="author">Author</option>
                                    <option value="created">Created</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 ml-6">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> announcements
                            </div>
                            <input type="text" id="searchInput" placeholder="Search announcements..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="announcementsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-title">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-is_published">Status</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-author">Author</th>
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
                fetchAnnouncements();

                $('#searchInput').on('keyup', function () {
                    fetchAnnouncements(1, $(this).val());
                });

                $('#perPage').on('change', function () {
                    fetchAnnouncements(1, $('#searchInput').val(), $(this).val());
                });

                $('#sortBy').on('change', function() {
                    fetchAnnouncements(1, $('#searchInput').val(), $('#perPage').val());
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

                function fetchAnnouncements(page = 1, search = '', perPage = $('#perPage').val()) {
                    const sortValue = $('#sortBy').val() || 'created_desc';
                    const lastUnderscore = sortValue.lastIndexOf('_');
                    const column = sortValue.substring(0, lastUnderscore);
                    const direction = sortValue.substring(lastUnderscore + 1);
                    const sortParams = `&sort=${column}&direction=${direction}`;

                    $.ajax({
                        url: `{{ route('announcements.index') }}?page=${page}&search=${search}&perPage=${perPage}${sortParams}`,
                        type: 'GET',
                        success: function (response) {
                            renderAnnouncements(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord').text(response.from ?? 0);
                            $('#endRecord').text(response.to ?? 0);
                            $('#totalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderAnnouncements(announcements, startIndex) {
                    let tbody = $('#announcementsTable tbody');
                    tbody.empty();
                    
                    announcements.forEach((announcement, index) => {
                        const rowNumber = startIndex + index;
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-title">${announcement.title}</td>
                                <td class="px-6 py-4 text-center column-is_published">
                                    ${announcement.is_published 
                                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>'}
                                </td>
                                <td class="px-6 py-4 text-left column-author">${announcement.author}</td>
                                <td class="px-6 py-4 text-left column-created">${announcement.created_at}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    <a href="/announcements/${announcement.id}/edit" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                    </a>
                                    <button onclick="deleteAnnouncement(${announcement.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition" title="Delete"> 
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

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchAnnouncements(1, $('#searchInput').val(), $('#perPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchAnnouncements(${data.current_page - 1}, $('#searchInput').val(), $('#perPage').val())">
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
                            <button class="px-3 py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchAnnouncements(1, $('#searchInput').val(), $('#perPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchAnnouncements(${i}, $('#searchInput').val(), $('#perPage').val())">
                                ${i}
                            </button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchAnnouncements(${totalPages}, $('#searchInput').val(), $('#perPage').val())">
                                ${totalPages}
                            </button>`;
                    }

                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchAnnouncements(${data.current_page + 1}, $('#searchInput').val(), $('#perPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchAnnouncements(${data.last_page}, $('#searchInput').val(), $('#perPage').val())">
                                Last &raquo;
                            </button>`;
                    }

                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteAnnouncement = function (id) {
                    if (confirm("Are you sure you want to delete?")) {
                        $.ajax({
                            url: '{{ route("announcements.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchAnnouncements();
                            }
                        });
                    }
                }

                window.fetchAnnouncements = fetchAnnouncements;
            });
        </script>
    </x-slot>
</x-app-layout>