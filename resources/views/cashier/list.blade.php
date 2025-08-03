<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Payment Verification
            </h2>

            <div class="flex items-center flex-wrap gap-4">
                @can('view applicants')
                    <a href="{{ route('cashier.rejected') }}" 
                    class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">
                        Rejected Payments
                    </a>

                    <a href="{{ route('cashier.verified') }}" 
                    class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">
                        Verified Payments
                    </a>
                @endcan
            </div>
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
                                    <option value="created_desc">Newest First</option>
                                    <option value="created_asc">Oldest First</option>
                                    <option value="name_asc">Name (A-Z)</option>
                                    <option value="name_desc">Name (Z-A)</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-2 ml-2">
                                <label for="columnFilter" class="text-sm text-gray-700 dark:text-gray-300">Columns</label>
                                <select id="columnFilter" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-12 text-sm focus:outline-none focus:ring focus:border-blue-300 w-[180px]">
                                    <option value="all" selected>Show All</option>
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                    <option value="reference">Reference #</option>
                                    <option value="receipt">Receipt</option>
                                    <option value="status">Payment Status</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 ml-6">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> payments
                            </div>
                            <input type="text" id="searchInput" placeholder="Search payments..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[600px]">
                            <table id="applicantsTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-name">Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-email">Email</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-reference">Reference #</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-receipt">Receipt</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-status">Payment Status</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                fetchPayments();

                $('#searchInput').on('keyup', function () {
                    fetchPayments(1, $(this).val());
                });

                $('#perPage').on('change', function () {
                    fetchPayments(1, $('#searchInput').val(), $(this).val());
                });

                $('#sortBy').on('change', function() {
                    fetchPayments(1, $('#searchInput').val(), $('#perPage').val());
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

                function fetchPayments(page = 1, search = '', perPage = $('#perPage').val()) {
                    const sortValue = $('#sortBy').val() || 'created_desc';
                    const lastUnderscore = sortValue.lastIndexOf('_');
                    const column = sortValue.substring(0, lastUnderscore);
                    const direction = sortValue.substring(lastUnderscore + 1);
                    const sortParams = `&sort=${column}&direction=${direction}`;
                    
                    $.ajax({
                        url: `{{ route('cashier.index') }}?page=${page}&search=${search}&perPage=${perPage}${sortParams}`,
                        type: 'GET',
                        success: function (response) {
                            renderPayments(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord').text(response.from ?? 0);
                            $('#endRecord').text(response.to ?? 0);
                            $('#totalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderPayments(payments, startIndex) {
                    let tbody = $('#applicantsTable tbody');
                    tbody.empty();
                    
                    payments.forEach((payment, index) => {
                        const rowNumber = startIndex + index;
                        const fullName = payment.first_name + ' ' + payment.last_name;
                        const receiptUrl = payment.payment_proof_path 
                            ? `{{ asset('images/payment_proofs/') }}/${payment.payment_proof_path}`
                            : '#';
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-name">${fullName}</td>
                                <td class="px-6 py-4 text-left column-email">${payment.email_address}</td>
                                <td class="px-6 py-4 text-left column-reference">${payment.reference_number}</td>
                                <td class="px-6 py-4 text-left column-receipt">
                                    ${payment.payment_proof_path 
                                        ? `<a href="${receiptUrl}" target="_blank" class="text-blue-600 hover:underline">View Receipt</a>` 
                                        : 'No receipt'}
                                </td>
                                <td class="px-6 py-4 text-left column-status">
                                    <span class="px-2 py-1 rounded-full text-xs ${payment.payment_status === 'verified' 
                                        ? 'bg-green-100 text-green-800' 
                                        : payment.payment_status === 'rejected' 
                                            ? 'bg-red-100 text-red-800' 
                                            : 'bg-yellow-100 text-yellow-800'}">
                                        ${payment.payment_status}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="/cashier/${payment.id}/assess" 
                                            class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
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
                                onclick="fetchPayments(1, $('#searchInput').val(), $('#perPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchPayments(${data.current_page - 1}, $('#searchInput').val(), $('#perPage').val())">
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
                                onclick="fetchPayments(1, $('#searchInput').val(), $('#perPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchPayments(${i}, $('#searchInput').val(), $('#perPage').val())">
                                ${i}
                            </button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchPayments(${totalPages}, $('#searchInput').val(), $('#perPage').val())">
                                ${totalPages}
                            </button>`;
                    }

                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchPayments(${data.current_page + 1}, $('#searchInput').val(), $('#perPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchPayments(${data.last_page}, $('#searchInput').val(), $('#perPage').val())">
                                Last &raquo;
                            </button>`;
                    }

                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.verifyApplicant = function (id) {
                    if (confirm("Confirm payment verification?")) {
                        $.post('/cashier/' + id + '/verify', {
                            _token: '{{ csrf_token() }}'
                        }, function (res) {
                            fetchPayments();
                            alert(res.message);
                        }); 
                    }
                }

                window.fetchPayments = fetchPayments;
            });
        </script>
    </x-slot>
</x-app-layout>