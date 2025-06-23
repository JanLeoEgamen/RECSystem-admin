<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Events / Edit
            </h2>
            <a href="{{ route('events.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Events
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('events.update', $event->id) }}" method="post">
                        @csrf
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium">Title</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                              class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $event->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium">Start Date & Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="start_date" id="start_date" 
                                               value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" 
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
                                               value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Location and Capacity -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium">Location</label>
                                    <div class="mt-1">
                                        <input type="text" name="location" id="location" 
                                               value="{{ old('location', $event->location) }}" 
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
                                               value="{{ old('capacity', $event->capacity) }}" min="1" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Members -->
                            <div>
                                <label for="members" class="block text-sm font-medium">Assign to Members</label>
                                <div class="mt-1">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="select-all-members" class="rounded mr-2"
                                            {{ count($event->members) === count($members) ? 'checked' : '' }}>
                                        <label for="select-all-members">Select All Members</label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        @foreach($members as $member)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="members[]" id="member-{{ $member->id }}" 
                                                       value="{{ $member->id }}" class="rounded member-checkbox"
                                                       {{ in_array($member->id, old('members', $event->members->pluck('id')->toArray())) ? 'checked' : '' }}>
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

                            <!-- Publish Status -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" 
                                       class="rounded" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2 text-sm font-medium">Published</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 rounded-md font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select all members functionality
                document.getElementById('select-all-members').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.member-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                // Check "Select All" if all checkboxes are checked
                const memberCheckboxes = document.querySelectorAll('.member-checkbox');
                const selectAllMembers = document.getElementById('select-all-members');

                function checkSelectAllMembers() {
                    const allChecked = Array.from(memberCheckboxes).every(checkbox => checkbox.checked);
                    selectAllMembers.checked = allChecked;
                }

                memberCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', checkSelectAllMembers);
                });

                // Initialize check
                checkSelectAllMembers();
            });
        </script>
    </x-slot>
</x-app-layout>