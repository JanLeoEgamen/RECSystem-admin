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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('payment-methods.update', $paymentMethod->id) }}" method="post" enctype="multipart/form-data" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="mode_of_payment_name" class="text-sm font-medium text-gray-900 dark:text-gray-100">Payment Method Name</label>
                                    <div class="my-3">    
                                        <input value="{{ old('mode_of_payment_name', $paymentMethod->mode_of_payment_name) }}" 
                                            name="mode_of_payment_name" placeholder="e.g., GCash, PayPal, Bank Transfer" 
                                            type="text" class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
                                                bg-white dark:bg-gray-700
                                                text-gray-900 dark:text-gray-100
                                                placeholder-gray-500 dark:placeholder-gray-400
                                                focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                                dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                                transition-colors duration-200">
                                        @error('mode_of_payment_name')
                                        <p class="text-red-400 dark:text-red-300 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="account_name" class="text-sm font-medium text-gray-900 dark:text-gray-100">Account Name</label>
                                    <div class="my-3">    
                                        <input value="{{ old('account_name', $paymentMethod->account_name) }}" 
                                            name="account_name" placeholder="Account holder name" 
                                            type="text" class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
                                                bg-white dark:bg-gray-700
                                                text-gray-900 dark:text-gray-100
                                                placeholder-gray-500 dark:placeholder-gray-400
                                                focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                                dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                                transition-colors duration-200">
                                        @error('account_name')
                                        <p class="text-red-400 dark:text-red-300 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="account_number" class="text-sm font-medium text-gray-900 dark:text-gray-100">Account Number</label>
                                    <div class="my-3">    
                                        <input value="{{ old('account_number', $paymentMethod->account_number) }}" 
                                            name="account_number" placeholder="Account number or details" 
                                            type="text" class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
                                                bg-white dark:bg-gray-700
                                                text-gray-900 dark:text-gray-100
                                                placeholder-gray-500 dark:placeholder-gray-400
                                                focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                                dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                                transition-colors duration-200">
                                        @error('account_number')
                                        <p class="text-red-400 dark:text-red-300 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-3 flex items-center">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox" name="is_published" id="is_published" 
                                        class="rounded border-gray-300 dark:border-gray-600
                                            text-[#5e6ffb] dark:text-[#5e6ffb]
                                            bg-white dark:bg-gray-700
                                            focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                            dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                            transition-colors duration-200" 
                                        value="1" {{ old('is_published', isset($paymentMethod) ? $paymentMethod->is_published : true) ? 'checked' : '' }}>
                                    <label for="is_published" class="ml-2 text-gray-900 dark:text-gray-100">Published</label>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">QR Code</h3>
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-md p-4 bg-gray-50 dark:bg-gray-700/50">
                                        @if($paymentMethod->mode_of_payment_qr_image)
                                            @php
                                            $fileExtension = pathinfo($paymentMethod->mode_of_payment_qr_image, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                            @endphp
                                            
                                            @if($isImage)
                                                <div class="relative text-center mb-4">
                                                    <img src="{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}"
                                                        class="max-h-64 mx-auto rounded-md shadow-lg dark:shadow-gray-900/50 cursor-zoom-in
                                                            hover:shadow-xl dark:hover:shadow-gray-900/70 transition-shadow duration-200"
                                                        onclick="openZoomModal('{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}')">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 rounded-md transition-all duration-200 flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-white opacity-0 hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-center text-gray-500 dark:text-gray-400 py-4">Unsupported file format</p>
                                            @endif
                                        @else
                                            <div class="text-center py-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m3 0a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2m3 0V2a1 1 0 011-1h8a1 1 0 011 1v2" />
                                                </svg>
                                                <p class="text-center text-gray-500 dark:text-gray-400 mt-2">No QR code uploaded</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label for="mode_of_payment_qr_image" class="text-sm font-medium text-gray-900 dark:text-gray-100">Update QR Code Image</label>
                                    <div class="my-3">    
                                        <input type="file" name="mode_of_payment_qr_image" id="mode_of_payment_qr_image" 
                                            accept="image/*"
                                            class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
                                                bg-white dark:bg-gray-700
                                                text-gray-900 dark:text-gray-100
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-lg file:border-0
                                                file:text-sm file:font-medium
                                                file:bg-[#5e6ffb] file:text-white
                                                hover:file:bg-[#4c63d2]
                                                dark:file:bg-[#5e6ffb] dark:file:text-white
                                                dark:hover:file:bg-[#4c63d2]
                                                focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                                dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                                transition-colors duration-200">
                                        @error('mode_of_payment_qr_image')
                                        <p class="text-red-400 dark:text-red-300 font-medium"> {{ $message }} </p>
                                        @enderror
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                            Upload a new image to replace the current QR code. Supported formats: JPG, PNG, GIF, SVG, WEBP
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <button type="submit" class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Update Payment Method
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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