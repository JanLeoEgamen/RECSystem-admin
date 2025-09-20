<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Refund Payment') }}
            </h2>
            <div class="flex justify-center md:justify-end w-full md:w-auto">
                <a href="{{ route('cashier.rejected') }}"
                   class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                          bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                          dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                          w-full md:w-auto text-center
                          dark:bg-gray-900 dark:text-white dark:border-gray-100 
                          dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Rejected
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6 text-[#101966] dark:text-white">Send Payment Refund</h3>
                    <form method="POST" action="{{ route('cashier.sendRefund', $applicant->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GCash Name</label>
                            <input type="text" value="{{ $applicant->gcash_name }}" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GCash Number</label>
                            <input type="text" value="{{ $applicant->gcash_number }}" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Refund Amount</label>
                            <input type="number" name="refund_amount" step="0.01" min="0" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload GCash Refund Receipt <span class="text-red-500">*</span></label>
                            <input type="file" id="refundReceipt" name="refund_receipt" accept="image/jpeg,image/png" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG. Max size: 5MB.</p>
                            @error('refund_receipt')
                                <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Remarks (optional)</label>
                            <textarea name="remarks" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 text-sm font-medium bg-[#101966] text-white border border-[#101966] rounded-lg hover:bg-white hover:text-blue-600 hover:border-blue-600 dark:hover:bg-gray-900 dark:hover:text-gray-200 transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Send Refund
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
