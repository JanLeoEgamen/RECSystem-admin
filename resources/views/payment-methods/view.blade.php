<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Payment Methods / View
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payment Method Details</h3>
                                <dl class="mt-2 space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $paymentMethod->mode_of_payment_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $paymentMethod->account_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $paymentMethod->account_number }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $paymentMethod->created_at->format('M d, Y h:i A') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $paymentMethod->updated_at->format('M d, Y h:i A') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold mb-4">QR Code</h3>
                            <div id="qrCodeContent" class="mt-2 border border-gray-200 dark:border-gray-600 rounded-md p-2">
                                @if($paymentMethod->mode_of_payment_qr_image)
                                    @php
                                    $fileExtension = pathinfo($paymentMethod->mode_of_payment_qr_image, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="relative text-center">
                                            {{-- Remove 'storage/' from the path since files are in public/images --}}
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
                        </div>
                                            
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 text-sm">
                            @if($paymentMethod->is_published)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-200">Published</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-200">Draft</span>
                            @endif
                        </dd>
                    </div>
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('payment-methods.edit', $paymentMethod->id) }}" 
                           class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Payment Method
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>