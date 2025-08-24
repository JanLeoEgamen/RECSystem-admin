<x-app-layout>
    <x-slot name="header">
       <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Events / Create</span>
            </h2>

            <a href="{{ route('events.index') }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Events
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('events.store') }}" method="post" id="eventForm">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium">Title</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                              class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium">Start Date & Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="start_date" id="start_date" 
                                               value="{{ old('start_date') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium">End Date & Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="end_date" id="end_date" 
                                               value="{{ old('end_date') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium">Location</label>
                                    <div class="mt-1">
                                        <input type="text" name="location" id="location" 
                                               value="{{ old('location') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('location')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="capacity" class="block text-sm font-medium">Capacity (optional)</label>
                                    <div class="mt-1">
                                        <input type="number" name="capacity" id="capacity" 
                                               value="{{ old('capacity') }}" min="1" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Assign to Members</label>
                                <div class="mt-1">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="select-all-members" class="rounded mr-2">
                                        <label for="select-all-members">Select All Members</label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        @foreach($members as $member)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="members[]" id="member-{{ $member->id }}" 
                                                       value="{{ $member->id }}" class="rounded member-checkbox"
                                                       {{ in_array($member->id, old('members', [])) ? 'checked' : '' }}>
                                                <label for="member-{{ $member->id }}" class="ml-2">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('members')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" 
                                       class="rounded" value="1" {{ old('is_published', false) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2 text-sm font-medium">Publish Immediately</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                        class="inline-flex items-center px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] 
                                               border border-white hover:border-[#101966] rounded-lg font-medium text-lg transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("eventForm").addEventListener("submit", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to create this event?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5e6ffb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
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
                            e.target.submit();
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
                title: "Created!",
                text: "{{ session('success') }}",
                confirmButtonColor: "#5e6ffb",
                background: '#101966',
                color: '#fff'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
                confirmButtonColor: "#5e6ffb",
                background: '#101966',
                color: '#fff'
            });
        @endif
    </script>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('select-all-members').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.member-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                const memberCheckboxes = document.querySelectorAll('.member-checkbox');
                const selectAllMembers = document.getElementById('select-all-members');

                function checkSelectAllMembers() {
                    const allChecked = Array.from(memberCheckboxes).every(checkbox => checkbox.checked);
                    selectAllMembers.checked = allChecked;
                }

                memberCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', checkSelectAllMembers);
                });

                checkSelectAllMembers();
            });
        </script>
    </x-slot>
</x-app-layout>