<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            {{ __('Applicants') }}
        </h2>

        <div class="flex items-center flex-wrap gap-4">
            @can('create applicants')
            <a href="{{ route('applicants.showApplicantCreateForm') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</a>
            @endcan

            @can('view applicants')
            <a href="{{ route('applicants.rejected') }}" dusk="go-to-rejected" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Rejected Applicants</a>

            <a href="{{ route('applicants.approved') }}" dusk="go-to-approved" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Approved Applicants</a>
            @endcan
        </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="applicantsTable" class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-center">#</th>
                                <th class="px-6 py-3 text-center">Full Name</th>
                                <th class="px-6 py-3 text-center">Sex</th>
                                <th class="px-6 py-3 text-center">Birthdate</th>
                                <th class="px-6 py-3 text-center">Contact No.</th>
                                <th class="px-6 py-3 text-center">Created</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- Include DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <!-- Include DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#applicantsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('applicants.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'full_name', name: 'first_name', className: 'text-center' },
                        { data: 'sex', name: 'sex', className: 'text-center' },
                        { data: 'birthdate', name: 'birthdate', className: 'text-center' },
                        { data: 'cellphone_no', name: 'cellphone_no', className: 'text-center' },
                        { data: 'created_at', name: 'created_at', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false , className: 'text-center'}
                    ],
                    responsive: true,
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 100],
                    pageLength: 10,
                    order: [[1, 'asc']] // Default sort by name
                });
            });

            function deleteApplicant(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route("applicants.destroy") }}',
                        type: 'delete',
                        data: {id: id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#applicantsTable').DataTable().ajax.reload();
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>