<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Edit User
            </h2>

            <a href="{{ route('users.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium
                        rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto mt-4 md:mt-0 text-center

                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

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
<<<<<<< Updated upstream
                    <form action="{{ route('users.update', $user->id) }}" method="post" id="updateForm">
=======
                    <form id="updateForm" action="{{ route('users.update', $user->id) }}" method="post">
>>>>>>> Stashed changes
                        @csrf
                        <div class="space-y-6">
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

                            <div class="flex justify-end">
                                <button type="button" id="updateButton" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium 
                                        rounded-lg text-xl leading-normal transition-colors duration-200
                                        dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
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
        document.getElementById("updateButton").addEventListener("click", function() {
            Swal.fire({
                title: 'Update User?',
                text: "Are you sure you want to update this user?",
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
                            document.getElementById('updateForm').submit();
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

                    // Bureau and Section selection logic
        document.addEventListener('DOMContentLoaded', function() {
            // Get all bureau checkboxes
            const bureauCheckboxes = document.querySelectorAll('.bureau-checkbox');
            
            // Add event listener to each bureau checkbox
            bureauCheckboxes.forEach(bureauCheckbox => {
                bureauCheckbox.addEventListener('change', function() {
                    const bureauId = this.value;
                    const bureauDiv = this.closest('.rounded-lg');
                    
                    // Get all section checkboxes within this bureau
                    const sectionCheckboxes = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    if (this.checked) {
                        // Check all sections when bureau is checked
                        sectionCheckboxes.forEach(sectionCheckbox => {
                            sectionCheckbox.checked = true;
                        });
                    } else {
                        // Uncheck all sections when bureau is unchecked
                        sectionCheckboxes.forEach(sectionCheckbox => {
                            sectionCheckbox.checked = false;
                        });
                    }
                });
            });

            // Optional: Add event listener to section checkboxes to handle bureau state
            const sectionCheckboxes = document.querySelectorAll('.section-checkbox');
            sectionCheckboxes.forEach(sectionCheckbox => {
                sectionCheckbox.addEventListener('change', function() {
                    const bureauDiv = this.closest('.rounded-lg');
                    const bureauCheckbox = bureauDiv.querySelector('.bureau-checkbox');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    // Check if all sections are checked
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    
                    // Check if any sections are checked
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked) {
                        // If all sections are checked, check the bureau
                        bureauCheckbox.checked = true;
                    } else if (!anySectionsChecked) {
                        // If no sections are checked, uncheck the bureau
                        bureauCheckbox.checked = false;
                    }
                    // If some but not all sections are checked, the bureau remains in indeterminate state
                    // (visually, this won't show as checked or unchecked)
                });
            });

            // Initialize bureau states based on section selections
            function initializeBureauStates() {
                bureauCheckboxes.forEach(bureauCheckbox => {
                    const bureauDiv = bureauCheckbox.closest('.rounded-lg');
                    const allSections = bureauDiv.querySelectorAll('.section-checkbox');
                    
                    const allSectionsChecked = Array.from(allSections).every(section => section.checked);
                    const anySectionsChecked = Array.from(allSections).some(section => section.checked);
                    
                    if (allSectionsChecked) {
                        bureauCheckbox.checked = true;
                    } else if (anySectionsChecked) {
                        // For partially checked state, we can set indeterminate property
                        bureauCheckbox.indeterminate = true;
                    } else {
                        bureauCheckbox.checked = false;
                        bureauCheckbox.indeterminate = false;
                    }
                });
            }

            // Call initialization
            initializeBureauStates();
        });

    </script>
</x-app-layout>