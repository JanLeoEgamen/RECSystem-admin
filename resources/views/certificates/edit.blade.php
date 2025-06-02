<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Certificate Templates / Edit
            </h2>
            <a href="{{ route('certificates.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Certificates
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('certificates.update', $certificate->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title', $certificate->title) }}" name="title" placeholder="Enter certificate title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="content" class="text-sm font-medium">Content</label>
                            <div class="my-3">    
                                <textarea id="content" name="content" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('content', $certificate->content) }}</textarea>
                                @error('content')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label class="text-sm font-medium">Signatories</label>
                            <div class="my-3" id="signatories-container">
                                @foreach($certificate->signatories as $index => $signatory)
                                <div class="signatory-row flex items-center space-x-4 mb-2">
                                    <input type="text" name="signatories[{{ $index }}][name]" placeholder="Name" 
                                        value="{{ old("signatories.$index.name", $signatory->name) }}" 
                                        class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                                    <input type="text" name="signatories[{{ $index }}][position]" placeholder="Position" 
                                        value="{{ old("signatories.$index.position", $signatory->position) }}" 
                                        class="border-gray-300 shadow-sm rounded-lg w-1/3">
                                    <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-signatory" class="mb-4 text-blue-600 hover:text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Signatory
                            </button>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Update Certificate Template
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- Include CKEditor -->
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            // Initialize CKEditor
            CKEDITOR.replace('content');

            // Add signatory row
            let signatoryCount = {{ count($certificate->signatories) }};
            $('#add-signatory').click(function() {
                const newRow = `
                    <div class="signatory-row flex items-center space-x-4 mb-2">
                        <input type="text" name="signatories[${signatoryCount}][name]" placeholder="Name" class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                        <input type="text" name="signatories[${signatoryCount}][position]" placeholder="Position" class="border-gray-300 shadow-sm rounded-lg w-1/3">
                        <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;
                $('#signatories-container').append(newRow);
                signatoryCount++;
            });

            // Remove signatory row
            $(document).on('click', '.remove-signatory', function() {
                if ($('.signatory-row').length > 1) {
                    $(this).closest('.signatory-row').remove();
                } else {
                    alert('At least one signatory is required.');
                }
            });
        </script>
    </x-slot>
</x-app-layout>