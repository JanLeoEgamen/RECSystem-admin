<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Update License Information
            </h2>

            <a href="{{ route('licenses.index') }}"  
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Licensed Members
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    <form id="updateLicenseForm" action="{{ route('licenses.update', $member->id) }}" method="post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                            <!-- Member Information Section -->
                            <div class="col-span-1">
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Member Information</h3>
                                </div>
                                
                                <div class="space-y-3 sm:space-y-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Full Name</label>
                                        <div class="mt-2 p-2 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $member->first_name }} {{ $member->last_name }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Membership Type</label>
                                        <div class="mt-2 p-2 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">{{ $member->membershipType->type_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Bureau / Section</label>
                                        <div class="mt-2 p-2 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100">
                                                {{ $member->section->bureau->bureau_name ?? 'N/A' }} <span class="text-gray-400">/</span> {{ $member->section->section_name ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- License Information Section -->
                            <div class="col-span-1">
                                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 shadow-md">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0 0h5a2 2 0 002-2V8a2 2 0 00-2-2h-5m0 0V5a2 2 0 00-2-2h-.5a2 2 0 00-2 2v7m0 0H5" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">License Information</h3>
                                </div>
                                
                                <div class="space-y-3 sm:space-y-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_class" class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">License Class</label>
                                        <input id="license_class" value="{{ old('license_class', $member->license_class) }}" name="license_class" type="text" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                        @error('license_class')
                                        <p class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_number" class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">License Number</label>
                                        <input id="license_number" value="{{ old('license_number', $member->license_number) }}" name="license_number" type="text" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200 font-mono">
                                        @error('license_number')
                                        <p class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="callsign" class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Callsign</label>
                                        <input id="callsign" value="{{ old('callsign', $member->callsign) }}" name="callsign" type="text" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200 font-mono">
                                        @error('callsign')
                                        <p class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <label for="license_expiration_date" class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">License Expiration Date</label>
                                        <input id="license_expiration_date" value="{{ old('license_expiration_date', $member->license_expiration_date ? $member->license_expiration_date->format('Y-m-d') : '') }}" name="license_expiration_date" type="date" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                        @error('license_expiration_date')
                                        <p class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 sm:mt-8">
                            <button type="submit" 
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-amber-600 to-orange-600 
                                    hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-amber-500 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg 
                                    transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Update License
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById("updateLicenseForm").addEventListener("submit", function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to update this license information?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#5e6ffb",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "Cancel",
                    background: '#101966',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Updating...',
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
                    title: "Updated!",
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
</x-app-layout>
