<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Documents / Create
            </h2>
            <a href="{{ route('documents.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Documents
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title') }}" name="title" placeholder="Enter title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea name="description" placeholder="Enter description" class="border-gray-300 shadow-sm w-full rounded-lg" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="file" class="text-sm font-medium">File Upload</label>
                                    <div class="my-3">    
                                        <input type="file" name="file" id="file" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('file')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, Word, JPEG, PNG, GIF (Max: 2MB)</p>
                                    </div>
                                </div>
                                <div>
                                    <label for="url" class="text-sm font-medium">OR External URL</label>
                                    <div class="my-3">    
                                        <input value="{{ old('url') }}" name="url" placeholder="https://example.com/document.pdf" type="url" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('url')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
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
                                                class="rounded member-checkbox" {{ in_array($member->id, old('members', [])) ? 'checked' : '' }}>
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
                                <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" {{ old('is_published', false) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2">Publish Immediately</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create
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
        </script>
    </x-slot>
</x-app-layout>