<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Edit User
            </h2>
            <a href="{{ route('users.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition duration-150 ease-in-out">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Users
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        <div class="space-y-6">
                            <!-- Personal Information Section -->
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Personal Information</h3>
                                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-medium">First Name</label>
                                        <div class="mt-1">
                                            <div class="block w-full rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-2 border border-gray-300 dark:border-gray-600">
                                                {{ $user->first_name }}
                                            </div>
                                            <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-medium">Last Name</label>
                                        <div class="mt-1">
                                            <div class="block w-full rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-2 border border-gray-300 dark:border-gray-600">
                                                {{ $user->last_name }}
                                            </div>
                                            <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="birthdate" class="block text-sm font-medium">Birthdate</label>
                                        <div class="mt-1">
                                            <div class="block w-full rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-2 border border-gray-300 dark:border-gray-600">
                                                {{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : 'N/A' }}
                                            </div>
                                            <input type="hidden" name="birthdate" value="{{ $user->birthdate ? (\Carbon\Carbon::parse($user->birthdate)->format('Y-m-d')) : '' }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium">Email</label>
                                        <div class="mt-1">
                                            <div class="block w-full rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-2 border border-gray-300 dark:border-gray-600">
                                                {{ $user->email }}
                                            </div>
                                            <input type="hidden" name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Assign Roles</h3>
                                <div class="mt-4">
                                    @if ($roles->isNotEmpty())
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach($roles as $role)
                                                <div class="relative flex items-start">
                                                    <div class="flex h-5 items-center">
                                                        <input id="role-{{ $role->id }}" name="role" type="radio" value="{{ $role->name }}" {{ $hasRoles->contains($role->id) ? 'checked' : '' }} class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="role-{{ $role->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No roles available</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Bureaus & Sections Section -->
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Assign to Bureaus & Sections</h3>
                                <div class="mt-4 space-y-6">
                                    @foreach($bureaus as $bureau)
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" 
                                                    {{ $user->assignedBureaus->contains($bureau->id) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bureau-checkbox">
                                                <label for="bureau-{{ $bureau->id }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $bureau->bureau_name }}
                                                </label>
                                            </div>
                                            
                                            @if($bureau->sections->isNotEmpty())
                                                <div class="mt-3 ml-7 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($bureau->sections as $section)
                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}"
                                                                {{ $user->assignedSections->contains($section->id) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 section-checkbox">
                                                            <label for="section-{{ $section->id }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-400">
                                                                {{ $section->section_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("updateForm").addEventListener("submit", function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to update this user?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5e6ffb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!",
                cancelButtonText: "Cancel",
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
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
