<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="font-bold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                    Create New Role
                </h2>
            </div>

            <a href="{{ route('roles.index') }}" 
                class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal 
                w-full md:w-auto shadow-lg hover:shadow-xl transition-all duration-200">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Roles
            </a>         
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <form id="createRoleForm" action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="space-y-8">
                            <!-- Role Name Section -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Role Information</h3>
                                </div>
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            Role Name <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <div class="mt-2">    
                                        <input value="{{ old('name') }}" name="name" id="name" placeholder="Enter role name (e.g., Administrator, Editor)" type="text" 
                                            class="block w-full md:w-2/3 lg:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions Section -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-lg shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Assign Permissions</h3>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    @foreach($groupedPermissions as $object => $permissions)
                                        <div class="bg-gradient-to-br from-[#4C5091] to-[#3a4073] rounded-xl shadow-lg p-6 border-2 border-[#5a60a1] hover:border-[#6a70b1] transition-all duration-300 hover:shadow-xl transform hover:scale-[1.02]">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-bold capitalize text-white">
                                                    {{ ucfirst($object) }} Permissions
                                                </h3>
                                            </div>
                                            <div class="space-y-3 mt-4">
                                                @foreach($permissions as $permission)
                                                    <label class="flex items-center space-x-3 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 cursor-pointer group">
                                                        <input type="checkbox"
                                                            name="permission[]"
                                                            value="{{ $permission->name }}"
                                                            id="permission-{{ $permission->id }}"
                                                            class="rounded h-5 w-5 border-2 border-white/50 text-indigo-600 focus:ring-2 focus:ring-white/50 cursor-pointer transition-all duration-200">
                                                        <span class="text-white font-medium group-hover:text-gray-100 transition-colors duration-200">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="button" id="createBtn"
                                    class="inline-flex items-center px-8 py-4 text-white bg-gradient-to-r from-[#101966] to-indigo-700 hover:from-white hover:to-gray-50 hover:text-[#101966] 
                                    border-2 border-[#101966] hover:border-[#101966] rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105
                                    dark:from-gray-900 dark:to-gray-800 dark:text-white dark:border-gray-100 
                                    dark:hover:from-gray-700 dark:hover:to-gray-600 dark:hover:text-white dark:hover:border-gray-100">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Role
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('createBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Create Role?',
                text: "Are you sure you want to create this role?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'Cancel',
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Creating...',
                        text: 'Please wait',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            document.getElementById('createRoleForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });
    </script>
</x-app-layout>