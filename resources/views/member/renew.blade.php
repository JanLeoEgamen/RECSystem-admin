<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            {{ __('Membership Renewal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!auth()->user()->member->is_lifetime_member && 
                        auth()->user()->member->membership_end && 
                        now()->gt(auth()->user()->member->membership_end))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Your membership has expired</p>
                            <p>Please renew your membership to continue enjoying all member benefits.</p>
                        </div>
                    @endif
                    
                    {{-- Add this section to show pending renewal message --}}
                    @if(auth()->user()->member->renewals()->where('status', 'pending')->exists())
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Renewal Request in Progress</p>
                            <p>Your membership renewal request is currently being processed. Please wait for confirmation.</p>
                        </div>
                    @else
                        {{-- Only show the form if there are no pending renewals --}}
                        <form method="POST" action="{{ route('renew.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                <!-- Reference Number -->
                                <div>
                                    <x-input-label for="reference_number" :value="__('Reference Number')" />
                                    <x-text-input id="reference_number" class="block mt-1 w-full" type="text" 
                                        name="reference_number" :value="old('reference_number')" required autofocus />
                                    <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                                </div>

                                <!-- Receipt Upload -->
                                <div>
                                    <x-input-label for="receipt" :value="__('Upload Payment Receipt')" />
                                    <input 
                                        type="file" 
                                        id="receipt" 
                                        name="receipt" 
                                        accept="image/*" 
                                        required
                                        class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100
                                            dark:file:bg-gray-700 dark:file:text-gray-300
                                            dark:hover:file:bg-gray-600"
                                    >
                                    <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload a clear image of your payment receipt (max: 2MB)</p>
                                </div>
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('member.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Cancel
                                    </a>

                                    <x-primary-button>
                                        {{ __('Submit Renewal Request') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>