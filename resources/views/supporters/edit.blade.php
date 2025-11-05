<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Supporters / Edit
            </h2>

            <a href="{{ route('supporters.index') }}"
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0 text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Supporters
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8 md:p-10">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-gradient-to-r from-rose-500 to-pink-600 p-3 rounded-xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Supporter</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 ml-16">Update the supporter information below</p>
                    </div>

                    <form id="supporterEditForm" action="{{ route('supporters.update', $supporter->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Supporter Details Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Supporter Details</h4>
                            </div>

                            <div>
                                <label for="supporter_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Supporter Name
                                    </span>
                                </label>
                                <input type="text" id="supporter_name" name="supporter_name" placeholder="Enter supporter name" value="{{ old('supporter_name', $supporter->supporter_name) }}" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                @error('supporter_name')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Supporter Image Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Supporter Logo/Image</h4>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        {{ $supporter->image ? 'Replace Image' : 'Upload Image' }}
                                    </span>
                                </label>
                                
                                @if($supporter->image)
                                <!-- Current Image Preview -->
                                <div class="mb-4">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Current Image:</p>
                                    <div class="relative inline-block">
                                        <img src="{{ asset('images/' . $supporter->image) }}" alt="Current Supporter Image" class="max-w-full h-auto rounded-lg shadow-lg border-2 border-gray-300 dark:border-gray-600" style="max-height: 400px;">
                                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-lg">Current</div>
                                    </div>
                                </div>
                                @endif

                                <!-- New Image Preview Container -->
                                <div id="imagePreviewContainer" class="hidden mb-4">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">New Image Preview:</p>
                                    <div class="relative inline-block">
                                        <img id="imagePreview" src="" alt="New Image Preview" class="max-w-full h-auto rounded-lg shadow-lg border-2 border-gray-300 dark:border-gray-600" style="max-height: 400px;">
                                        <button type="button" onclick="removeNewImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-medium" id="imageFileName"></p>
                                </div>
                                
                                <!-- Upload Zone -->
                                <div id="uploadZone">
                                    <label for="image" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors duration-200 dark:border-gray-600 dark:hover:border-emerald-500 cursor-pointer">
                                        <div class="space-y-2 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-semibold text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                                <span class="pl-1">or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, WebP up to 2MB</p>
                                        </div>
                                    </label>
                                    <input 
                                        id="image"
                                        name="image" 
                                        type="file" 
                                        class="hidden" 
                                        accept="image/jpeg,image/png,image/gif,image/bmp,image/webp,image/svg+xml"
                                        onchange="handleImageUpload(event)">
                                </div>
                                
                                @error('image')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ $supporter->image ? 'Leave empty to keep current image' : 'Please upload an image for the supporter' }}</p>
                            </div>
                        </div>

                        <!-- Status & Actions Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" name="status" id="status" class="w-5 h-5 rounded text-rose-600 focus:ring-2 focus:ring-rose-500 dark:bg-gray-700 dark:border-gray-600 transition-all duration-200" value="1" 
                                        {{ old('status', $supporter->status) ? 'checked' : '' }}>
                                    <label for="status" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Active Status
                                    </label>
                                </div>

                                <button type="button" id="updateSupporterBtn" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-700 hover:from-rose-700 hover:to-pink-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Supporter
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
        // Image upload handler
        function handleImageUpload(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            const uploadZone = document.getElementById('uploadZone');
            const fileNameDisplay = document.getElementById('imageFileName');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadZone.classList.add('hidden');
                    
                    // Calculate file size
                    const fileSize = file.size / 1024; // Convert to KB
                    const fileSizeDisplay = fileSize > 1024 
                        ? `${(fileSize / 1024).toFixed(2)} MB` 
                        : `${fileSize.toFixed(2)} KB`;
                    
                    fileNameDisplay.textContent = `File: ${file.name} (${fileSizeDisplay})`;
                }
                
                reader.readAsDataURL(file);
            }
        }
        
        // Remove new image function
        function removeNewImage() {
            const imageInput = document.getElementById('image');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const uploadZone = document.getElementById('uploadZone');
            const previewImage = document.getElementById('imagePreview');
            const fileNameDisplay = document.getElementById('imageFileName');
            
            // Reset the file input
            imageInput.value = '';
            
            // Hide preview and show upload zone
            previewContainer.classList.add('hidden');
            uploadZone.classList.remove('hidden');
            
            // Clear preview
            previewImage.src = '';
            fileNameDisplay.textContent = '';
        }

        document.getElementById('updateSupporterBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Update Supporter?',
                text: "Are you sure you want to update this supporter?",
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
                            document.getElementById('supporterEditForm').submit();
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