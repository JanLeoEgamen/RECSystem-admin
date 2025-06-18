<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            {{ __('Applicant Dashboard') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Application Form Section -->
                <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8 transition-colors duration-300">
                    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-8">
                        <div class="w-56 hidden md:block sticky top-8 h-[calc(100vh-4rem)]">
                            <div class="relative h-full">
                                <div class="absolute left-7 top-0 w-1 h-full bg-gray-300 dark:bg-gray-600 overflow-hidden">
                                    <div id="progress-line" class="absolute top-0 left-0 w-full h-0 bg-blue-600 transition-all duration-500"></div>
                                </div>
                                <div class="flex flex-col h-full justify-between py-8">
                                    <div class="flex items-center group cursor-pointer" onclick="scrollToSection('personal-info')">
                                        <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center z-10 transition-all duration-300 group-hover:bg-blue-700">
                                            <span class="text-white font-bold text-lg">1</span>
                                        </div>
                                        <div class="ml-4 text-gray-900 dark:text-white font-medium transition-colors duration-300">Personal Information</div>
                                    </div>
                                    <div class="flex items-center group cursor-pointer" onclick="scrollToSection('contact-info')">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center z-10 transition-all duration-300 group-hover:bg-gray-300 dark:group-hover:bg-gray-600">
                                            <span class="text-gray-600 dark:text-gray-400 font-bold text-lg">2</span>
                                        </div>
                                        <div class="ml-4 text-gray-600 dark:text-gray-400 transition-colors duration-300">Contact Information</div>
                                    </div>
                                    <div class="flex items-center group cursor-pointer" onclick="scrollToSection('emergency-contact')">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center z-10 transition-all duration-300 group-hover:bg-gray-300 dark:group-hover:bg-gray-600">
                                            <span class="text-gray-600 dark:text-gray-400 font-bold text-lg">3</span>
                                        </div>
                                        <div class="ml-4 text-gray-600 dark:text-gray-400 transition-colors duration-300">Emergency Contact</div>
                                    </div>
                                    <div class="flex items-center group cursor-pointer" onclick="scrollToSection('address-info')">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center z-10 transition-all duration-300 group-hover:bg-gray-300 dark:group-hover:bg-gray-600">
                                            <span class="text-gray-600 dark:text-gray-400 font-bold text-lg">4</span>
                                        </div>
                                        <div class="ml-4 text-gray-600 dark:text-gray-400 transition-colors duration-300">Address Information</div>
                                    </div>
                                    <div id="license-step" class="flex items-center group cursor-pointer" onclick="scrollToSection('license-info')" style="display: none;">
                                        <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center z-10 transition-all duration-300 group-hover:bg-gray-300 dark:group-hover:bg-gray-600">
                                            <span class="text-gray-600 dark:text-gray-400 font-bold text-lg">5</span>
                                        </div>
                                        <div class="ml-4 text-gray-600 dark:text-gray-400 transition-colors duration-300">License Information</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Container -->
                        <div class="flex-1 bg-white dark:bg-gray-900 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-lg">
                            <!-- Form Header -->
                            <div class="bg-[#101966] dark:bg-blue-800 px-8 py-6 transition-colors duration-300">
                                <h2 class="text-2xl font-bold text-white">Application Form</h2>
                                <p class="text-blue-100 dark:text-blue-200 transition-colors duration-300">Please fill out all required fields</p>
                            </div>
                            
                            <!-- Form Content -->
                            <form class="px-8 py-6 space-y-8" method="POST" action="{{ route('applicant.store') }}" enctype="multipart/form-data" id="applicationForm">
                                @csrf
                                <!-- Personal Information Section -->
                                <div id="personal-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 rounded-full p-3 mr-4 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </span>
                                        Personal Information
                                    </h3>
                        
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="col-span-1">
                                            <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">First Name *</label>
                                            <input type="text" id="firstName" name="firstName" required placeholder="e.g. Juan" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                        <div class="col-span-1">
                                            <label for="middleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Middle Name</label>
                                            <input type="text" id="middleName" name="middleName" placeholder="e.g. De la" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                        <div class="col-span-1">
                                            <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Last Name *</label>
                                            <input type="text" id="lastName" name="lastName" required placeholder="e.g. Cruz" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                    </div>
                        
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                        <div class="col-span-1">
                                            <label for="suffix" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Suffix</label>
                                            <select id="suffix" name="suffix" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">None</option>
                                                <option value="Jr">Jr</option>
                                                <option value="Sr">Sr</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                            </select>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Sex *</label>
                                            <select id="sex" name="sex" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Birthdate *</label>
                                            <input type="date" name="date" id="birthdate" required 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                    </div>
                        
                        
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                        <div class="col-span-1">
                                            <label for="civilStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Civil Status *</label>
                                            <select id="civilStatus" name="civilStatus" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-span-1">
                                            <label for="bloodType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Blood Type</label>
                                            <select id="bloodType" name="bloodType" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-span-1">
                                            <label for="citizenship" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Citizenship *</label>
                                            <input type="text" id="citizenship" name="citizenship" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200" 
                                            placeholder="e.g. Filipino">
                                        </div>
                                    </div>
                        
                                    <!-- Checkboxes -->
                                    <div class="mt-4">
                                        <div class="flex flex-col space-y-4">
                                            <!-- Student Checkbox -->
                                            <div class="relative flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="isStudent" name="isStudent" type="checkbox" 
                                                        class="focus:ring-blue-500 h-6 w-6 text-blue-600 border-gray-300 rounded transition-colors duration-300 dark:bg-gray-700 dark:border-gray-600">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="isStudent" class="font-medium text-gray-700 dark:text-gray-300">Applying as a student?</label>
                                                    <p class="text-gray-500 dark:text-gray-400">Check this if you're currently enrolled in an educational institution.</p>
                                                </div>
                                            </div>
                                    
                                            <!-- License Checkbox -->
                                            <div class="relative flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="hasLicense" name="hasLicense" type="checkbox" 
                                                        class="focus:ring-blue-500 h-6 w-6 text-blue-600 border-gray-300 rounded transition-colors duration-300 dark:bg-gray-700 dark:border-gray-600">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="hasLicense" class="font-medium text-gray-700 dark:text-gray-300">Do you have a professional license?</label>
                                                    <p class="text-gray-500 dark:text-gray-400">Check this if you hold a valid professional license.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <!-- Contact Information Section -->
                                <div id="contact-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                                        <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100 rounded-full p-3 mr-4 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        Contact Information
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Email Address *</label>
                                            <input type="email" id="email" name="email" required placeholder="your.email@gmail.com" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                                oninput="validateEmail(this)">
                                            <p id="emailError" class="mt-1 text-sm text-red-600 hidden">Please enter a valid Gmail address (e.g. example@gmail.com)</p>
                                        </div>
                                        <div>
                                            <label for="cellphone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Cellphone No. *</label>
                                            <input type="tel" id="cellphone" name="cellphone" required placeholder="e.g. 09171234567" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                                maxlength="11"
                                                oninput="validatePhoneNumber(this, 'cellphoneError')">
                                            <p id="cellphoneError" class="mt-1 text-sm text-red-600 hidden">Please enter a valid 11-digit phone number (e.g. 09171234567)</p>
                                        </div>
                                        <div>
                                            <label for="telephone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Telephone No.</label>
                                            <input type="tel" id="telephone" name="telephone" placeholder="e.g. 2-XXXX-XXXX" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Emergency Contact Section -->
                                <div id="emergency-contact" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                                        <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100 rounded-full p-3 mr-4 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </span>
                                        Emergency Contact
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="col-span-1">
                                            <label for="emergencyName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Full Name *</label>
                                            <input type="text" id="emergencyName" name="emergencyName" required placeholder="e.g. Maria De la Cruz" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                                oninput="validateFullName(this)">
                                            <p id="emergencyNameError" class="mt-1 text-sm text-red-600 hidden">Please enter both first and last name</p>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="emergencyContact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Contact No. *</label>
                                            <input type="tel" id="emergencyContact" name="emergencyContact" required placeholder="e.g. 09171234567" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                                maxlength="11"
                                                oninput="validatePhoneNumber(this, 'emergencyContactError')">
                                            <p id="emergencyContactError" class="mt-1 text-sm text-red-600 hidden">Please enter a valid 11-digit phone number (e.g. 09171234567)</p>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="emergencyRelationship" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Relationship *</label>
                                            <select id="emergencyRelationship" name="emergencyRelationship" required
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="" disabled selected>Select relationship</option>
                                                <option value="Father">Father</option>
                                                <option value="Mother">Mother</option>
                                                <option value="Spouse">Spouse</option>
                                                <!-- Other options as above -->
                                                <option value="Others">Others (please specify)</option>
                                            </select>
                                            <div id="otherRelationshipContainer" class="mt-2 hidden">
                                                <input type="text" id="otherRelationship" name="otherRelationship" placeholder="Please specify relationship"
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                            </div>
                                        </div>       
                                    </div>
                                </div>

                                <!-- Address Information Section -->
                                <div id="address-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 rounded-full p-3 mr-4 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        Address Information
                                    </h3>
                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="houseNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">House/Building No./Name *</label>
                                            <input type="text" id="houseNumber" name="houseNumber" required placeholder="e.g. Blk/Lot" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                        <div>
                                            <label for="streetAddress" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Street Address *</label>
                                            <input type="text" id="streetAddress" name="streetAddress" required placeholder="e.g. Acacia St." 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                    </div>
                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                        <div>
                                            <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Region *</label>
                                            <select id="region" name="region" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->psgc_reg_code }}">{{ $region->psgc_reg_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                        <div>
                                            <label for="province" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Province *</label>
                                            <select id="province" name="province" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <!-- Provinces loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                    
                                        <div>
                                            <label for="municipality" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Municipality *</label>
                                            <select id="municipality" name="municipality" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <!-- Municipalities loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                    
                                        <div>
                                            <label for="barangay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Barangay *</label>
                                            <select id="barangay" name="barangay" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                                <option value="">Select</option>
                                                <!-- Barangays loaded dynamically via AJAX -->
                                            </select>
                                        </div>
                                    </div>
                    
                                    <div class="mt-4 w-1/4">
                                        <label for="zipCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Zip Code *</label>
                                        <input type="text" id="zipCode" name="zipCode" required placeholder="1000" 
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                    </div>
                                </div>

                                <!-- License Information Section (conditionally shown) -->
                                <div id="license-info" style="display: none;">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                                        <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100 rounded-full p-3 mr-4 transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </span>
                                        License Information
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="licenseClass" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">License Class *</label>
                                            <input type="text" id="licenseClass" name="licenseClass" required placeholder="e.g. Class A" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                        <div>
                                            <label for="licenseNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">License Number *</label>
                                            <input type="text" id="licenseNumber" name="licenseNumber" required placeholder="e.g. A01-23-456789" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                        <div>
                                            <label for="expirationDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Expiration Date *</label>
                                            <input type="date" id="expirationDate" name="expirationDate" required 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-center sm:justify-end mt-8">
                                    <button type="button" id="proceedToPaymentBtn" class="inline-flex items-center justify-center px-8 py-3 text-sm font-medium bg-[#101966] text-white border border-[#101966] rounded-lg 
                                    hover:bg-white hover:text-blue-600 hover:border-blue-600 dark:hover:bg-gray-900 dark:hover:text-gray-200 
                                    transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        Proceed to Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Payment Overlay -->
                <div id="paymentOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-8">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Application Review & Payment</h3>
                                    <button id="closeOverlayBtn" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            
                                <!-- Application Summary -->
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Application Summary</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Personal Info Summary -->
                                        <div>
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Personal Information
                                            </h5>
                                            <div class="space-y-2">
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Name:</span> <span id="summary-name" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Birthdate:</span> <span id="summary-birthdate" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Sex:</span> <span id="summary-sex" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Civil Status:</span> <span id="summary-civilStatus" class="text-gray-900 dark:text-white"></span></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Contact Info Summary -->
                                        <div>
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Contact Information
                                            </h5>
                                            <div class="space-y-2">
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Email:</span> <span id="summary-email" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Cellphone:</span> <span id="summary-cellphone" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Emergency Contact:</span> <span id="summary-emergencyContact" class="text-gray-900 dark:text-white"></span></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Address Info Summary -->
                                        <div class="md:col-span-2">
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Address Information
                                            </h5>
                                            <div class="space-y-2">
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Address:</span> <span id="summary-address" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Region:</span> <span id="summary-region" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Province:</span> <span id="summary-province" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Municipality:</span> <span id="summary-municipality" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Barangay:</span> <span id="summary-barangay" class="text-gray-900 dark:text-white"></span></p>
                                                <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Zip Code:</span> <span id="summary-zipCode" class="text-gray-900 dark:text-white"></span></p>
                                            </div>
                                        </div>

                                        <!-- License Info Summary -->
                                        <div id="license-summary-container">
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                License Information
                                            </h5>
                                            <div id="summary-license" class="space-y-2">
                                                <!-- Dynamically populated -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Instructions -->
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Payment Instructions</h4>
                                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 mb-4">
                                        <p class="text-sm text-blue-800 dark:text-blue-200">Please upload proof of payment after completing your transaction.</p>
                                    </div>
                                    
                                    <div class="flex flex-col md:flex-row gap-6 items-start">
                                        <!-- QR Code Image Container (Left Side) -->
                                        <div class="flex flex-col items-center">
                                            <div class="border border-gray-200 dark:border-gray-700 p-2 rounded-lg relative" style="width: 250px;">
                                                <img src="/images/gcash.jpg" alt="GCash Payment QR Code" class="w-full h-auto" id="qrCodeImage">
                                                <button onclick="zoomQRCode()" class="absolute bottom-2 right-2 bg-blue-600 text-white p-1 rounded-full hover:bg-blue-700 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <button onclick="zoomQRCode()" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">Click to enlarge</button>
                                        </div>
                                        
                                        <!-- Payment Details (Right Side) -->
                                        <div class="flex-1">
                                            <div class="space-y-4">
                                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                    <h5 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Payment Details</h5>
                                                    <div class="space-y-3">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Amount to Pay:</p>
                                                            <p class="text-lg font-bold text-gray-900 dark:text-white">₱500.00</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">GCash Account Name:</p>
                                                            <p class="text-base text-gray-900 dark:text-white">Your Organization Name</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">GCash Number:</p>
                                                            <p class="text-base text-gray-900 dark:text-white">0912 345 6789</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                                    <h5 class="font-medium text-yellow-800 dark:text-yellow-200 mb-2 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        Important Notes
                                                    </h5>
                                                    <ul class="text-sm text-gray-700 dark:text-gray-300 list-disc pl-5 space-y-1">
                                                        <li>Scan the QR code to pay</li>
                                                        <li>Save your transaction receipt</li>
                                                        <li>Enter the reference number below</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Upload Payment Section -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Upload Payment Proof</h4>
                                    
                                    <!-- File Upload -->
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Receipt or Proof of Payment *</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                    <label for="paymentProof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Upload a file</span>
                                                        <input id="paymentProof" name="paymentProof" type="file" class="sr-only" required>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    PNG, JPG, PDF up to 5MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reference Number Input -->
                                    <div class="mt-4">
                                        <label for="referenceNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number *</label>
                                        <input type="text" id="referenceNumber" name="referenceNumber" placeholder="Input GCash ref number" required
                                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400">
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Submit Payment Proof
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Zoom Modal -->
                <div id="qrZoomModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full p-4">
                        <button onclick="closeZoom()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <img src="/images/gcash.jpg" alt="GCash Payment QR Code (Zoomed)" class="w-full h-auto max-h-[80vh]">
                    </div>
                </div>

                <!-- NOTE THAT THERE ARE 2 SEPARATE SCRIPTS -->
                <!-- SCRIPT FOR THE APPLICATION FORM (NOT FOR THE OVERLAY) -->                                                   
                <script>
                document.getElementById('emergencyRelationship').addEventListener('change', function() {
                        const otherContainer = document.getElementById('otherRelationshipContainer');
                        
                        if (this.value === 'Others') {
                            otherContainer.classList.remove('hidden');
                            document.getElementById('otherRelationship').setAttribute('required', 'required');
                        } else {
                            otherContainer.classList.add('hidden');
                            document.getElementById('otherRelationship').removeAttribute('required');
                        }
                    });

                // Validate email (must be Gmail)
                function validateEmail(input) {
                    const errorElement = document.getElementById('emailError');
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
                    
                    if (!emailRegex.test(input.value)) {
                        input.classList.add('border-red-500');
                        errorElement.classList.remove('hidden');
                        return false;
                    } else {
                        input.classList.remove('border-red-500');
                        errorElement.classList.add('hidden');
                        return true;
                    }
                }

                // Validate full name (at least first name and last name)
                function validateFullName(input) {
                    const errorElement = document.getElementById('emergencyNameError');
                    const nameParts = input.value.trim().split(/\s+/);
                    
                    if (nameParts.length < 2) {
                        input.classList.add('border-red-500');
                        errorElement.classList.remove('hidden');
                        return false;
                    } else {
                        input.classList.remove('border-red-500');
                        errorElement.classList.add('hidden');
                        return true;
                    }
                }

                // Validate phone number (only digits, 11 characters)
                function validatePhoneNumber(input, errorId) {
                    const errorElement = document.getElementById(errorId);
                    // Remove all non-digit characters
                    input.value = input.value.replace(/\D/g, '');
                    
                    if (input.value.length !== 11 || !input.value.startsWith('09')) {
                        input.classList.add('border-red-500');
                        errorElement.classList.remove('hidden');
                        return false;
                    } else {
                        input.classList.remove('border-red-500');
                        errorElement.classList.add('hidden');
                        return true;
                    }
                }

                // Add form submission validation
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('form');
                    
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const emailValid = validateEmail(document.getElementById('email'));
                            const cellphoneValid = validatePhoneNumber(document.getElementById('cellphone'), 'cellphoneError');
                            const nameValid = validateFullName(document.getElementById('emergencyName'));
                            const emergencyContactValid = validatePhoneNumber(document.getElementById('emergencyContact'), 'emergencyContactError');
                            
                            if (!emailValid || !cellphoneValid || !nameValid || !emergencyContactValid) {
                                e.preventDefault();
                                // Scroll to the first error
                                const firstInvalid = [
                                    !emailValid ? 'email' : null,
                                    !cellphoneValid ? 'cellphone' : null,
                                    !nameValid ? 'emergencyName' : null,
                                    !emergencyContactValid ? 'emergencyContact' : null
                                ].find(id => id !== null);
                                
                                if (firstInvalid) {
                                    document.getElementById(firstInvalid).scrollIntoView({ 
                                        behavior: 'smooth', 
                                        block: 'center' 
                                    });
                                }
                            }
                        });
                    }
                });
                </script>

                <!-- SCRIPT FOR THE OVERLAY RECIEPT -->
                <!-- Include necessary scripts -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    // These functions are now globally accessible
                    function zoomQRCode() {
                        document.getElementById('qrZoomModal').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }

                    function closeZoom() {
                        document.getElementById('qrZoomModal').classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }

                    $(document).ready(function() {
                        // Address dropdown functionality
                        $('#region').on('change', function() {
                            let regionCode = $(this).val();

                            $('#province').html('<option value="">Select</option>');
                            $('#municipality').html('<option value="">Select</option>');
                            $('#barangay').html('<option value="">Select</option>');

                            if(regionCode) {
                                $.ajax({
                                    url: '/get-provinces/' + regionCode,
                                    type: 'GET',
                                    success: function(provinces) {
                                        provinces.forEach(function(prov) {
                                            $('#province').append('<option value="'+prov.psgc_prov_code+'">'+prov.psgc_prov_desc+'</option>');
                                        });
                                    }
                                });
                            }
                        });

                        $('#province').on('change', function() {
                            let regionCode = $('#region').val();
                            let provinceCode = $(this).val();

                            $('#municipality').html('<option value="">Select</option>');
                            $('#barangay').html('<option value="">Select</option>');

                            if(regionCode && provinceCode) {
                                $.ajax({
                                    url: '/get-municipalities/' + regionCode + '/' + provinceCode,
                                    type: 'GET',
                                    success: function(municipalities) {
                                        municipalities.forEach(function(muni) {
                                            $('#municipality').append('<option value="'+muni.psgc_munc_code+'">'+muni.psgc_munc_desc+'</option>');
                                        });
                                    }
                                });
                            }
                        });

                        $('#municipality').on('change', function() {
                            let regionCode = $('#region').val();
                            let provinceCode = $('#province').val();
                            let municipalityCode = $(this).val();

                            $('#barangay').html('<option value="">Select</option>');

                            if(regionCode && provinceCode && municipalityCode) {
                                $.ajax({
                                    url: '/get-barangays/' + regionCode + '/' + provinceCode + '/' + municipalityCode,
                                    type: 'GET',
                                    success: function(barangays) {
                                        barangays.forEach(function(brgy) {
                                            $('#barangay').append('<option value="'+brgy.psgc_brgy_code+'">'+brgy.psgc_brgy_desc+'</option>');
                                        });
                                    }
                                });
                            }
                        });

                        // Show/hide license section based on checkbox
                        $('#hasLicense').change(function() {
                            const licenseSection = $('#license-info');
                            if (this.checked) {
                                licenseSection.show();
                                $('#licenseClass, #licenseNumber, #expirationDate').prop('required', true);
                                $('#license-step').show();
                            } else {
                                licenseSection.hide();
                                $('#licenseClass, #licenseNumber, #expirationDate').prop('required', false);
                                $('#license-step').hide();
                            }
                        });

                        // Proceed to Payment button click handler
                        $('#proceedToPaymentBtn').click(function(e) {
                            e.preventDefault();
                            
                            // Validate form first
                            const emailValid = validateEmail(document.getElementById('email'));
                            const cellphoneValid = validatePhoneNumber(document.getElementById('cellphone'), 'cellphoneError');
                            const nameValid = validateFullName(document.getElementById('emergencyName'));
                            const emergencyContactValid = validatePhoneNumber(document.getElementById('emergencyContact'), 'emergencyContactError');
                            
                            if (!emailValid || !cellphoneValid || !nameValid || !emergencyContactValid) {
                                // Scroll to the first error
                                const firstInvalid = [
                                    !emailValid ? 'email' : null,
                                    !cellphoneValid ? 'cellphone' : null,
                                    !nameValid ? 'emergencyName' : null,
                                    !emergencyContactValid ? 'emergencyContact' : null
                                ].find(id => id !== null);
                                
                                if (firstInvalid) {
                                    document.getElementById(firstInvalid).scrollIntoView({ 
                                        behavior: 'smooth', 
                                        block: 'center' 
                                    });
                                }
                                return;
                            }
                            
                            // Populate the summary in the overlay
                            populateSummary();
                            
                            // Show the overlay and disable body scroll
                            $('#paymentOverlay').removeClass('hidden');
                            $('body').addClass('overflow-hidden');
                        });

                        // Close overlay button
                        $('#closeOverlayBtn').click(function() {
                            $('#paymentOverlay').addClass('hidden');
                            $('body').removeClass('overflow-hidden');
                        });
                        
                        // Function to populate the summary in the overlay
                        function populateSummary() {
                            // Personal Info
                            const firstName = $('#firstName').val();
                            const middleName = $('#middleName').val();
                            const lastName = $('#lastName').val();
                            const suffix = $('#suffix').val();
                            
                            let fullName = firstName;
                            if (middleName) fullName += ' ' + middleName;
                            fullName += ' ' + lastName;
                            if (suffix) fullName += ' ' + suffix;
                            
                            $('#summary-name').text(fullName);
                            $('#summary-birthdate').text($('#birthdate').val());
                            $('#summary-sex').text($('#sex').val());
                            $('#summary-civilStatus').text($('#civilStatus').val());
                            
                            // Contact Info
                            $('#summary-email').text($('#email').val());
                            $('#summary-cellphone').text($('#cellphone').val());
                            $('#summary-emergencyContact').text(
                                $('#emergencyName').val() + ' (' + $('#emergencyContact').val() + ')'
                            );
                            
                            // Address Info
                            $('#summary-address').text(
                                $('#houseNumber').val() + ', ' + $('#streetAddress').val()
                            );
                            $('#summary-region').text($('#region option:selected').text());
                            $('#summary-province').text($('#province option:selected').text());
                            $('#summary-municipality').text($('#municipality option:selected').text());
                            $('#summary-barangay').text($('#barangay option:selected').text());
                            $('#summary-zipCode').text($('#zipCode').val());

                            // License Info (if applicable)
                            if ($('#hasLicense').is(':checked')) {
                                $('#summary-license').html(`
                                    <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">License Class:</span> <span class="text-gray-900 dark:text-white">${$('#licenseClass').val()}</span></p>
                                    <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">License Number:</span> <span class="text-gray-900 dark:text-white">${$('#licenseNumber').val()}</span></p>
                                    <p class="text-sm"><span class="font-medium text-gray-600 dark:text-gray-400">Expiration Date:</span> <span class="text-gray-900 dark:text-white">${$('#expirationDate').val()}</span></p>
                                `);
                            } else {
                                $('#summary-license').html('<p class="text-sm text-gray-500 dark:text-gray-400">No professional license provided</p>');
                            }
                        }
                    });

                    // Function to scroll to a specific section
                    function scrollToSection(sectionId) {
                        const section = document.getElementById(sectionId);
                        if (section) {
                            window.scrollTo({
                                top: section.offsetTop - 20,
                                behavior: 'smooth'
                            });
                        }
                    }
                </script>

                <style>
                /* Animation styles for notifications */
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                @keyframes fade-out {
                    from {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    to {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
                }

                .animate-fade-in {
                    animation: fade-in 0.3s ease-out forwards;
                }

                .animate-fade-out {
                    animation: fade-out 0.3s ease-out forwards;
                }
                </style>
</x-app-layout>