<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('License Details') }}
            </h2>

            <a href="{{ route('licenses.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Licensed Members
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                        <!-- Member Information Card -->
                        <div class="col-span-1">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Member Information</h3>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Full Name</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $member->first_name }} {{ $member->last_name }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Membership Type</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $member->membershipType->type_name ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Bureau / Section</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $member->section->bureau->bureau_name ?? 'N/A' }} <span class="text-gray-400">/</span> {{ $member->section->section_name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- License Information Card -->
                        <div class="col-span-1">
                            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0 0h5a2 2 0 002-2V8a2 2 0 00-2-2h-5m0 0V5a2 2 0 00-2-2h-.5a2 2 0 00-2 2v7m0 0H5" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">License Information</h3>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">License Class</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $member->license_class ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">License Number</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100 font-mono">{{ $member->license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Callsign</p>
                                    <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100 font-mono">{{ $member->callsign ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Expiration Date</p>
                                    <p class="text-sm sm:text-base font-medium {{ \Carbon\Carbon::parse($member->license_expiration_date)->isPast() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $member->license_expiration_date ? \Carbon\Carbon::parse($member->license_expiration_date)->format('M d, Y') : 'N/A' }}
                                        @if($member->license_expiration_date && \Carbon\Carbon::parse($member->license_expiration_date)->isPast())
                                            <span class="text-xs font-bold ml-2 px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30">(Expired)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-3 sm:flex-nowrap">
                        @can('edit licenses')
                        <a href="{{ route('licenses.edit', $member->id) }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-indigo-600 to-purple-600 
                                hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                focus:ring-indigo-500 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg 
                                transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit License
                        </a>
                        @endcan

                        @can('delete licenses')
                        <form action="{{ route('licenses.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');" class="inline w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $member->id }}">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-red-600 to-pink-600 
                                    hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-red-600 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg 
                                    transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete License
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>w