<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Update License Information
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
                    <form action="{{ route('licenses.update', $member->id) }}" method="post">
                        @csrf
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- License Information -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-medium">License Information</h3>
                                    
                                    <div>
                                        <label for="license_class" class="block text-sm font-medium">License Class</label>
                                        <input value="{{ old('license_class', $member->license_class) }}" name="license_class" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('license_class')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="license_number" class="block text-sm font-medium">License Number</label>
                                        <input value="{{ old('license_number', $member->license_number) }}" name="license_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('license_number')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="license_expiration_date" class="block text-sm font-medium">License Expiration Date</label>
                                        <input value="{{ old('license_expiration_date', $member->license_expiration_date ? $member->license_expiration_date->format('Y-m-d') : '') }}" name="license_expiration_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('license_expiration_date')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="callsign" class="block text-sm font-medium">Callsign</label>
                                        <input value="{{ old('callsign', $member->callsign) }}" name="callsign" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('callsign')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Member Information (Readonly) -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-medium">Member Information</h3>
                                    
                                    <div>
                                        <label class="block text-sm font-medium">Name</label>
                                        <div class="mt-1 p-2 bg-gray-100 rounded-md">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Membership Type</label>
                                        <div class="mt-1 p-2 bg-gray-100 rounded-md">
                                            {{ $member->membershipType->type_name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Bureau/Section</label>
                                        <div class="mt-1 p-2 bg-gray-100 rounded-md">
                                            {{ $member->section->bureau->bureau_name ?? 'N/A' }} / {{ $member->section->section_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update License
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>