<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Members') }}
            </h2>

            <div class="flex items-center flex-wrap gap-4">
                @can('create members')
                <a href="{{ route('members.showMemberCreateForm') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</a>
                @endcan

                <a href="{{ route('members.active') }}" dusk="go-to-active" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Active Members</a>

                <a href="{{ route('members.inactive') }}" dusk="go-to-inactive" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Inactive Members</a>
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
                                    <option value="created_desc">Default</option>
                                    <option value="last_name_asc">Last Name (A-Z)</option>
                                    <option value="last_name_desc">Last Name (Z-A)</option>
                                    <option value="rec_number_asc">Record No. (Asc)</option>
                                    <option value="rec_number_desc">Record No. (Desc)</option>
                                    <option value="membership_start_asc">Start Date (Oldest)</option>
                                    <option value="membership_start_desc">Start Date (Newest)</option>
                                    <option value="membership_end_asc">End Date (Soonest)</option>
                                    <option value="membership_end_desc">End Date (Latest)</option>
                                    <option value="status_asc">Status (Active First)</option>
                                    <option value="status_desc">Status (Inactive First)</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-2 ml-2">
                                <label for="columnFilter" class="text-sm text-gray-700 dark:text-gray-300">Columns</label>
                                <select id="columnFilter" class="form-select border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-4 py-1 pr-12 text-sm focus:outline-none focus:ring focus:border-blue-300 w-[180px]">
                                    <option value="all" selected>Show All</option>
                                    <option value="personal">Personal Info</option>
                                    <option value="contact">Contact Info</option>
                                    <option value="membership">Membership Info</option>
                                    <option value="address">Address Info</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 ml-6">
                            <div id="resultInfo" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> members
                            </div>
                            <input type="text" id="searchInput" placeholder="Search members..." 
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300 w-48">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="min-w-[600px]">
                            <table id="membersTable" class="w-full bg-white dark:bg-gray-900 text-sm">
                                <thead class="bg-[#101966] dark:bg-gray-800 text-gray-200 dark:text-gray-200">
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="px-6 py-3 text-center font-medium">#</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-personal">Full Name</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-contact">Email</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-contact">Cellphone</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-membership">Record No.</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-membership">Membership Type</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-membership">Start Date</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-membership">End Date</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-membership">Status</th>
                                        <th class="px-6 py-3 text-center font-medium border-l border-white column-address">Address</th>
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
                fetchMembers();

                $('#searchInput').on('keyup', function () {
                    fetchMembers(1, $(this).val());
                });

                $('#perPage').on('change', function () {
                    fetchMembers(1, $('#searchInput').val(), $(this).val());
                });

                $('#sortBy').on('change', function() {
                    fetchMembers(1, $('#searchInput').val(), $('#perPage').val());
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
                                $(this).toggle(columnName === selectedColumn);
                            }
                        });
                    }
                }

                function fetchMembers(page = 1, search = '', perPage = $('#perPage').val()) {
                    const sortValue = $('#sortBy').val() || 'created_desc';
                    const lastUnderscore = sortValue.lastIndexOf('_');
                    const column = sortValue.substring(0, lastUnderscore);
                    const direction = sortValue.substring(lastUnderscore + 1);
                    const sortParams = `&sort=${column}&direction=${direction}`;
                    
                    $.ajax({
                        url: `{{ route('members.index') }}?page=${page}&search=${search}&perPage=${perPage}${sortParams}`,
                        type: 'GET',
                        success: function (response) {
                            renderMembers(response.data, response.from);
                            renderPagination(response);
                            $('#startRecord').text(response.from ?? 0);
                            $('#endRecord').text(response.to ?? 0);
                            $('#totalRecords').text(response.total ?? 0);
                        }
                    });
                }

                function renderMembers(members, startIndex) {
                    let tbody = $('#membersTable tbody');
                    tbody.empty();
                    
                    members.forEach((member, index) => {
                        const rowNumber = startIndex + index;
                        const fullName = `${member.first_name} ${member.last_name}`;
                        const statusBadge = member.is_lifetime_member 
                            ? '<span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-100">Lifetime</span>'
                            : member.status === 'Active'
                                ? '<span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-100">Active</span>'
                                : '<span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-100">Inactive</span>';
                        
                        tbody.append(`
                            <tr class="border-b table-row-hover dark:border-gray-700">
                                <td class="px-6 py-4 text-center">${rowNumber}</td>
                                <td class="px-6 py-4 text-left column-personal">${fullName}</td>
                                <td class="px-6 py-4 text-left column-contact">${member.email_address}</td>
                                <td class="px-6 py-4 text-left column-contact">${member.cellphone_no}</td>
                                <td class="px-6 py-4 text-center column-membership">${member.rec_number}</td>
                                <td class="px-6 py-4 text-center column-membership">${member.membership_type}</td>
                                <td class="px-6 py-4 text-center column-membership">${member.membership_start}</td>
                                <td class="px-6 py-4 text-center column-membership">${member.membership_end || '-'}</td>
                                <td class="px-6 py-4 text-center column-membership">${statusBadge}</td>
                                <td class="px-6 py-4 text-left column-address">${member.street_address || ''}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center space-x-2">
                                    ${member.can_view ? `
                                    <a href="/members/${member.id}" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_edit ? `
                                    <a href="/members/${member.id}/edit" class="group bg-indigo-100 hover:bg-indigo-200 p-2 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-indigo-600 group-hover:text-indigo-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_renew ? `
                                    <a href="/members/${member.id}/renew" class="group bg-green-100 hover:bg-green-200 p-2 rounded-full transition" title="Renew">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-green-600 group-hover:text-green-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </a>
                                    ` : ''}
                                    ${member.can_delete ? `
                                    <button onclick="deleteMember(${member.id})" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-red-600 group-hover:text-red-800 transition"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    ` : ''}
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
                                onclick="fetchMembers(1, $('#searchInput').val(), $('#perPage').val())">
                                &laquo; First
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchMembers(${data.current_page - 1}, $('#searchInput').val(), $('#perPage').val())">
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
                                onclick="fetchMembers(1, $('#searchInput').val(), $('#perPage').val())">
                                1
                            </button>`;
                        if (startPage > 2) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${i === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchMembers(${i}, $('#searchInput').val(), $('#perPage').val())">
                                ${i}
                            </button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<span class="px-2">...</span>`;
                        }
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border ${totalPages === currentPage ? 'bg-[#101966] text-white' : 'bg-white hover:bg-gray-200'}"
                                onclick="fetchMembers(${totalPages}, $('#searchInput').val(), $('#perPage').val())">
                                ${totalPages}
                            </button>`;
                    }

                    if (data.current_page < data.last_page) {
                        paginationHtml += `
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchMembers(${data.current_page + 1}, $('#searchInput').val(), $('#perPage').val())">
                                Next
                            </button>
                            <button class="px-3 py-1 rounded border bg-white hover:bg-gray-200"
                                onclick="fetchMembers(${data.last_page}, $('#searchInput').val(), $('#perPage').val())">
                                Last &raquo;
                            </button>`;
                    }

                    paginationHtml += '</div>';
                    $('#paginationLinks').html(paginationHtml);
                }

                window.deleteMember = function (id) {
                    if (confirm("Are you sure you want to delete this member?")) {
                        $.ajax({
                            url: '{{ route("members.destroy") }}',
                            type: 'DELETE',
                            data: { id: id },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                fetchMembers();
                            }
                        });
                    }
                }

                window.fetchMembers = fetchMembers;
            });
        </script>
    </x-slot>
</x-app-layout>