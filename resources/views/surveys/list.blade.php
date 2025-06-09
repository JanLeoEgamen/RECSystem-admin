<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Surveys     
            </h2>
            @can('create surveys')
            <a href="{{ route('surveys.create') }}" class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="surveysTable" class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-center">#</th>
                                <th class="px-6 py-3 text-center">Title</th>
                                <th class="px-6 py-3 text-center">Responses</th>
                                <th class="px-6 py-3 text-center">Author</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#surveysTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('surveys.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
                        { data: 'title', name: 'title', className: 'text-center'},
                        { data: 'responses_count', name: 'responses_count', className: 'text-center' },
                        { data: 'author', name: 'user.first_name', className: 'text-center' },
                        { data: 'created_at', name: 'created_at', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                    ],
                    responsive: true,
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 100],
                    pageLength: 10,
                    order: [[4, 'desc']] // Default sort by created_at descending
                });
            });

            function deleteSurvey(id) {
                if (confirm("Are you sure you want to delete this survey?")) {
                    $.ajax({
                        url: '{{ route("surveys.destroy") }}',
                        type: 'delete',
                        data: {id: id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#surveysTable').DataTable().ajax.reload();
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>