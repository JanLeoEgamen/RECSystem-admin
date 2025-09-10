<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Roles / Edit
            </h2>
            <a href="{{ route('roles.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                w-full md:w-auto">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Roles
            </a>       
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="updateRoleForm" action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        <div>
                            <label class="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $role->name) }}" name="name" placeholder="Enter name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6 mb-6">
                                @foreach($groupedPermissions as $object => $permissions)
                                    <div class="border p-4 rounded-lg" style="background-color: #4C5091;">
                                        <h3 class="text-lg font-semibold mb-2 capitalize text-white">
                                            {{ ucfirst($object) }} Permissions
                                        </h3>
                                        <div class="grid grid-cols-1 gap-2">
                                            @foreach($permissions as $permission)
                                                <label class="flex items-center space-x-2">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}"
                                                        class="rounded"
                                                        {{ in_array($permission->name, $hasPermissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                                                    <span class="text-white">{{ $permission->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <button type="button" id="updateRoleBtn"
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('updateRoleBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Update Role?',
                text: "Are you sure you want to update this role?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            document.getElementById('updateRoleForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Updated!",
                text: "{{ session('success') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif
    </script>
</x-app-layout>