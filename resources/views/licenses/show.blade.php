<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('License Details') }}
            </h2>
            <a href="{{ route('licenses.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Licensed Members
            </a>                
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Member Information -->
                        <div class="space-y-4">
                            <h3 class="text-2xl font-semibold border-b pb-2">Member Information</h3>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</p>
                                <p class="mt-1">{{ $member->first_name }} {{ $member->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Membership Type</p>
                                <p class="mt-1">{{ $member->membershipType->type_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bureau/Section</p>
                                <p class="mt-1">
                                    {{ $member->section->bureau->bureau_name ?? 'N/A' }} / 
                                    {{ $member->section->section_name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- License Information -->
                        <div class="space-y-4">
                            <h3 class="text-2xl font-semibold border-b pb-2">License Information</h3>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">License Class</p>
                                <p class="mt-1">{{ $member->license_class ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">License Number</p>
                                <p class="mt-1">{{ $member->license_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Callsign</p>
                                <p class="mt-1">{{ $member->callsign ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Expiration Date</p>
                                <p class="mt-1 {{ \Carbon\Carbon::parse($member->license_expiration_date)->isPast() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $member->license_expiration_date ? \Carbon\Carbon::parse($member->license_expiration_date)->format('M d, Y') : 'N/A' }}
                                    @if($member->license_expiration_date && \Carbon\Carbon::parse($member->license_expiration_date)->isPast())
                                        (Expired)
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">

                        @can('edit licenses')
                        <a href="{{ route('licenses.edit', $member->id) }}" class="flex items-center px-4 py-2 text-sm text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-md transition-colors duration-200 border border-indigo-100 hover:border-indigo-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        @endcan

                        @can('delete licenses')
                        <form action="{{ route('licenses.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $member->id }}">
                            <button type="submit" class="flex items-center px-4 py-2 text-sm text-red-600 hover:text-white hover:bg-red-600 rounded-md transition-colors duration-200 border border-red-100 hover:border-red-600 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                        @endcan

                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>w