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
                            <a href="{{ route('renew.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
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
