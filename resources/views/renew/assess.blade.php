<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            Assess Renewal Request
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                        <!-- Left Column: Member & Renewal Info -->
                        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                            <!-- Member Information Section -->
                            <div>
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Member Information</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Full Name</p>
                                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $renewal->member->first_name }} {{ $renewal->member->last_name }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Membership ID</p>
                                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100 font-mono">{{ $renewal->member->rec_number }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow sm:col-span-2">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Current Membership End</p>
                                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">
                                            {{ $renewal->member->membership_end 
                                                ? \Carbon\Carbon::parse($renewal->member->membership_end)->format('M d, Y') 
                                                : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Renewal Details Section -->
                            <div>
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Renewal Details</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Reference Number</p>
                                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100 font-mono">{{ $renewal->reference_number }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Submitted Date</p>
                                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($renewal->created_at)->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Assessment Form Section -->
                            <form method="POST" action="{{ route('renew.update', $renewal) }}" class="mt-6 sm:mt-8">
                                @csrf
                                @method('PUT')

                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-rose-500 to-red-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-rose-600 to-red-600 bg-clip-text text-transparent">Assessment Form</h3>
                                </div>

                                <div class="space-y-4 sm:space-y-6">
                                    <!-- Decision -->
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="status" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Decision *</label>
                                        <select id="status" name="status" class="block w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-rose-500 dark:focus:border-rose-500 focus:ring-rose-500 dark:focus:ring-rose-500 transition-colors duration-200 font-medium bg-white shadow-sm hover:shadow-md">
                                            <option value="">-- Select Decision --</option>
                                            <option value="approved">✓ Approve Renewal</option>
                                            <option value="rejected">✗ Reject Renewal</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    </div>

                                    <!-- Mobile Receipt Preview (between Decision and Remarks) -->
                                    <div class="lg:hidden">
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">Receipt Preview</label>

                                            <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-shadow duration-200 flex items-center justify-center" style="aspect-ratio: 9/16;">
                                                <img 
                                                    src="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                                                    alt="Uploaded Receipt Preview" 
                                                    class="w-full h-full object-contain"
                                                >
                                            </div>

                                            <a href="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                                            target="_blank" 
                                            rel="noopener noreferrer"
                                            class="mt-3 inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                View Full Image
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Remarks -->
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="remarks" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Remarks (Optional)</label>
                                        <textarea 
                                            id="remarks" 
                                            name="remarks" 
                                            rows="3"
                                            placeholder="Add any additional comments or notes..."
                                            class="block w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-rose-500 dark:focus:border-rose-500 focus:ring-rose-500 dark:focus:ring-rose-500 transition-colors duration-200 shadow-sm hover:shadow-md"
                                        >{{ old('remarks') }}</textarea>
                                        <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex flex-col sm:flex-row items-center justify-start gap-3 sm:gap-4 pt-4 sm:pt-6 mt-4 sm:mt-6 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('renew.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-base sm:text-lg leading-normal transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Back to List
                                    </a>

                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105" onclick="submitWithAlert(event)">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                        Submit Assessment
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column: Receipt Preview (Portrait) -->
                        <div class="hidden lg:block lg:col-span-1">
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 h-full">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">Receipt Preview</label>

                                <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-shadow duration-200 flex items-center justify-center" style="aspect-ratio: 9/16;">
                                    <img 
                                        src="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                                        alt="Uploaded Receipt Preview" 
                                        class="w-full h-full object-contain"
                                    >
                                </div>

                                <a href="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="mt-3 inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View Full Image
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function submitWithAlert(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Submitting Assessment',
            html: 'Processing your renewal assessment...',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            background: '#101966',
            confirmButtonColor: '#5e6ffb',
            cancelButtonColor: '#d33',
            color: '#fff',
            didOpen: (modal) => {
                Swal.showLoading();
                // Submit the form after showing the alert
                setTimeout(() => {
                    event.target.closest('form').submit();
                }, 500);
            }
        });
    }
</script>
