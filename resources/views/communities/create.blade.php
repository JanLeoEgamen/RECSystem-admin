<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Community Content / Create
            </h2>

            <a href="{{ route('communities.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0 text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Communities
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="communityForm" action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        {{-- Content --}}
                        <div>
                            <label for="content" class="block text-sm font-medium">Content</label>
                            <textarea name="content" id="content" rows="4" 
                                class="mt-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm w-full md:w-2/3 rounded-lg focus:ring-[#101966] focus:border-[#101966]" 
                                placeholder="Enter content">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div>
                            <label for="image" class="block text-sm font-medium">Image</label>
                            <input name="image" id="image" type="file" 
                                class="mt-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm w-full md:w-2/3 rounded-lg focus:ring-[#101966] focus:border-[#101966]" 
                                required>
                            @error('image')
                                <p class="mt-1 text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="flex items-center">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" id="status" value="1" 
                                class="rounded border-gray-300 text-[#101966] focus:ring-[#101966]"
                                {{ old('status', true) ? 'checked' : '' }}>
                            <label for="status" class="ml-2 text-sm">Active</label>
                        </div>

                        {{-- Submit --}}
                        <div>
                            <button type="button" id="createCommunityBtn"
                                class="inline-flex items-center px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] 
                                    border border-white hover:border-[#101966] dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg font-medium text-lg transition-colors duration-200">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Community Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('createCommunityBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Create Community Content?',
                text: "Are you sure you want to create this community content?",
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
                            document.getElementById('communityForm').submit();
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