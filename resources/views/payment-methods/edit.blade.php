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
                                    <label for="mode_of_payment_name" class="text-sm font-medium">Payment Method Name</label>
                                    <div class="my-3">    
                                        <input value="{{ old('mode_of_payment_name', $paymentMethod->mode_of_payment_name) }}" 
                                            name="mode_of_payment_name" placeholder="e.g., GCash, PayPal, Bank Transfer" 
                                            type="text" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('mode_of_payment_name')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="account_name" class="text-sm font-medium">Account Name</label>
                                    <div class="my-3">    
                                        <input value="{{ old('account_name', $paymentMethod->account_name) }}" 
                                            name="account_name" placeholder="Account holder name" 
                                            type="text" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('account_name')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="account_number" class="text-sm font-medium">Account Number</label>
                                    <div class="my-3">    
                                        <input value="{{ old('account_number', $paymentMethod->account_number) }}" 
                                            name="account_number" placeholder="Account number or details" 
                                            type="text" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('account_number')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-3 flex items-center">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" 
                                        {{ old('is_published', isset($paymentMethod) ? $paymentMethod->is_published : true) ? 'checked' : '' }}>
                                    <label for="is_published" class="ml-2">Published</label>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">QR Code</h3>
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-md p-4">
                                        @if($paymentMethod->mode_of_payment_qr_image)
                                            @php
                                            $fileExtension = pathinfo($paymentMethod->mode_of_payment_qr_image, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                            @endphp
                                            
                                            @if($isImage)
                                                <div class="relative text-center mb-4">
                                                    <img src="{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}"
                                                        class="max-h-64 mx-auto rounded-md shadow cursor-zoom-in"
                                                        onclick="openZoomModal('{{ asset('images/' . $paymentMethod->mode_of_payment_qr_image) }}')">
                                                </div>
                                            @else
                                                <p class="text-center text-gray-500 py-4">Unsupported file format</p>
                                            @endif
                                        @else
                                            <p class="text-center text-gray-500 py-4">No QR code uploaded</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label for="mode_of_payment_qr_image" class="text-sm font-medium">Update QR Code Image</label>
                                    <div class="my-3">    
                                        <input type="file" name="mode_of_payment_qr_image" id="mode_of_payment_qr_image" 
                                            class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('mode_of_payment_qr_image')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                        <p class="text-sm text-gray-500 mt-2">
                                            Upload a new image to replace the current QR code. Supported formats: JPG, PNG, GIF, SVG, WEBP
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
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