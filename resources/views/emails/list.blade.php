<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <!-- Title -->
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Email Management') }}
            </h2>

            <!-- Button Group -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 items-center w-full sm:w-auto justify-center sm:justify-end">
                @can('send emails')
                <a href="{{ route('emails.compose') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto text-center">
                    Send Email
                </a>
                @endcan

                @can('create emails')
                <a href="{{ route('emails.create') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto mt-4 md:mt-0 text-center">
                    Create Template
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-message></x-message>

            <!-- Email Templates Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
                        <h3 class="text-xl sm:text-2xl font-semibold">Email Templates</h3>
                        
                        <!-- Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-4 sm:mt-0">
                            <!-- Entries per page -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Show</span>
                                <select id="templatesPerPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-24">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <!-- Search -->
                            <input type="text" id="templatesSearch" placeholder="Search templates..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-full sm:w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table id="emailTemplatesTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                            <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-6 py-3 text-center font-medium">#</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Name</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Subject</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Created</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Updated</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 flex justify-center" id="templatesPagination"></div>
                </div>
            </div>

            <!-- Email Logs Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
                        <h3 class="text-xl sm:text-2xl font-semibold">Email Logs</h3>
                        
                        <!-- Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-4 sm:mt-0">
                            <!-- Entries per page -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Show</span>
                                <select id="logsPerPage" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-10 text-sm focus:outline-none focus:ring focus:border-blue-300 w-24">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <!-- Search -->
                            <input type="text" id="logsSearch" placeholder="Search logs..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-full sm:w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table id="emailLogsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                            <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-6 py-3 text-center font-medium">#</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Recipient</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Template</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Subject</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Attachments</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Status</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Sent At</th>
                                    <th class="px-6 py-3 text-center font-medium border-l border-white">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 flex justify-center" id="logsPagination"></div>
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
                // Initialize templates table
                let templatesTable = {
                    currentPage: 1,
                    perPage: 10,
                    search: '',
                    sort: 'created_at',
                    direction: 'desc',
                    data: [],
                    total: 0,
                    
                    fetch: function(page = 1) {
                        this.currentPage = page;
                        $.ajax({
                            url: "{{ route('emails.index') }}",
                            type: "GET",
                            data: {
                                page: this.currentPage,
                                perPage: this.perPage,
                                search: this.search,
                                sort: this.sort,
                                direction: this.direction
                            },
                            success: (response) => {
                                this.data = response.data;
                                this.total = response.total;
                                this.render();
                                this.renderPagination();
                            }
                        });
                    },
                    
                    render: function() {
                        let tbody = $('#emailTemplatesTable tbody');
                        tbody.empty();
                        
                        this.data.forEach((template, index) => {
                            let row = `
                                <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">${(this.currentPage - 1) * this.perPage + index + 1}</td>
                                    <td class="px-6 py-4 text-left">${template.name}</td>
                                    <td class="px-6 py-4 text-left">${template.subject}</td>
                                    <td class="px-6 py-4 text-left">${template.created_at}</td>
                                    <td class="px-6 py-4 text-left">${template.updated_at}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            ${template.can_edit ? `
                                            <a href="/emails/${template.id}/edit" 
                                                class="group flex items-center bg-blue-100 hover:bg-blue-500 px-3 py-2 rounded-full transition space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-blue-600 group-hover:text-white transition"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="text-blue-600 group-hover:text-white text-sm">Edit</span>
                                            </a>
                                            ` : ''}
                                            ${template.can_delete ? `
                                            <button onclick="deleteEmailTemplate(${template.id})" 
                                                class="group flex items-center bg-red-100 hover:bg-red-600 px-3 py-2 rounded-full transition space-x-1"> 
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-red-600 group-hover:text-white transition"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span class="text-red-600 group-hover:text-white text-sm">Delete</span>
                                            </button>
                                            ` : ''}
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    },
                    
                    renderPagination: function() {
                        let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';
                        
                        if (this.currentPage > 1) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="templatesTable.fetch(1)">
                                    &laquo; First
                                </button>
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="templatesTable.fetch(${this.currentPage - 1})">
                                    Previous
                                </button>`;
                        }
                        
                        const totalPages = Math.ceil(this.total / this.perPage);
                        const currentPage = this.currentPage;
                        const pagesToShow = 3;
                        
                        let startPage = Math.max(1, currentPage - Math.floor(pagesToShow / 2));
                        let endPage = Math.min(totalPages, startPage + pagesToShow - 1);
                        
                        if (endPage - startPage + 1 < pagesToShow) {
                            startPage = Math.max(1, endPage - pagesToShow + 1);
                        }
                        
                        if (startPage > 1) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="templatesTable.fetch(1)">
                                    1
                                </button>`;
                            if (startPage > 2) {
                                paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                            }
                        }
                        
                        for (let i = startPage; i <= endPage; i++) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="templatesTable.fetch(${i})">
                                    ${i}
                                </button>`;
                        }
                        
                        if (endPage < totalPages) {
                            if (endPage < totalPages - 1) {
                                paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                            }
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="templatesTable.fetch(${totalPages})">
                                    ${totalPages}
                                </button>`;
                        }
                        
                        if (this.currentPage < totalPages) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="templatesTable.fetch(${this.currentPage + 1})">
                                    Next
                                </button>
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="templatesTable.fetch(${totalPages})">
                                    Last &raquo;
                                </button>`;
                        }
                        
                        paginationHtml += '</div>';
                        $('#templatesPagination').html(paginationHtml);
                    }
                };
                
                let logsTable = {
                    currentPage: 1,
                    perPage: 10,
                    search: '',
                    sort: 'sent_at',
                    direction: 'desc',
                    data: [],
                    total: 0,
                    
                    fetch: function(page = 1) {
                        this.currentPage = page;
                        $.ajax({
                            url: "{{ route('emails.logs') }}",
                            type: "GET",
                            data: {
                                page: this.currentPage,
                                perPage: this.perPage,
                                search: this.search,
                                sort: this.sort,
                                direction: this.direction
                            },
                            success: (response) => {
                                this.data = response.data;
                                this.total = response.total;
                                this.render();
                                this.renderPagination();
                            }
                        });
                    },
                    
                    render: function() {
                        let tbody = $('#emailLogsTable tbody');
                        tbody.empty();
                        
                        this.data.forEach((log, index) => {
                            let attachmentsHtml = '-';
                            if (log.attachments && log.attachments.length > 0) {
                                attachmentsHtml = log.attachments.map(file => 
                                    `<a href="${file.url}" target="_blank" class="underline text-blue-400 block">${file.name}</a>`
                                ).join('');
                            }
                            
                            let statusHtml = log.status === 'sent' ? 
                                '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Sent</span>' :
                                '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Failed</span>';
                            
                            let row = `
                                <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">${(this.currentPage - 1) * this.perPage + index + 1}</td>
                                    <td class="px-6 py-4 text-left">
                                        <div>${log.recipient_email}</div>
                                        <div class="text-sm text-gray-500">${log.recipient_name}</div>
                                    </td>
                                    <td class="px-6 py-4 text-left">${log.template_name || 'Custom'}</td>
                                    <td class="px-6 py-4 text-left">${log.subject}</td>
                                    <td class="px-6 py-4 text-left">${attachmentsHtml}</td>
                                    <td class="px-6 py-4 text-center">${statusHtml}</td>
                                    <td class="px-6 py-4 text-left">${log.sent_at}</td>
                                    <td class="px-6 py-4 text-center">
                                        ${log.can_delete ? `
                                        <button onclick="deleteEmailLog(${log.id})" 
                                            class="group flex items-center bg-red-100 hover:bg-red-600 px-3 py-2 rounded-full transition space-x-1"> 
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-red-600 group-hover:text-white transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span class="text-red-600 group-hover:text-white text-sm">Delete</span>
                                        </button>
                                        ` : ''}
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    },
                    
                    renderPagination: function() {
                        let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';
                        
                        if (this.currentPage > 1) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="logsTable.fetch(1)">
                                    &laquo; First
                                </button>
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="logsTable.fetch(${this.currentPage - 1})">
                                    Previous
                                </button>`;
                        }
                        
                        const totalPages = Math.ceil(this.total / this.perPage);
                        const currentPage = this.currentPage;
                        const pagesToShow = 3;
                        
                        let startPage = Math.max(1, currentPage - Math.floor(pagesToShow / 2));
                        let endPage = Math.min(totalPages, startPage + pagesToShow - 1);
                        
                        if (endPage - startPage + 1 < pagesToShow) {
                            startPage = Math.max(1, endPage - pagesToShow + 1);
                        }
                        
                        if (startPage > 1) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${1 === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="logsTable.fetch(1)">
                                    1
                                </button>`;
                            if (startPage > 2) {
                                paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                            }
                        }
                        
                        for (let i = startPage; i <= endPage; i++) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="logsTable.fetch(${i})">
                                    ${i}
                                </button>`;
                        }
                        
                        if (endPage < totalPages) {
                            if (endPage < totalPages - 1) {
                                paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                            }
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                    onclick="logsTable.fetch(${totalPages})">
                                    ${totalPages}
                                </button>`;
                        }
                        
                        if (this.currentPage < totalPages) {
                            paginationHtml += `
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="logsTable.fetch(${this.currentPage + 1})">
                                    Next
                                </button>
                                <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                    onclick="logsTable.fetch(${totalPages})">
                                    Last &raquo;
                                </button>`;
                        }
                        
                        paginationHtml += '</div>';
                        $('#logsPagination').html(paginationHtml);
                    }
                };
                
                templatesTable.fetch();
                logsTable.fetch();
                
                $('#templatesPerPage').on('change', function() {
                    templatesTable.perPage = $(this).val();
                    templatesTable.fetch(1);
                });
                
                $('#templatesSearch').on('keyup', function() {
                    templatesTable.search = $(this).val();
                    templatesTable.fetch(1);
                });
                
                $('#logsPerPage').on('change', function() {
                    logsTable.perPage = $(this).val();
                    logsTable.fetch(1);
                });
                
                $('#logsSearch').on('keyup', function() {
                    logsTable.search = $(this).val();
                    logsTable.fetch(1);
                });
                
                window.templatesTable = templatesTable;
                window.logsTable = logsTable;
            });
            
            function deleteEmailTemplate(id) {
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
                            url: '{{ route("emails.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Email template has been deleted successfully.',
                                        icon: 'success',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    window.templatesTable.fetch(window.templatesTable.currentPage);
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'An error occurred while deleting the template.',
                                        icon: 'error',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: "An error occurred while deleting the template.",
                                    icon: 'error',
                                    background: '#101966',
                                    color: '#fff'
                                });
                            }
                        });
                    }
                });
            }
            
            function deleteEmailLog(id) {
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
                            url: '{{ route("emails.logs.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Email log has been deleted successfully.',
                                        icon: 'success',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                    window.logsTable.fetch(window.logsTable.currentPage);
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'An error occurred while deleting the email log.',
                                        icon: 'error',
                                        background: '#101966',
                                        color: '#fff'
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: "An error occurred while deleting the email log.",
                                    icon: 'error',
                                    background: '#101966',
                                    color: '#fff'
                                });
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>