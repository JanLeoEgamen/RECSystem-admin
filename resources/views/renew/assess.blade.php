<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            Assess Renewal Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Member Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b pb-2">Member Information</h3>
                        <p><strong>Name:</strong> {{ $renewal->member->first_name }} {{ $renewal->member->last_name }}</p>
                        <p><strong>Membership ID:</strong> {{ $renewal->member->rec_number }}</p>
                        <p><strong>Current Membership End:</strong>
                            {{ $renewal->member->membership_end 
                                ? \Carbon\Carbon::parse($renewal->member->membership_end)->format('M d, Y') 
                                : 'N/A' }}
                        </p>
                    </div>

                    <!-- Right: Renewal Details + Receipt -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b pb-2">Renewal Details</h3>
                        <p><strong>Reference #:</strong> {{ $renewal->reference_number }}</p>
                        <p><strong>Submitted:</strong> 
                            {{ \Carbon\Carbon::parse($renewal->created_at)->format('M d, Y h:i A') }}
                        </p>

                        {{-- Receipt Image --}}
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Receipt Preview:</label>

                            <div class="relative border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-white dark:bg-gray-900 shadow-sm">
                                <img 
                                    src="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                                    alt="Uploaded Receipt Preview" 
                                    class="w-full h-auto max-h-[400px] object-contain"
                                >
                            </div>

                            <a href="{{ asset('images/renewals/' . basename($renewal->receipt_path)) }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline transition">
                                View Full Image
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Assessment Form -->
                <form method="POST" action="{{ route('renew.update', $renewal) }}" class="mt-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Decision -->
                        <div>
                            <x-input-label for="status" :value="__('Decision')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="approved">Approve Renewal</option>
                                <option value="rejected">Reject Renewal</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Remarks -->
                        <div>
                            <x-input-label for="remarks" :value="__('Remarks (Optional)')" />
                            <textarea 
                                id="remarks" 
                                name="remarks" 
                                rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                            >{{ old('remarks') }}</textarea>
                            <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('renew.index') }}" class="inline-flex items-center px-5 py-2 text-white hover:text-red-700 hover:border-red-700 
                                    bg-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-red-600 border border-red-600 font-medium dark:border-red-800 
                                    dark:hover:bg-black dark:hover:border-red-700 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Cancel
                            </a>

                            <x-primary-button>
                                {{ __('Submit Assessment') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
