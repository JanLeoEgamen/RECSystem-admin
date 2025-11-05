<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Verified Payments') }}
            </h2>

            <div class="flex justify-center sm:justify-end w-full sm:w-auto">
                <a href="{{ route('cashier.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0

                    dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                    Back to Cashier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Desktop Filter Layout -->
                    <div class="hidden sm:block mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl shadow-md border-2 border-blue-100 dark:border-gray-600 p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Entries per page -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                        </svg>
                                        Entries per page
                                    </label>
                                    <select id="perPage" class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all">
                                        <option value="10">10 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="50">50 per page</option>
                                        <option value="100">100 per page</option>
                                    </select>
                                </div>

                                <!-- Sort Order -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                        </svg>
                                        Sort Order
                                    </label>
                                    <select id="sortBy" class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all">
                                        <option value="created_desc">Newest First</option>
                                        <option value="created_asc">Oldest First</option>
                                        <option value="name_asc">Name (A-Z)</option>
                                        <option value="name_desc">Name (Z-A)</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Search
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="searchInput" placeholder="Search Name" 
                                            class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all">
                                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Results Info -->
                            <div class="mt-4 pt-4 border-t border-blue-200 dark:border-gray-500">
                                <div class="flex items-center justify-between text-xs">
                                    <div id="resultInfo" class="flex items-center text-gray-600 dark:text-gray-300 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Showing <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="startRecord">0</span> to 
                                        <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="endRecord">0</span> of 
                                        <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="totalRecords">0</span> items
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Filter Layout -->
                    <div class="sm:hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl shadow-md border-2 border-blue-100 dark:border-gray-600 p-4 space-y-4">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Search
                                </label>
                                <div class="relative">
                                    <input type="text" id="mobileSearchInput" placeholder="Search Name" 
                                        class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Entries per page -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    Entries per page
                                </label>
                                <select id="mobilePerPage" class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                    <option value="10">10 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="50">50 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                            </div>

                            <!-- Sort Order -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                    </svg>
                                    Sort Order
                                </label>
                                <select id="mobileSortBy" class="w-full border-2 border-blue-200 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                    <option value="created_desc">Newest First</option>
                                    <option value="created_asc">Oldest First</option>
                                    <option value="name_asc">Name (A-Z)</option>
                                    <option value="name_desc">Name (Z-A)</option>
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
                                    <span class="mx-1 font-bold text-blue-600 dark:text-blue-400" id="mobileTotalRecords">0</span> items
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[1000px]">
                            <table id="verifiedPaymentsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-700 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-name">Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-email">Email</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-reference">Reference #</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-receipt">Receipt</th>
                                        <th class="px-6 py-3 text-center font-medium border-l dark:border-gray-700 border-white column-verified">Date Verified</th>
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

    <x-slot name="script">
        <style>
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
        <script>
            $(document).ready(function () {
                fetchVerifiedPayments();

                $('#searchInput, #mobileSearchInput').on('keyup', function () {
                    fetchVerifiedPayments(1, $(this).val());
                });

                $('#perPage, #mobilePerPage').on('change', function () {
                    fetchVerifiedPayments(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $(this).val());
                });

                $('#sortBy, #mobileSortBy').on('change', function() {
                    fetchVerifiedPayments(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val());
                });

                function fetchVerifiedPayments(page = 1, search = '', perPage = $('#perPage').val() || $('#mobilePerPage').val()) {
                    const sortValue = $('#sortBy').val() || $('#mobileSortBy').val() || 'created_desc';
                    const [column, direction] = sortValue.split('_');

                    const sortMap = {
                        'name_asc': { sort: 'first_name', direction: 'asc' },
                        'name_desc': { sort: 'first_name', direction: 'desc' },
                        'created_asc': { sort: 'created_at', direction: 'asc' },
                        'created_desc': { sort: 'created_at', direction: 'desc' }
                    };

                    const sortParams = sortMap[sortValue] || { sort: 'created_at', direction: 'desc' };

                    $.ajax({
                        url: `{{ route('cashier.verified') }}`,
                        type: 'GET',
                        data: {
                            page: page,
                            search: search,
                            perPage: perPage,
                            sort: sortParams.sort,
                            direction: sortParams.direction
                        },
                        success: function (response) {
                            renderVerifiedPayments(response.data, response.from);
                            renderPagination(response);
                            
                            $('#startRecord, #mobileStartRecord').text(response.from ?? 0);
                            $('#endRecord, #mobileEndRecord').text(response.to ?? 0);
                            $('#totalRecords, #mobileTotalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderVerifiedPayments(payments, startIndex) {
                    let tbody = $('#verifiedPaymentsTable tbody');
                    tbody.empty();
                    
                    if (payments.length === 0) {
                        tbody.append(`
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center space-y-3">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-lg font-medium text-gray-400 dark:text-gray-500">No verified payments found</div>
                                        <div class="text-sm text-gray-400 dark:text-gray-500">There are currently no verified payment records available to display</div>
                                    </div>
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    
                    payments.forEach((payment, index) => {
                        const rowNumber = startIndex + index;
                        const fullName = payment.first_name + ' ' + payment.last_name;
                        const receiptUrl = payment.payment_proof_path 
                            ? `{{ asset('images/payment_proofs/') }}/${payment.payment_proof_path}`
                            : '#';
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover table-row-animate dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-center column-name">${fullName}</td>
                                <td class="px-6 py-4 text-center column-email">${payment.email_address}</td>
                                <td class="px-6 py-4 text-center column-reference">${payment.reference_number}</td>
                                <td class="px-6 py-4 text-center column-receipt">
                                    ${payment.payment_proof_path 
                                        ? `<a href="${receiptUrl}" target="_blank" class="text-blue-600 hover:underline">View Receipt</a>` 
                                        : 'No receipt'}
                                </td>
                                <td class="px-6 py-4 text-center column-verified">${payment.verified_at}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="/cashier/${payment.id}/assess?from=verified" 
                                            class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                }

                function renderPagination(data) {
                    if (data.total === 0) {
                        $('#paginationLinks').hide();
                        return;
                    }
                    
                    $('#paginationLinks').show();
                    let paginationHtml = '<div class="flex flex-wrap justify-center items-center space-x-2">';

                    if (data.current_page > 1) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchVerifiedPayments(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchVerifiedPayments(${data.current_page - 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
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
                                onclick="fetchVerifiedPayments(1, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchVerifiedPayments(${i}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${i}
                            </button>`;
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2 dark:text-white">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white'}"
                                onclick="fetchVerifiedPayments(${totalPages}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                ${totalPages}
                            </button>`;
                    }
                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchVerifiedPayments(${data.current_page + 1}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                                onclick="fetchVerifiedPayments(${data.last_page}, $('#searchInput').val() || $('#mobileSearchInput').val(), $('#perPage').val() || $('#mobilePerPage').val())">
                                Last &raquo;
                            </button>`;
                    }
                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.fetchVerifiedPayments = fetchVerifiedPayments;
            });
        </script>
    </x-slot>
</x-app-layout>