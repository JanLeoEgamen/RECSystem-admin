<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Student Applicant / View
            </h2>
            <a href="{{ route('student-applicants.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Student Applicants
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
                                    <p class="mt-1">{{ $applicant->first_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Middle Name</p>
                                    <p class="mt-1">{{ $applicant->middle_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Last Name</p>
                                    <p class="mt-1">{{ $applicant->last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Suffix</p>
                                    <p class="mt-1">{{ $applicant->suffix ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Sex</p>
                                    <p class="mt-1">{{ $applicant->sex }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Birthdate</p>
                                    <p class="mt-1">{{ $applicant->birthdate ? \Carbon\Carbon::parse($applicant->birthdate)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Civil Status</p>
                                    <p class="mt-1">{{ $applicant->civil_status }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Citizenship</p>
                                    <p class="mt-1">{{ $applicant->citizenship }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Blood Type</p>
                                    <p class="mt-1">{{ $applicant->blood_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Student Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Student Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Student Number</p>
                                    <p class="mt-1">{{ $applicant->student_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">School/University</p>
                                    <p class="mt-1">{{ $applicant->school ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Program/Course</p>
                                    <p class="mt-1">{{ $applicant->program ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Year Level</p>
                                    <p class="mt-1">{{ $applicant->year_level ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Contact Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Cellphone No.</p>
                                    <p class="mt-1">{{ $applicant->cellphone_no }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Telephone No.</p>
                                    <p class="mt-1">{{ $applicant->telephone_no ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email Address</p>
                                    <p class="mt-1">{{ $applicant->email_address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Emergency Contact</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="mt-1">{{ $applicant->emergency_contact }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Contact No.</p>
                                    <p class="mt-1">{{ $applicant->emergency_contact_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Relationship</p>
                                    <p class="mt-1">{{ $applicant->relationship }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- License Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">License Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">License Class</p>
                                    <p class="mt-1">{{ $applicant->license_class ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">License Number</p>
                                    <p class="mt-1">{{ $applicant->license_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Callsign</p>
                                    <p class="mt-1">{{ $applicant->callsign ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Expiration Date</p>
                                    <p class="mt-1">{{ $applicant->license_expiration_date ? \Carbon\Carbon::parse($applicant->license_expiration_date)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">House/Building No./Name</p>
                                    <p class="mt-1">{{ $applicant->house_building_number_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Street Address</p>
                                    <p class="mt-1">{{ $applicant->street_address }}</p>
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
                                <p class="mt-1">{{ $applicant->zip_code }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex flex-wrap gap-3">
                        @can('assess student applicants')
                        <a href="{{ route('student-applicants.assess', $applicant->id) }}" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Assess
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Success!",
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
    </script>
</x-app-layout>