<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                p-4 sm:p-6 rounded-lg shadow-lg
                bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

        <!-- Header Title -->
        <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
            {{ __('Email') }}
        </h2>

        <!-- Button Group -->
        <div class="flex flex-col sm:flex-row sm:space-x-6 gap-3 sm:gap-0 justify-center sm:justify-end w-full sm:w-auto">

            @can('create emails')
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
