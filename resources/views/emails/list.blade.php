<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <!-- Header Title -->
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
                {{ __('Email Management') }}
            </h2>

            <!-- Button Group -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-6">
                @can('send emails')
                <a href="{{ route('emails.compose') }}" 
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
                          text-center transition">
                    Send Email
                </a>
                @endcan

                @can('create emails')
                <a href="{{ route('emails.create') }}" 
                   class="inline-block px-5 py-2 
                          text-white dark:text-gray-900
                          hover:text-green-600 dark:hover:text-white
                          bg-green-600/80 dark:bg-green-400/30
                          hover:bg-white dark:hover:bg-green-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-green-500 dark:focus:ring-green-400
                          border border-white dark:border-gray-500 
                          font-medium rounded-lg 
                          text-base sm:text-xl leading-normal 
                          text-center transition">
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
                                <tr class="border-b table-row-hover dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">${(this.currentPage - 1) * this.perPage + index + 1}</td>
                                    <td class="px-6 py-4 text-left">${template.name}</td>
                                    <td class="px-6 py-4 text-left">${template.subject}</td>
                                    <td class="px-6 py-4 text-left">${template.created_at}</td>
                                    <td class="px-6 py-4 text-left">${template.updated_at}</td>
                                    <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                        ${template.can_edit ? `
                                        <a href="/emails/${template.id}/edit" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        ` : ''}
                                        ${template.can_delete ? `
                                        <button onclick="deleteEmailTemplate(${template.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition"> 
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
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
                
                // Initialize logs table
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
                                <tr class="border-b table-row-hover dark:border-gray-700">
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
                                        <button onclick="deleteEmailLog(${log.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition"> 
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
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
                
                // Initialize both tables
                templatesTable.fetch();
                logsTable.fetch();
                
                // Event listeners for templates table
                $('#templatesPerPage').on('change', function() {
                    templatesTable.perPage = $(this).val();
                    templatesTable.fetch(1);
                });
                
                $('#templatesSearch').on('keyup', function() {
                    templatesTable.search = $(this).val();
                    templatesTable.fetch(1);
                });
                
                // Event listeners for logs table
                $('#logsPerPage').on('change', function() {
                    logsTable.perPage = $(this).val();
                    logsTable.fetch(1);
                });
                
                $('#logsSearch').on('keyup', function() {
                    logsTable.search = $(this).val();
                    logsTable.fetch(1);
                });
                
                // Make tables available globally
                window.templatesTable = templatesTable;
                window.logsTable = logsTable;
            });
            
            function deleteEmailTemplate(id) {
                if (confirm("Are you sure you want to delete this template?")) {
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
                                window.templatesTable.fetch(window.templatesTable.currentPage);
                            }
                            alert(response.message);
                        },
                        error: function (xhr) {
                            alert("An error occurred while deleting the template.");
                        }
                    });
                }
            }
            
            function deleteEmailLog(id) {
                if (confirm("Are you sure you want to delete this log?")) {
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
                                window.logsTable.fetch(window.logsTable.currentPage);
                            }
                            alert(response.message);
                        },
                        error: function (xhr) {
                            alert("An error occurred while deleting the email log.");
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>