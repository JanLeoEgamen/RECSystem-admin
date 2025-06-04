<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Licensed Members') }}
            </h2>
            <a href="{{ route('licenses.unlicensed') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">
                Manage Unlicensed Members
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="licensesTable" class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Callsign</th>
                                <th class="px-6 py-3 text-left">License Class</th>
                                <th class="px-6 py-3 text-left">Membership Type</th>
                                <th class="px-6 py-3 text-left">Bureau</th>
                                <th class="px-6 py-3 text-left">Section</th>
                                <th class="px-6 py-3 text-left">License Validity</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#licensesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('licenses.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'callsign', name: 'callsign' },
                        { data: 'license_class', name: 'license_class' },
                        { data: 'membership_type', name: 'membershipType.type_name' },
                        { data: 'bureau', name: 'section.bureau.bureau_name' },
                        { data: 'section', name: 'section.section_name' },
                        { data: 'license_validity', name: 'license_expiration_date' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    responsive: true,
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 100],
                    pageLength: 10
                });
            });

            function deleteLicense(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route("licenses.destroy") }}',
                        type: 'delete',
                        data: {id: id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#licensesTable').DataTable().ajax.reload();
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>