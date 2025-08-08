<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">
            
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                My Membership Details
            </h2>

            <a href="{{ route('member.dashboard') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">First Name</p>
                                    <p class="mt-1">{{ $member->first_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Middle Name</p>
                                    <p class="mt-1">{{ $member->middle_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Last Name</p>
                                    <p class="mt-1">{{ $member->last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Suffix</p>
                                    <p class="mt-1">{{ $member->suffix ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Sex</p>
                                    <p class="mt-1">{{ $member->sex }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Birthdate</p>
                                    <p class="mt-1">{{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Civil Status</p>
                                    <p class="mt-1">{{ $member->civil_status }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Citizenship</p>
                                    <p class="mt-1">{{ $member->citizenship }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Blood Type</p>
                                    <p class="mt-1">{{ $member->blood_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Contact Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Cellphone No.</p>
                                    <p class="mt-1">{{ $member->cellphone_no }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Telephone No.</p>
                                    <p class="mt-1">{{ $member->telephone_no ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email Address</p>
                                    <p class="mt-1">{{ $member->email_address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Emergency Contact</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="mt-1">{{ $member->emergency_contact }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Contact No.</p>
                                    <p class="mt-1">{{ $member->emergency_contact_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Relationship</p>
                                    <p class="mt-1">{{ $member->relationship }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Membership Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Membership Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Record Number</p>
                                    <p class="mt-1">{{ $member->rec_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Membership Type</p>
                                    <p class="mt-1">{{ $member->membershipType->type_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Section</p>
                                    <p class="mt-1">{{ $member->section->section_name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Membership Start</p>
                                    <p class="mt-1">{{ $member->membership_start ? \Carbon\Carbon::parse($member->membership_start)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Membership End</p>
                                    <p class="mt-1">{{ $member->membership_end ? \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') : ($member->is_lifetime_member ? 'Lifetime' : 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Lifetime Member</p>
                                    <p class="mt-1">{{ $member->is_lifetime_member ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Last Renewal Date</p>
                                <p class="mt-1">{{ $member->last_renewal_date ? \Carbon\Carbon::parse($member->last_renewal_date)->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="mt-1">{{ $member->status ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- License Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">License Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">License Class</p>
                                    <p class="mt-1">{{ $member->license_class ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">License Number</p>
                                    <p class="mt-1">{{ $member->license_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Callsign</p>
                                    <p class="mt-1">{{ $member->callsign ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Expiration Date</p>
                                    <p class="mt-1">{{ $member->license_expiration_date ? \Carbon\Carbon::parse($member->license_expiration_date)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">House/Building No./Name</p>
                                    <p class="mt-1">{{ $member->house_building_number_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Street Address</p>
                                    <p class="mt-1">{{ $member->street_address }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Region</p>
                                    <p class="mt-1">{{ $regionName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Province</p>
                                    <p class="mt-1">{{ $provinceName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Municipality</p>
                                    <p class="mt-1">{{ $municipalityName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Barangay</p>
                                    <p class="mt-1">{{ $barangayName }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Zip Code</p>
                                <p class="mt-1">{{ $member->zip_code }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit button if needed -->
                    <div class="mt-6">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-md transition-colors duration-200 border border-indigo-100 hover:border-indigo-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Request Information Update
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>