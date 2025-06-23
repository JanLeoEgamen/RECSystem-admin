<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            Assess Renewal Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium mb-2">Member Information</h3>
                            <p><strong>Name:</strong> {{ $renewal->member->user->name }}</p>
                            <p><strong>Membership ID:</strong> {{ $renewal->member->rec_number }}</p>
                            <p>
                            <strong>Current Membership End:</strong>
                            {{ $renewal->member->membership_end 
                                ? \Carbon\Carbon::parse($renewal->member->membership_end)->format('M d, Y') 
                                : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-2">Renewal Details</h3>
                            <p><strong>Reference #:</strong> {{ $renewal->reference_number }}</p>
                            <p><strong>Submitted:</strong> 
                                {{ \Carbon\Carbon::parse($renewal->created_at)->format('M d, Y h:i A') }}
                            </p>
                            <p><strong>Receipt:</strong> 
                                <a href="{{ Storage::url($renewal->receipt_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    View Receipt
                                </a>
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('renew.update', $renewal) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Status -->
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

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('renew.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
    </div>
</x-app-layout>