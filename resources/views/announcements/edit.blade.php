<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Announcements / Edit
            </h2>
            <a href="{{ route('announcements.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Announcements
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('announcements.update', $announcement->id) }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title', $announcement->title) }}" name="title" placeholder="Enter title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="content" class="text-sm font-medium">Content</label>
                            <div class="my-3">    
                                <textarea name="content" placeholder="Enter content" class="border-gray-300 shadow-sm w-full rounded-lg" rows="6">{{ old('content', $announcement->content) }}</textarea>
                                @error('content')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="members" class="text-sm font-medium">Recipients</label>
                            <div class="my-3">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="select-all" class="rounded mr-2">
                                    <label for="select-all">Select All Members</label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($members as $member)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="members[]" id="member-{{ $member->id }}" value="{{ $member->id }}" 
                                                class="rounded member-checkbox" {{ in_array($member->id, old('members', $announcement->members->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label for="member-{{ $member->id }}" class="ml-2">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('members')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" 
                                    {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2">Published</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update
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
            document.getElementById('select-all').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.member-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Check "Select All" if all checkboxes are checked
            const checkboxes = document.querySelectorAll('.member-checkbox');
            const selectAll = document.getElementById('select-all');
            
            function checkSelectAll() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                selectAll.checked = allChecked;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', checkSelectAll);
            });

            // Initial check
            checkSelectAll();
        </script>
    </x-slot>
</x-app-layout>