<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Membership Renewal') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                @if($hasPendingRenewal)
                    {{-- Show pending renewal message --}}
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">Renewal Request in Progress</h3>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <p>Your membership renewal request is currently being processed.</p>
                            <p class="mt-2">Reference Number: <span class="font-semibold">{{ $pendingRenewal->reference_number }}</span></p>
                            <p class="mt-2">Submitted on: {{ $pendingRenewal->created_at->format('F j, Y g:i a') }}</p>
                        </div>
                         <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 rounded-md text-white hover:bg-blue-700 transition-colors duration-300">
                Return to Login
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
                    </div>
                @else

                {{-- Payment + Upload Form --}}
                <form method="POST" action="{{ route('renew.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Hidden field to store selected payment method -->
                    <input type="hidden" id="selectedPaymentMethodId" name="selected_payment_method_id">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Payment Details Section -->
                        <div class="order-1 lg:order-1">
                            <div id="paymentMethodDetails" class="hidden">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 sm:mb-4 flex items-center gap-2">
                                    <span id="selectedMethodName"></span>
                                    <div class="relative inline-block group">
                                        <svg class="w-4 h-4 text-blue-500 hover:text-blue-700 cursor-help transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <div class="invisible group-hover:visible absolute z-10 w-48 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700 -top-2 -translate-y-full left-1/2 -translate-x-1/2">
                                            This transaction is refundable
                                            <div class="tooltip-arrow absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900 dark:border-t-gray-700"></div>
                                        </div>
                                    </div>
                                </h3>
                                
                                <!-- QR Code Image -->
                                <div class="mb-3 sm:mb-4" id="qrCodeContainer">
                                    <div class="border border-gray-300 dark:border-gray-600 p-3 rounded-lg relative w-full max-w-xs mx-auto">
                                        <img id="qrCodeImage" src="" alt="QR Code" class="w-full h-auto rounded-lg border border-gray-200 dark:border-gray-700 hidden">
                                        <button type="button" onclick="zoomQRCode()" class="absolute bottom-2 right-2 bg-blue-600 text-white p-1 rounded-full hover:bg-blue-700">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="button" onclick="zoomQRCode()" class="text-sm text-center text-blue-600 dark:text-blue-400 hover:underline w-full">Click to enlarge</button>
                                    <div id="noQrCode" class="text-center py-8 text-gray-500 dark:text-gray-400 hidden">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-sm">No QR code available</p>
                                    </div>
                                </div>

                                <!-- Total Amount Due -->
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4 rounded-lg mb-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                            </svg>
                                            <span class="text-base font-semibold text-green-800 dark:text-green-200">Total Amount Due:</span>
                                        </div>
                                        <span id="totalAmountDue" class="text-xl font-bold text-green-800 dark:text-green-200">₱0.00</span>
                                    </div>
                                </div>
                                
                                <!-- Simple Instructions -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-4 rounded-lg">
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm text-blue-800 dark:text-blue-200 mb-2">
                                                <span class="font-semibold">Payment Instructions:</span>
                                            </p>
                                            <ol class="list-decimal list-inside text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                                <li>Scan the QR code above to make payment</li>
                                                <li>Save the payment confirmation receipt</li>
                                                <li>Upload the receipt screenshot below</li>
                                                <li>Enter your reference number</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- No Payment Method Selected -->
                            <div id="noPaymentSelected" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                <p class="text-lg font-medium mb-2">Select a Payment Method</p>
                                <p class="text-sm">Please choose a payment method to view payment instructions</p>
                            </div>
                        </div>

                        {{-- Right: Payment Form + Upload --}}
                        <div class="w-full space-y-6 order-2 lg:order-2">
                            {{-- Payment Method Selection --}}
                            <div>
                                <label for="paymentMethodSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Select Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select id="paymentMethodSelect" name="payment_method_id" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400">
                                    <option value="">Choose a payment method...</option>
                                    @foreach($paymentMethods->where('category', 'renewal') as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}" 
                                                data-qr-image="{{ $paymentMethod->mode_of_payment_qr_image ? asset('images/' . $paymentMethod->mode_of_payment_qr_image) : '' }}"
                                                data-method-name="{{ $paymentMethod->mode_of_payment_name }}"
                                                data-amount="{{ $paymentMethod->amount }}">
                                            {{ $paymentMethod->mode_of_payment_name }}
                                            @if($paymentMethod->amount)
                                                - ₱{{ number_format($paymentMethod->amount, 2) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('payment_method_id')" class="mt-2" />
                            </div>

                            {{-- Reference Number --}}
                            <div>
                                <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reference Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="reference_number" name="reference_number" required 
                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                                    placeholder="e.g. 1234 567 123456"
                                    maxlength="15"
                                    oninput="formatGcashRefNumber(this)"
                                    onkeypress="return isNumberKey(event)"
                                    value="{{ old('reference_number') }}">
                                <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                                <p id="gcashRefError" class="mt-1 text-xs sm:text-sm text-red-500 hidden">
                                    Please enter a valid 13-digit reference number (e.g., 1234 567 123456)
                                </p>
                            </div>

                            {{-- File Upload --}}
                            <div>
                                <label for="receipt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Upload Payment Proof <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center payment-proof-container relative">
                                    <input type="file" id="receipt" name="receipt" accept="image/*" class="hidden" required onchange="handleFileUpload(this)">
                                    <label for="receipt" class="cursor-pointer block">
                                        <div id="uploadContent">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Click to upload payment screenshot</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 5MB</p>
                                        </div>
                                    </label>
                                </div>
                                <div id="file-preview" class="hidden mt-4"></div>
                                <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                            </div>

                            {{-- Buttons --}}
                            <div class="flex justify-end gap-4 pt-2">
                                <a href="{{ route('member.dashboard') }}" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-white transition">
                                    Cancel
                                </a>
                                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    Submit Renewal Request
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- QR Code Zoom Modal -->
    <div id="qrZoomModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full p-4">
            <button onclick="closeZoom()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="zoomedQrCodeImage" src="" alt="QR Code (Zoomed)" class="w-full h-auto max-h-[80vh]">
        </div>
    </div>

    <script>
        // Payment Method Selection
        document.getElementById('paymentMethodSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const paymentDetails = document.getElementById('paymentMethodDetails');
            const noPaymentSelected = document.getElementById('noPaymentSelected');
            const qrCodeImage = document.getElementById('qrCodeImage');
            const noQrCode = document.getElementById('noQrCode');
            const selectedMethodId = document.getElementById('selectedPaymentMethodId');
            
            if (this.value) {
                // Show payment details
                paymentDetails.classList.remove('hidden');
                noPaymentSelected.classList.add('hidden');
                
                // Update payment method name
                document.getElementById('selectedMethodName').textContent = selectedOption.getAttribute('data-method-name');

                // Inside the paymentMethodSelect change event, after updating QR code
                const amount = selectedOption.getAttribute('data-amount');
                document.getElementById('totalAmountDue').textContent = amount ? '₱' + parseFloat(amount).toFixed(2) : '₱0.00';
                
                // Update QR code
                const qrImageSrc = selectedOption.getAttribute('data-qr-image');
                if (qrImageSrc) {
                    qrCodeImage.src = qrImageSrc;
                    qrCodeImage.classList.remove('hidden');
                    noQrCode.classList.add('hidden');
                    document.getElementById('zoomedQrCodeImage').src = qrImageSrc;
                } else {
                    qrCodeImage.classList.add('hidden');
                    noQrCode.classList.remove('hidden');
                }
                
                // Set hidden field value
                selectedMethodId.value = this.value;
            } else {
                // Hide payment details
                paymentDetails.classList.add('hidden');
                noPaymentSelected.classList.remove('hidden');
                selectedMethodId.value = '';
            }
        });

        function zoomQRCode() {
            document.getElementById('qrZoomModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeZoom() {
            document.getElementById('qrZoomModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Handle file upload preview
        function handleFileUpload(input) {
            const file = input.files[0];
            if (!file) return;

            const filePreview = document.getElementById('file-preview');
            const uploadContent = document.getElementById('uploadContent');
            filePreview.innerHTML = ''; // Clear any previous preview
            filePreview.classList.remove('hidden');
            uploadContent.classList.add('hidden');

            const isImage = file.type.match('image.*');
            const isPDF = file.type === 'application/pdf';

            let previewHTML = `
                <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div>${getFileIcon(file)}</div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-xs">${file.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${formatFileSize(file.size)}</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile()" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;

            if (isImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewHTML += `
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                            <img src="${e.target.result}" class="max-h-60 mx-auto rounded-md border border-gray-300 dark:border-gray-600" />
                        </div>
                    `;
                    filePreview.innerHTML = previewHTML;
                };
                reader.readAsDataURL(file);
            } else {
                filePreview.innerHTML = previewHTML;
            }
        }

        function removeFile() {
            const input = document.getElementById('receipt');
            const uploadContent = document.getElementById('uploadContent');
            input.value = '';
            document.getElementById('file-preview').classList.add('hidden');
            document.getElementById('file-preview').innerHTML = '';
            uploadContent.classList.remove('hidden');
        }

        // Utility Functions
        function formatFileSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            if (bytes === 0) return '0 Bytes';
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function getFileIcon(file) {
            const type = file.type;
            const name = file.name.toLowerCase();
            
            if (type.match('image.*')) {
                return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>`;
            } else if (name.endsWith('.pdf')) {
                return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>`;
            } else {
                return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>`;
            }
        }

        // GCash Reference Number Formatting
        function formatGcashRefNumber(input) {
            let value = input.value.replace(/\D/g, '');
            
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            
            if (value.length >= 4) {
                value = value.substring(0, 4) + ' ' + value.substring(4);
            }
            if (value.length >= 8) {
                value = value.substring(0, 8) + ' ' + value.substring(8);
            }
            
            input.value = value;
            validateGcashRefNumber(value);
        }

        function validateGcashRefNumber(value) {
            const errorElement = document.getElementById('gcashRefError');
            const digitsOnly = value.replace(/\s/g, '');
            
            if (digitsOnly.length === 13) {
                errorElement.classList.add('hidden');
                return true;
            } else {
                errorElement.classList.remove('hidden');
                return false;
            }
        }

        function isNumberKey(evt) {
            const charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();
                return false;
            }
            return true;
        }

        // Initialize total amount display
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('totalAmountDue').textContent = '₱0.00';
        });
    </script>
</x-app-layout>