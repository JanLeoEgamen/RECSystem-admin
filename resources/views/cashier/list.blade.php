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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table id="applicantsTable" class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-b text-center">
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Reference #</th>
                                <th>Receipt</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                $('#applicantsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('cashier.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'first_name', name: 'first_name', className: 'text-center' },
                        { data: 'last_name', name: 'last_name', className: 'text-center' },
                        { data: 'email_address', name: 'email_address', className: 'text-center' },
                        { data: 'reference_number', name: 'reference_number', className: 'text-center' },
                        { data: 'payment_proof_path', name: 'payment_proof_path', className: 'text-center' },
                        { data: 'payment_status', name: 'payment_status', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                    ]
                });
            });

            function verifyApplicant(id) {
                if (confirm("Confirm payment verification?")) {
                    $.post('/cashier/' + id + '/verify', {
                        _token: '{{ csrf_token() }}'
                    }, function (res) {
                        $('#applicantsTable').DataTable().ajax.reload();
                        alert(res.message);
                    }); 
                }
            }
        </script>
    </x-slot>
</x-app-layout>
