<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Certificates Templates') }}">
            <x-slot name="createButton">
                <x-create-button 
                    :route="route('certificates.create')" 
                    permission="create certificates " />
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
                                    <option value="created_asc">Created (Oldest First)</option>
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
                                <option value="created_asc">Created (Oldest First)</option>
                            </select>
                        </div>

                        <div id="mobileResultInfo" class="text-sm text-gray-700 dark:text-gray-300 text-center">
                            Showing <span id="mobileStartRecord">0</span> to <span id="mobileEndRecord">0</span> of <span id="mobileTotalRecords">0</span> items
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="certificatesTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-title">Title</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-content">Content</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-signatories">Signatories</th>
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

    <!-- Dropdown Portal Container -->
    <div id="dropdown-portal" style="position: fixed; top: 0; left: 0; z-index: 10000; pointer-events: none;"></div>

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

            /* Dropdown menu styles */
            .dropdown-menu {
                position: absolute !important;
                z-index: 9999 !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .dropdown-container {
                position: relative;
                z-index: 50;
            }

            .dropdown-container.active {
                z-index: 9999 !important;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                fetchCertificates();
                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchCertificates(1, $(this).val());
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchCertificates(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchCertificates(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function fetchCertificates(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'title_asc': { sort: 'title', direction: 'asc' },
                        'title_desc': { sort: 'title', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('certificates.index') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderCertificates(response.data, response.from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderCertificates(certificates, startIndex) {
                    let tbody = $('#certificatesTable tbody');
                    tbody.empty();
                    
                    certificates.forEach((certificate, index) => {
                        const rowNumber = startIndex + index;

                        let row = `
                        <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                            <td class="px-6 py-4 text-center">${rowNumber}</td>
                            <td class="px-6 py-4 text-left column-title">${certificate.title}</td>
                            <td class="px-6 py-4 text-left column-content">${certificate.content}</td>
                            <td class="px-6 py-4 text-center column-signatories">${certificate.signatories}</td>
                            <td class="px-6 py-4 text-center column-author">${certificate.author}</td>
                            <td class="px-6 py-4 text-center column-created">${certificate.created_at}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="/certificates/${certificate.id}/preview" 
                                        class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="text-blue-600 group-hover:text-white text-sm">Preview</span>
                                    </a>

                                    <button onclick="downloadCertificateAsImage(${certificate.id})" 
                                        class="group flex items-center bg-green-100 hover:bg-green-500 px-3 py-2 rounded-full transition space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-green-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-green-600 group-hover:text-white text-sm">Download</span>
                                    </button>
                                    
                                    <a href="/certificates/${certificate.id}/edit" 
                                        class="group flex items-center bg-indigo-100 hover:bg-indigo-500 px-3 py-2 rounded-full transition space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-indigo-600 group-hover:text-white transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3z" />
                                        </svg>
                                        <span class="text-indigo-600 group-hover:text-white text-sm">Edit</span>
                                    </a>
                                    
                                    <button onclick="deleteCertificate(${certificate.id})" 
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
                                onclick="fetchCertificates(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchCertificates(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchCertificates(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchCertificates(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchCertificates(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchCertificates(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchCertificates(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteCertificate = function (id) {
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
                                url: '{{ route("certificates.destroy") }}',
                                type: 'DELETE',
                                data: { id: id },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Certificate template has been deleted successfully.',
                                        icon: 'success',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    fetchCertificates();
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Something went wrong while deleting the certificate template.',
                                        icon: 'error',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            });
                        }
                    });
                }

                window.fetchCertificates = fetchCertificates;

                // Handle download dropdown menu
                window.toggleDownloadMenu = function(id) {
                    const button = document.querySelector(`#dropdown-container-${id} button`);
                    const portal = document.getElementById('dropdown-portal');
                    const existingMenu = document.getElementById(`download-menu-${id}`);
                    
                    // Close any existing dropdown
                    portal.innerHTML = '';
                    
                    if (existingMenu) {
                        // Dropdown is already open, close it
                        return;
                    }
                    
                    // Create dropdown menu
                    const dropdown = document.createElement('div');
                    dropdown.id = `download-menu-${id}`;
                    dropdown.className = 'bg-white rounded-md shadow-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-600';
                    
                    const updatePosition = () => {
                        const rect = button.getBoundingClientRect();
                        const isMobile = window.innerWidth <= 768;
                        const viewportHeight = window.innerHeight;
                        const viewportWidth = window.innerWidth;
                        
                        // Check if button is visible in viewport
                        if (rect.bottom < 0 || rect.top > viewportHeight || rect.right < 0 || rect.left > viewportWidth) {
                            dropdown.style.display = 'none';
                            return;
                        } else {
                            dropdown.style.display = 'block';
                        }
                        
                        // Mobile-responsive positioning
                        if (isMobile) {
                            dropdown.className = dropdown.className.replace(/w-\d+/, 'w-48');
                            const dropdownWidth = 192; // w-48 = 12rem = 192px
                            
                            // Get table container bounds for mobile
                            const tableContainer = document.querySelector('.overflow-x-auto');
                            const containerRect = tableContainer ? tableContainer.getBoundingClientRect() : null;
                            
                            let left, right;
                            
                            if (containerRect) {
                                // Position dropdown within table container bounds
                                const containerLeft = containerRect.left + 8; // 8px padding from container edge
                                const containerRight = containerRect.right - 8;
                                const containerWidth = containerRight - containerLeft;
                                
                                // Try to center dropdown under button first
                                let preferredLeft = rect.left - (dropdownWidth / 2) + (rect.width / 2);
                                
                                // Constrain to container bounds
                                if (preferredLeft < containerLeft) {
                                    left = containerLeft;
                                } else if (preferredLeft + dropdownWidth > containerRight) {
                                    left = containerRight - dropdownWidth;
                                } else {
                                    left = preferredLeft;
                                }
                                
                                // Ensure minimum width if container is too narrow
                                if (containerWidth < dropdownWidth) {
                                    left = containerLeft;
                                    dropdown.style.maxWidth = `${containerWidth}px`;
                                } else {
                                    dropdown.style.maxWidth = '';
                                }
                            } else {
                                // Fallback to viewport bounds if container not found
                                let left = rect.left - (dropdownWidth / 2) + (rect.width / 2);
                                left = Math.max(16, Math.min(left, viewportWidth - dropdownWidth - 16));
                            }
                            
                            let top = rect.bottom + 8;
                            // If dropdown would go below viewport, show it above the button
                            if (top + 120 > viewportHeight) { // Approximate dropdown height
                                top = rect.top - 120 - 8;
                            }
                            
                            dropdown.style.cssText = `
                                position: fixed;
                                top: ${top}px;
                                left: ${left}px;
                                z-index: 10000;
                                pointer-events: auto;
                                display: block;
                                ${dropdown.style.maxWidth ? `max-width: ${dropdown.style.maxWidth};` : 'max-width: calc(100vw - 32px);'}
                            `;
                        } else {
                            dropdown.className = dropdown.className.replace(/w-\d+/, 'w-56');
                            const dropdownWidth = 224; // w-56 = 14rem = 224px
                            let left = rect.right - dropdownWidth;
                            
                            // Ensure dropdown doesn't go off screen
                            if (left < 16) {
                                left = rect.left;
                            }
                            if (left + dropdownWidth > viewportWidth - 16) {
                                left = viewportWidth - dropdownWidth - 16;
                            }
                            
                            let top = rect.bottom + 8;
                            // If dropdown would go below viewport, show it above the button
                            if (top + 120 > viewportHeight) { // Approximate dropdown height
                                top = rect.top - 120 - 8;
                            }
                            
                            dropdown.style.cssText = `
                                position: fixed;
                                top: ${top}px;
                                left: ${left}px;
                                z-index: 10000;
                                pointer-events: auto;
                                display: block;
                            `;
                        }
                    };
                    
                    dropdown.innerHTML = `
                        <div class="px-3 py-2 text-xs text-gray-500 dark:text-gray-400 border-b dark:border-gray-600">Choose download format:</div>
                        <a href="/certificates/${id}/download-image/0" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" title="Full design with all images and styling">
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <span class="font-medium">Download PNG</span>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Perfect styling preserved</div>
                                </div>
                            </div>
                        </a>
                        <a href="/certificates/${id}/download-image/0/jpeg" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" title="Full design, smaller file size">
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <span class="font-medium">Download JPEG</span>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Smaller file size</div>
                                </div>
                            </div>
                        </a>
                    `;
                    
                    portal.appendChild(dropdown);
                    
                    // Initial positioning
                    updatePosition();
                    
                    // Store update function and add scroll listeners
                    dropdown.updatePosition = updatePosition;
                    
                    // Add scroll listeners to update position
                    const scrollContainer = document.querySelector('.overflow-x-auto');
                    const addScrollListeners = () => {
                        window.addEventListener('scroll', updatePosition, { passive: true });
                        window.addEventListener('resize', updatePosition, { passive: true });
                        if (scrollContainer) {
                            scrollContainer.addEventListener('scroll', updatePosition, { passive: true });
                        }
                    };
                    
                    const removeScrollListeners = () => {
                        window.removeEventListener('scroll', updatePosition);
                        window.removeEventListener('resize', updatePosition);
                        if (scrollContainer) {
                            scrollContainer.removeEventListener('scroll', updatePosition);
                        }
                    };
                    
                    // Store cleanup function
                    dropdown.cleanup = removeScrollListeners;
                    
                    addScrollListeners();
                };

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const portal = document.getElementById('dropdown-portal');
                    if (!event.target.closest('[onclick^="toggleDownloadMenu"]') && !event.target.closest('#dropdown-portal')) {
                        // Clean up any scroll listeners before clearing portal
                        const dropdowns = portal.querySelectorAll('[id^="download-menu-"]');
                        dropdowns.forEach(dropdown => {
                            if (dropdown.cleanup) {
                                dropdown.cleanup();
                            }
                        });
                        portal.innerHTML = '';
                    }
                });
            });
        </script>
        <script>
        // Include html2canvas library
        const html2canvasScript = document.createElement('script');
        html2canvasScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
        document.head.appendChild(html2canvasScript);

        window.downloadCertificateAsImage = function(certificateId) {
        // Show loading overlay
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingDiv.innerHTML = `
            <div class="bg-white rounded-lg p-6 text-center dark:bg-gray-800 dark:text-white">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"></div>
                <p class="text-lg font-medium">Generating certificate image...</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Please wait</p>
            </div>
        `;
        document.body.appendChild(loadingDiv);

        // Use AJAX to get the certificate HTML
        $.ajax({
            url: `/certificates/${certificateId}/preview-content`,
            type: 'GET',
            success: function(html) {
                // Create a temporary container for the certificate
                const tempContainer = document.createElement('div');
                tempContainer.style.position = 'fixed';
                tempContainer.style.left = '-9999px';
                tempContainer.style.top = '-9999px';
                tempContainer.style.width = '297mm';
                tempContainer.style.height = '210mm';
                tempContainer.innerHTML = html;
                document.body.appendChild(tempContainer);

                // Wait a moment for images to load
                setTimeout(() => {
                    const certificateElement = tempContainer.querySelector('.certificate') || tempContainer;
                    
                    html2canvas(certificateElement, {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: '#ffffff',
                        logging: false
                    }).then(canvas => {
                        // Convert canvas to PNG and download
                        const image = canvas.toDataURL('image/png');
                        const downloadLink = document.createElement('a');
                        const fileName = `certificate_${certificateId}.png`;
                        
                        downloadLink.href = image;
                        downloadLink.download = fileName;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                        // Clean up
                        document.body.removeChild(tempContainer);
                        document.body.removeChild(loadingDiv);
                        
                        // Show success message
                        Swal.fire({
                            title: 'Download Complete!',
                            text: 'Certificate has been downloaded as PNG',
                            icon: 'success',
                            background: '#101966',
                            color: '#fff',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                    }).catch(error => {
                        console.error('Error generating image:', error);
                        document.body.removeChild(tempContainer);
                        document.body.removeChild(loadingDiv);
                        showDownloadError(certificateId);
                    });
                }, 500);
            },
            error: function() {
                document.body.removeChild(loadingDiv);
                showDownloadError(certificateId);
            }
        });
    };

        // Show download error and fallback
        function showDownloadError(certificateId) {
            Swal.fire({
                title: 'Download Method',
                html: `
                    <p>Choose how you'd like to download the certificate:</p>
                    <div class="mt-4 space-y-2">
                        <button onclick="openPreviewForDownload(${certificateId})" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition">
                            📄 Open Preview Page
                        </button>
                        <p class="text-sm text-gray-600">Manually save using browser tools</p>
                    </div>
                `,
                icon: 'info',
                background: '#101966',
                color: '#fff',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                showConfirmButton: false
            });
        }

        // Open preview page for manual download
        function openPreviewForDownload(certificateId) {
            window.open(`/certificates/${certificateId}/preview`, '_blank');
            Swal.close();
        }

        // Add CSS for loading animation
        const loadingStyles = document.createElement('style');
        loadingStyles.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                color: white;
            }
        `;
        document.head.appendChild(loadingStyles);

    </script>
    </x-slot>
</x-app-layout>