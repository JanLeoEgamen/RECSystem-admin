<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Inactive Members') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('members.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Members
                </a>        
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="inactiveMembersTable" class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b text-center">
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Cellphone</th>
                                <th>Start</th>
                                <th>End</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#inactiveMembersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('members.inactive') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                        { data: 'full_name', name: 'first_name', className: 'text-center' },
                        { data: 'email_address', name: 'email_address', className: 'text-center' },
                        { data: 'cellphone_no', name: 'cellphone_no', className: 'text-center' },
                        { data: 'membership_start', name: 'membership_start', className: 'text-center' },
                        { data: 'membership_end', name: 'membership_end', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                    ]
                });
            });
        </script>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-member-btn');
            if (!btn) return;

            const memberId = btn.getAttribute('data-id');
            if (!memberId) return;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the member's record.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('members.forceDelete') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            '_method': 'DELETE',
                            'id': memberId
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message || 'Member status set to inactive successfully.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#inactiveMembersTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to delete member.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete member. Please try again.',
                        });
                    });
                }
            });
        });
    });
    </script>

    </x-slot>
</x-app-layout>