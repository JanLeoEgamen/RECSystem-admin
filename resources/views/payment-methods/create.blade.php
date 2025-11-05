<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Payment Methods / Create
            </h2>
            <a href="{{ route('payment-methods.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

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
                    <form id="createPaymentMethodForm" action="{{ route('payment-methods.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="mode_of_payment_name" class="text-sm font-medium text-gray-900 dark:text-gray-100">Payment Method Name</label>
                                <div class="my-3">    
                                    <input value="{{ old('mode_of_payment_name') }}" name="mode_of_payment_name" id="mode_of_payment_name" 
                                        placeholder="e.g., GCash, PayPal, Bank Transfer" type="text" 
                                        class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
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
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3 block">Category</label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="renewal" 
                                            {{ old('category', 'renewal') == 'renewal' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-[#5e6ffb] focus:ring-[#5e6ffb]">
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">Renewal</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="application" 
                                            {{ old('category') == 'application' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-[#5e6ffb] focus:ring-[#5e6ffb]">
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">Application</span>
                                    </label>
                                </div>
                                @error('category')
                                <p class="text-red-400 dark:text-red-300 font-medium mt-2"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div>
                                <label for="amount" class="text-sm font-medium text-gray-900 dark:text-gray-100">Amount</label>
                                <div class="my-3">    
                                    <input value="{{ old('amount') }}" name="amount" id="amount" 
                                        placeholder="0.00" type="number" step="0.01" min="0"
                                        class="border-gray-300 dark:border-gray-600 shadow-sm w-full rounded-lg
                                            bg-white dark:bg-gray-700
                                            text-gray-900 dark:text-gray-100
                                            placeholder-gray-500 dark:placeholder-gray-400
                                            focus:ring-2 focus:ring-[#5e6ffb] focus:border-[#5e6ffb]
                                            dark:focus:ring-[#5e6ffb] dark:focus:border-[#5e6ffb]
                                            transition-colors duration-200">
                                    @error('amount')
                                    <p class="text-red-400 dark:text-red-300 font-medium"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="mode_of_payment_qr_image" class="text-sm font-medium text-gray-900 dark:text-gray-100">QR Code Image</label>
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
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Upload QR code image for this payment method (optional)</p>
                                </div>
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" 
                                    {{ old('is_published', true) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2">Published</label>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                    
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Payment Method
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('createPaymentMethodForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create this payment method?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, create it!",
                        cancelButtonText: "Cancel",
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
                                    e.target.submit();
                                },
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
                        title: "Created!",
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