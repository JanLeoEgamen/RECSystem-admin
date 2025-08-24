<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Articles / Create
            </h2>

            <a href="{{ route('articles.index') }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-base sm:text-lg md:text-xl leading-normal 
                    transition-colors duration-200 w-full sm:w-auto">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Articles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title') }}" name="title" placeholder="Enter title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="author" class="text-sm font-medium">Article Author</label>
                            <div class="my-3">    
                                <input value="{{ old('author') }}" name="author" placeholder="Enter author" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('author')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="content" class="text-sm font-medium">Content</label>
                            <div class="my-3">    
                                <textarea name="content" placeholder="Enter content" class="border-gray-300 shadow-sm w-1/2 rounded-lg">{{ old('content') }}</textarea>
                                @error('content')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="image" class="text-sm font-medium">Image</label>
                            <div class="my-3">    
                                <input name="image" type="file" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('image')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" name="status" id="status" class="rounded" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                <label for="status" class="ml-2">Active</label>
                            </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">

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
</x-app-layout>