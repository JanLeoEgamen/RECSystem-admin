<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Membership Renewal') }}
            </h2>
        </div>
    </x-slot>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                        <!-- Left: Payment Details Section -->
                        <div class="order-2 lg:order-1 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
                            <div id="paymentMethodDetails" class="hidden">
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span id="selectedMethodName" class="text-blue-900 dark:text-blue-100"></span>
                                        </h3>
                                        <div class="relative group">
                                            <button type="button" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                            <div class="invisible group-hover:visible absolute z-10 w-56 px-4 py-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xl dark:bg-gray-700 -top-2 -translate-y-full right-0 transition-all">
                                                <p class="mb-1 font-semibold">Refundable Transaction</p>
                                                <p class="text-xs text-gray-300">This payment can be refunded if needed</p>
                                                <div class="absolute top-full right-4 border-4 border-transparent border-t-gray-900 dark:border-t-gray-700"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                                </div>
                                
                                <!-- QR Code Section -->
                                <div class="mb-6" id="qrCodeContainer">
                                    <div class="bg-white dark:bg-gray-800 border-2 border-dashed border-blue-300 dark:border-blue-700 p-4 rounded-xl relative hover:border-blue-500 dark:hover:border-blue-500 transition-colors duration-300">
                                        <div class="relative group">
                                            <img id="qrCodeImage" src="" alt="QR Code" class="w-full h-auto max-w-xs mx-auto rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-md hidden group-hover:shadow-xl transition-shadow duration-300">
                                            <button type="button" onclick="zoomQRCode()" class="absolute bottom-3 right-3 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-lg transform hover:scale-110 transition-all duration-200">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="button" onclick="zoomQRCode()" class="mt-3 text-sm font-medium text-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline w-full transition-colors">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                Click to enlarge
                                            </span>
                                        </button>
                                    </div>
                                    <div id="noQrCode" class="text-center py-12 text-gray-500 dark:text-gray-400 hidden">
                                        <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium">No QR code available</p>
                                        <p class="text-xs mt-1">Payment method doesn't have a QR code</p>
                                    </div>
                                </div>

                                <!-- Total Amount Section -->
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border-l-4 border-green-500 dark:border-green-400 p-5 rounded-lg mb-6 shadow-md">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-green-500 dark:bg-green-600 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-green-700 dark:text-green-300 uppercase tracking-wide">Total Amount</p>
                                                <p class="text-sm font-semibold text-green-800 dark:text-green-200">Amount Due</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span id="totalAmountDue" class="text-2xl sm:text-3xl font-bold text-green-700 dark:text-green-300">₱0.00</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Instructions -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-l-4 border-blue-500 dark:border-blue-400 p-5 rounded-lg shadow-md">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-blue-500 dark:bg-blue-600 p-2 rounded-full flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-blue-900 dark:text-blue-100 mb-3 uppercase tracking-wide">
                                                Payment Instructions
                                            </p>
                                            <ol class="space-y-2">
                                                <li class="flex items-start gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                                    <span class="text-sm text-blue-800 dark:text-blue-200 pt-0.5">Scan the QR code above to make payment</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                                    <span class="text-sm text-blue-800 dark:text-blue-200 pt-0.5">Save the payment confirmation receipt</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                                    <span class="text-sm text-blue-800 dark:text-blue-200 pt-0.5">Upload the receipt screenshot below</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                                                    <span class="text-sm text-blue-800 dark:text-blue-200 pt-0.5">Enter your reference number</span>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- No Payment Method Selected -->
                            <div id="noPaymentSelected" class="text-center py-12">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center shadow-lg">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Select a Payment Method</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 max-w-xs mx-auto">Choose a payment method from the options to view QR code and payment instructions</p>
                            </div>
                        </div>

                        {{-- Right: Payment Form + Upload --}}
                        <div class="order-1 lg:order-2 space-y-6">
                            {{-- Payment Method Selection --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <label for="paymentMethodSelect" class="flex items-center gap-2 text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select id="paymentMethodSelect" name="payment_method_id" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
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
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <label for="reference_number" class="flex items-center gap-2 text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Reference Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="reference_number" name="reference_number" required 
                                    class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500"
                                    placeholder="e.g. 1234 567 123456"
                                    maxlength="15"
                                    oninput="formatGcashRefNumber(this)"
                                    onkeypress="return isNumberKey(event)"
                                    value="{{ old('reference_number') }}">
                                <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                                <p id="gcashRefError" class="mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400 font-medium hidden flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Please enter a valid 13-digit reference number (e.g., 1234 567 123456)
                                </p>
                            </div>

                            {{-- File Upload --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <label for="receipt" class="flex items-center gap-2 text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Upload Payment Proof <span class="text-red-500">*</span>
                                </label>
                                <div id="uploadContainer" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-300 bg-gray-50 dark:bg-gray-700/50">
                                    <input type="file" id="receipt" name="receipt" accept="image/*" class="hidden" required onchange="handleFileUpload(this)">
                                    <label for="receipt" class="cursor-pointer block">
                                        <div id="uploadContent">
                                            <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Click to upload payment screenshot</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 5MB</p>
                                        </div>
                                    </label>
                                </div>
                                <div id="file-preview" class="hidden mt-4"></div>
                                <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                            </div>

                            {{-- Buttons --}}
                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                                <a href="{{ route('member.dashboard') }}" class="px-6 py-3 bg-red-600 dark:bg-red-700 text-white dark:text-white rounded-lg font-semibold hover:bg-red-700 dark:hover:bg-red-800 transition-all duration-200 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    Cancel
                                </a>
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
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
    <div id="qrZoomModal" class="fixed inset-0 bg-black bg-opacity-90 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full p-6 shadow-2xl border-2 border-gray-300 dark:border-gray-600">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Payment QR Code
                </h3>
                <button onclick="closeZoom()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded-full p-2 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900 rounded-xl p-4">
                <img id="zoomedQrCodeImage" src="" alt="QR Code (Zoomed)" class="w-full h-auto max-h-[70vh] rounded-lg shadow-xl">
            </div>
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">Scan this QR code with your payment app</p>
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
            const uploadContainer = document.getElementById('uploadContainer');
            filePreview.innerHTML = ''; // Clear any previous preview
            filePreview.classList.remove('hidden');
            uploadContainer.classList.add('hidden');

            const isImage = file.type.match('image.*');
            const isPDF = file.type === 'application/pdf';

            let previewHTML = `
                <div>
                    <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mb-4">
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
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center">Click to change the image</p>
            `;

            if (isImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewHTML += `
                        <div class="cursor-pointer" onclick="document.getElementById('receipt').click()">
                            <img src="${e.target.result}" class="max-h-60 mx-auto rounded-md border border-gray-300 dark:border-gray-600 hover:opacity-75 transition-opacity" />
                        </div>
                    `;
                    previewHTML += `</div>`;
                    filePreview.innerHTML = previewHTML;
                };
                reader.readAsDataURL(file);
            } else {
                previewHTML += `</div>`;
                filePreview.innerHTML = previewHTML;
            }
        }

        function removeFile() {
            const input = document.getElementById('receipt');
            const uploadContainer = document.getElementById('uploadContainer');
            input.value = '';
            document.getElementById('file-preview').classList.add('hidden');
            document.getElementById('file-preview').innerHTML = '';
            uploadContainer.classList.remove('hidden');
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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Handle form submission with loading animation
        document.querySelector('form[action="{{ route("renew.store") }}"]').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading animation
            Swal.fire({
                title: 'Processing',
                html: 'Submitting your renewal request...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                background: '#101966',
                color: '#fff',
                didOpen: (modal) => {
                    Swal.showLoading();
                }
            });

            // Submit the form after showing the alert
            setTimeout(() => {
                this.submit();
            }, 500);
        });
    </script>
</x-app-layout>