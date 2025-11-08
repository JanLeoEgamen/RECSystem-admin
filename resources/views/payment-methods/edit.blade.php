<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Payment Methods / Edit
            </h2>
            <a href="{{ route('payment-methods.index') }}" class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Payment Methods
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header with Icon -->
            <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-xl shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Payment Method</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update payment method details and QR code</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('payment-methods.update', $paymentMethod->id) }}" method="post" enctype="multipart/form-data" id="updateForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payment Details Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Payment Details</h4>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="mode_of_payment_name" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Payment Method Name
                                    </label>
                                    <input value="{{ old('mode_of_payment_name', $paymentMethod->mode_of_payment_name) }}" 
                                        name="mode_of_payment_name" placeholder="e.g., GCash, PayPal, Bank Transfer" 
                                        type="text" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 transition-all duration-200 px-4 py-3">
                                    @error('mode_of_payment_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        Category
                                    </label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <input type="radio" id="category_renewal" name="category" value="renewal" 
                                                {{ old('category', $paymentMethod->category) == 'renewal' ? 'checked' : '' }}
                                                class="peer sr-only">
                                            <label for="category_renewal" class="flex items-center justify-center gap-2 p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-violet-50 dark:hover:bg-gray-600 peer-checked:border-violet-500 peer-checked:bg-violet-50 dark:peer-checked:bg-violet-900/30 peer-checked:ring-2 peer-checked:ring-violet-500 transition-all duration-200">
                                                <div id="renewal-circle" class="relative w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                                    <svg id="renewal-check" class="w-3 h-3 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <span class="font-medium text-gray-700 dark:text-gray-300">Renewal</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="category_application" name="category" value="application" 
                                                {{ old('category', $paymentMethod->category) == 'application' ? 'checked' : '' }}
                                                class="peer sr-only">
                                            <label for="category_application" class="flex items-center justify-center gap-2 p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-violet-50 dark:hover:bg-gray-600 peer-checked:border-violet-500 peer-checked:bg-violet-50 dark:peer-checked:bg-violet-900/30 peer-checked:ring-2 peer-checked:ring-violet-500 transition-all duration-200">
                                                <div id="application-circle" class="relative w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                                    <svg id="application-check" class="w-3 h-3 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <span class="font-medium text-gray-700 dark:text-gray-300">Application</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('category')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="amount" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Amount
                                    </label>
                                    <input value="{{ old('amount', $paymentMethod->amount) }}" 
                                        name="amount" placeholder="0.00" 
                                        type="number" step="0.01" min="0"
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 transition-all duration-200 px-4 py-3">
                                    @error('amount')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-lg border-2 border-violet-200 dark:border-violet-700">
                                    <label for="is_published" class="flex items-center gap-3 cursor-pointer">
                                        <input type="hidden" name="is_published" value="0">
                                        <input type="checkbox" name="is_published" id="is_published" 
                                            class="w-5 h-5 rounded border-gray-300 text-violet-600 focus:ring-2 focus:ring-violet-500" 
                                            value="1" {{ old('is_published', $paymentMethod->is_published) ? 'checked' : '' }}>
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Published Status</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-2 rounded-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">QR Code</h4>
                            </div>

                            <div class="space-y-6">
                                <!-- Current QR Code Display -->
                                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-600 p-4">
                                    @if($paymentMethod->mode_of_payment_qr_image)
                                        @php
                                        $fileExtension = pathinfo($paymentMethod->mode_of_payment_qr_image, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                        @endphp
                                        
                                        @if($isImage)
                                            <div class="relative text-center">
                                                <img src="{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}"
                                                    class="max-h-64 mx-auto rounded-lg shadow-lg dark:shadow-gray-900/50 cursor-zoom-in hover:shadow-xl dark:hover:shadow-gray-900/70 transition-all duration-200 transform hover:scale-105"
                                                    onclick="openZoomModal('{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}')">
                                                <button type="button" onclick="openZoomModal('{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}')"
                                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                    </svg>
                                                    Zoom Image
                                                </button>
                                            </div>
                                        @else
                                            <div class="text-center py-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p class="text-center text-gray-500 dark:text-gray-400 mt-2 font-medium">Unsupported file format</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-8">
                                            <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-center text-gray-500 dark:text-gray-400 mt-3 font-medium">No QR code uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Upload New QR Code -->
                                <div>
                                    <label for="mode_of_payment_qr_image" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        Update QR Code Image
                                    </label>
                                    <input type="file" name="mode_of_payment_qr_image" id="mode_of_payment_qr_image" 
                                        accept="image/*"
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all duration-200 px-4 py-3
                                            file:mr-4 file:py-2.5 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100
                                            dark:file:bg-blue-900 dark:file:text-blue-300
                                            dark:hover:file:bg-blue-800">
                                    @error('mode_of_payment_qr_image')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                        <p class="text-xs text-blue-700 dark:text-blue-300 flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Upload a new image to replace the current QR code. Supported formats: JPG, PNG, GIF, SVG, WEBP
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Card -->
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Info Note -->
                            <div class="flex-1 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-r-lg p-4">
                                <p class="text-sm text-blue-700 dark:text-blue-300 flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>This page allows you to update payment method details, including the payment name, category (Renewal or Application), amount, and QR code image for seamless payment processing.</span>
                                </p>
                            </div>
                            
                            <!-- Update Button -->
                            <div class="flex-shrink-0">
                                <button type="submit" 
                                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span class="text-lg">Update Payment Method</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openZoomModal(imageUrl) {
            // Create modal overlay
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4';
            modalOverlay.onclick = function() {
                document.body.removeChild(modalOverlay);
            };
            
            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'relative max-w-4xl max-h-full';
            modalContent.onclick = function(e) {
                e.stopPropagation();
            };
            
            // Create image
            const img = document.createElement('img');
            img.src = imageUrl;
            img.className = 'max-w-full max-h-full rounded-lg shadow-2xl';
            img.alt = 'QR Code';
            
            // Create close button
            const closeButton = document.createElement('button');
            closeButton.className = 'absolute top-4 right-4 text-white bg-red-600 hover:bg-red-700 rounded-full p-2';
            closeButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            closeButton.onclick = function() {
                document.body.removeChild(modalOverlay);
            };
            
            modalContent.appendChild(img);
            modalContent.appendChild(closeButton);
            modalOverlay.appendChild(modalContent);
            document.body.appendChild(modalOverlay);
        }
    </script>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Category radio button handling
                const renewalRadio = document.getElementById('category_renewal');
                const applicationRadio = document.getElementById('category_application');
                const renewalCircle = document.getElementById('renewal-circle');
                const applicationCircle = document.getElementById('application-circle');
                const renewalCheck = document.getElementById('renewal-check');
                const applicationCheck = document.getElementById('application-check');

                function updateCategoryUI() {
                    if (renewalRadio.checked) {
                        renewalCircle.classList.add('border-violet-500', 'bg-violet-500');
                        renewalCircle.classList.remove('border-gray-300');
                        renewalCheck.classList.remove('hidden');
                        
                        applicationCircle.classList.remove('border-violet-500', 'bg-violet-500');
                        applicationCircle.classList.add('border-gray-300');
                        applicationCheck.classList.add('hidden');
                    } else if (applicationRadio.checked) {
                        applicationCircle.classList.add('border-violet-500', 'bg-violet-500');
                        applicationCircle.classList.remove('border-gray-300');
                        applicationCheck.classList.remove('hidden');
                        
                        renewalCircle.classList.remove('border-violet-500', 'bg-violet-500');
                        renewalCircle.classList.add('border-gray-300');
                        renewalCheck.classList.add('hidden');
                    }
                }

                // Initialize on page load
                updateCategoryUI();

                // Add event listeners
                renewalRadio.addEventListener('change', updateCategoryUI);
                applicationRadio.addEventListener('change', updateCategoryUI);

                // Add SweetAlert for form submission
                document.getElementById("updateForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this payment method?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "Cancel",
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if(result.isConfirmed){
                            Swal.fire({
                                title: 'Updating...',
                                text: 'Please wait',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => Swal.showLoading(),
                                willClose: () => e.target.submit(),
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
            });
        </script>
    </x-slot>
</x-app-layout>