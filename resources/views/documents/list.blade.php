<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Documents') }}
            </h2>
            @can('create documents')
            <a href="{{ route('documents.create') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</a>
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
                                    <option value="file_info">File Info</option>
                                    <option value="is_published">Status</option>
                                    <option value="author">Author</option>
                                    <option value="created">Created</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 ml-6">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> documents
                            </div>
                            <input type="text" id="searchInput" placeholder="Search documents..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="documentsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-title">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-file_info">File Info</th>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script>
            $(document).ready(function () {
                fetchDocuments();

                $('#searchInput').on('keyup', function () {
                    fetchDocuments(1, $(this).val());
                });

                $('#perPage').on('change', function () {
                    fetchDocuments(1, $('#searchInput').val(), $(this).val());
                });

                $('#sortBy').on('change', function() {
                    fetchDocuments(1, $('#searchInput').val(), $('#perPage').val());
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

                function fetchDocuments(page = 1, search = '', perPage = $('#perPage').val()) {
                    const sortValue = $('#sortBy').val() || 'created_desc';
                    const lastUnderscore = sortValue.lastIndexOf('_');
                    const column = sortValue.substring(0, lastUnderscore);
                    const direction = sortValue.substring(lastUnderscore + 1);
                    const sortParams = `&sort=${column}&direction=${direction}`;

                    $.ajax({
                        url: `{{ route('documents.index') }}?page=${page}&search=${search}&perPage=${perPage}${sortParams}`,
                        type: 'GET',
                        success: function (response) {
                            renderDocuments(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord').text(response.from ?? 0);
                            $('#endRecord').text(response.to ?? 0);
                            $('#totalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderDocuments(documents, startIndex) {
                    let tbody = $('#documentsTable tbody');
                    tbody.empty();
                    
                    documents.forEach((document, index) => {
                        const rowNumber = startIndex + index;
                        
                        // Determine file icon based on type
                        let fileIcon = 'fa-file';
                        if (document.file_type) {
                            if (document.file_type.includes('pdf')) {
                                fileIcon = 'fa-file-pdf';
                            } else if (document.file_type.includes('word')) {
                                fileIcon = 'fa-file-word';
                            } else if (document.file_type.includes('image')) {
                                fileIcon = 'fa-file-image';
                            }
                        }
                        
                        // File info content
                        let fileInfo = '';
                        if (document.url) {
                            fileInfo = `<a href="${document.url}" target="_blank" class="text-blue-600 hover:underline">External Link</a>`;
                        } else {
                            fileInfo = `<div class="flex items-center">
                                <i class="fas ${fileIcon} mr-2"></i>
                                ${document.file_type || 'N/A'}
                            </div>`;
                        }
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-title">${document.title}</td>
                                <td class="px-6 py-4 text-left column-file_info">${fileInfo}</td>
                                <td class="px-6 py-4 text-center column-is_published">
                                    ${document.is_published 
                                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>'}
                                </td>
                                <td class="px-6 py-4 text-left column-author">${document.author}</td>
                                <td class="px-6 py-4 text-left column-created">${document.created_at}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    <a href="/documents/${document.id}/edit" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                    </a>
                                    <button onclick="deleteDocument(${document.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition" title="Delete"> 
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
                                onclick="fetchDocuments(1, $('#searchInput').val(), $('#perPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchDocuments(${data.current_page - 1}, $('#searchInput').val(), $('#perPage').val())">
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
                                onclick="fetchDocuments(1, $('#searchInput').val(), $('#perPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchDocuments(${i}, $('#searchInput').val(), $('#perPage').val())">
                                ${i}
                            </button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchDocuments(${totalPages}, $('#searchInput').val(), $('#perPage').val())">
                                ${totalPages}
                            </button>`;
                    }

                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchDocuments(${data.current_page + 1}, $('#searchInput').val(), $('#perPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchDocuments(${data.last_page}, $('#searchInput').val(), $('#perPage').val())">
                                Last &raquo;
                            </button>`;
                    }

                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteDocument = function (id) {
                    if (confirm("Are you sure you want to delete this document?")) {
                        $.ajax({
                            url: '{{ route("documents.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchDocuments();
                            }
                        });
                    }
                }

                window.fetchDocuments = fetchDocuments;
            });
        </script>
    </x-slot>
</x-app-layout>