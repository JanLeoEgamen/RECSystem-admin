<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Email') }}
            </h2>
            <div class="flex space-x-6">
                <a href="{{ route('emails.compose') }}" 
                    class="inline-block px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] border border-white dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">
                    Send Email
                </a>

                <a href="{{ route('emails.create') }}" 
                    class="inline-block px-5 py-2 text-white bg-green-600 hover:bg-white hover:text-green-600 border border-white dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-green-400 rounded-lg text-xl leading-normal">
                    Create Template
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 space-y-12"> <!-- Added spacing between sections -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            {{-- Email Templates Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl mb-4 font-semibold">Email Templates</h3>
                    <table id="emailTemplatesTable" class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-center">#</th>
                                <th class="px-6 py-3 text-center">Name</th>
                                <th class="px-6 py-3 text-center">Subject</th>
                                <th class="px-6 py-3 text-center">Body</th>
                                <th class="px-6 py-3 text-center">Created At</th>
                                <th class="px-6 py-3 text-center">Updated At</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Email Logs Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl mb-4 font-semibold">Email Logs</h3>
                    <table id="emailLogsTable" class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-center">#</th>
                                <th class="px-6 py-3 text-center">Recipient Email</th>
                                <th class="px-6 py-3 text-center">Recipient Name</th>
                                <th class="px-6 py-3 text-center">Template Name</th>
                                <th class="px-6 py-3 text-center">Subject</th>
                                <th class="px-6 py-3 text-center">Attachments</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Sent At</th>
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
            $(document).ready(function () {
                // Email Templates DataTable
                $('#emailTemplatesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('emails.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'name', name: 'name', className: 'text-center' },
                        { data: 'subject', name: 'subject', className: 'text-center' },
                        { data: 'body', name: 'body', className: 'text-center' },
                        { data: 'created_at', name: 'created_at', className: 'text-center' },
                        { data: 'updated_at', name: 'updated_at', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                    ],
                    responsive: true,
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 100],
                    pageLength: 10
                });

                // Email Logs DataTable
                $('#emailLogsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('emails.logs') }}", // you need to create this route in your controller
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'recipient_email', name: 'recipient_email', className: 'text-center' },
                        { data: 'recipient_name', name: 'recipient_name', className: 'text-center' },
                        { data: 'template_name', name: 'template_name', className: 'text-center' },
                        { data: 'subject', name: 'subject', className: 'text-center' },
                        { data: 'attachments', name: 'attachments', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'status', name: 'status', className: 'text-center' },
                        { data: 'sent_at', name: 'sent_at', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                    ],
                    responsive: true,
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 100],
                    pageLength: 10
                });
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
                                alert(response.message);
                                $('#emailTemplatesTable').DataTable().ajax.reload();
                            } else {
                                alert(response.message);
                            }
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
                                alert(response.message);
                                $('#emailLogsTable').DataTable().ajax.reload();
                            } else {
                                alert(response.message);
                            }
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
