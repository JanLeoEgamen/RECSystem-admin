<x-app-layout>

@if(session('success'))
<div id="success-notification" class="fixed top-4 right-4 z-50 p-4 bg-green-500 text-white rounded-lg shadow-lg flex items-center animate-fade-in">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span>{{ session('success') }}</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('success-notification');
    if (notification) {
        setTimeout(() => {
            notification.classList.remove('animate-fade-in');
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }
});
</script>
@endif

<!-- recApply Section -->
<div id="recapply-section">
  <section class="bg-white dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto text-center px-4">
      <div class="mx-auto w-20 h-20">
        <!-- Inline SVG Icon for Submit Document (Application Form) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" class="w-full h-full text-[#132080] dark:text-white">
            <image href="https://img.icons8.com/ios-filled/50/3f53e8/submit-document.png" width="50" height="50" />
        </svg>
    </div>
      <h2 class="text-3xl sm:text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-wider text-[#132080] dark:text-white mt-4">APPLICATION FORM</h2>
      <p class="mt-3 text-xl text-gray-600 dark:text-gray-300">Complete the form to apply for membership</p>
    </div>
  </section>
  
  <!-- Application Form -->
  <div class="bg-white dark:bg-gray-900 min-h-screen py-8 transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 rounded-full p-3 mr-3 transition-colors duration-300">
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
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                            Birthdate *
                        </label>
                        <input 
                            type="date" 
                            name="date" 
                            id="birthdate" 
                            value="{{ auth()->user()->birthdate ? \Carbon\Carbon::parse(auth()->user()->birthdate)->format('Y-m-d') : '' }}" 
                            readonly 
                            required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200">
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

                    <!-- Student and Professional License Checkboxes - Vertical Stack -->
                    <div class="space-y-2 mt-4">  <!-- Using space-y-2 for vertical spacing -->
                        <div class="flex items-center">
                            <input type="checkbox" id="isStudent" name="isStudent" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="isStudent" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I am applying as a student</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="hasLicense" name="hasLicense" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="hasLicense" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I have a professional license</label>
                        </div>
                    </div>
                </div>
            </div>
                
                <!-- Contact Information Section -->
                <div id="contact-info" class="border-b border-gray-200 dark:border-gray-700 pb-8 transition-colors duration-300">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-6 flex items-center transition-colors duration-300">
                        <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100 rounded-full p-3 mr-3 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        Contact Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">Email Address *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ auth()->user()->email }}" 
                                readonly 
                                required 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 cursor-not-allowed transition-all duration-200"
                                onblur="validateEmail(this)"> <!-- changed from oninput to onblur -->
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
                        <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100 rounded-full p-3 mr-3 transition-colors duration-300">
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
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 rounded-full p-3 mr-3 transition-colors duration-300">
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
                        <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100 rounded-full p-3 mr-3 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
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
</div>

<!-- Payment Overlay -->
<div id="paymentOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-2xl w-full mx-4 relative">
        <button id="closePaymentOverlay" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <h2 class="text-2xl font-bold text-[#132080] dark:text-white mb-6">Payment Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">GCash Payment</h3>
                <div class="mb-4">
                    <img src="/images/gcash.jpg" alt="GCash QR Code" class="w-full h-auto rounded-lg border border-gray-200 dark:border-gray-700">
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Please scan the QR code or send payment to:</p>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4">
                    <p class="font-semibold text-gray-800 dark:text-gray-200">GCash Number: 0917 123 4567</p>
                    <p class="font-semibold text-gray-800 dark:text-gray-200">Account Name: Radio Engineering Circle Inc.</p>
                    <p class="font-semibold text-gray-800 dark:text-gray-200">Amount: ₱500.00</p>
                </div>
            </div>
            
            <div>
                <form id="paymentForm">
                    <div class="mb-6">
                        <label for="gcashRefNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GCash Reference Number *</label>
                        <input type="text" id="gcashRefNumber" name="gcashRefNumber" required 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                               placeholder="Enter your GCash reference number">
                    </div>
                    
                    <div class="mb-6">
                        <label for="paymentProof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Payment Proof *</label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center">
                            <input type="file" id="paymentProof" name="paymentProof" accept="image/*" required 
                                   class="hidden" onchange="previewImage(this)">
                            <label for="paymentProof" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Click to upload payment screenshot</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 5MB</p>
                            </label>
                        </div>
                        <div id="imagePreviewContainer" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                            <img id="imagePreview" class="max-w-full h-48 rounded-lg border border-gray-200 dark:border-gray-700">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 text-sm font-medium bg-[#101966] text-white border border-[#101966] rounded-lg 
                hover:bg-white hover:text-blue-600 hover:border-blue-600 dark:hover:bg-gray-900 dark:hover:text-gray-200 
                transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fade-out {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
    .animate-fade-out {
        animation: fade-out 0.3s ease-out forwards;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

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

    // Payment overlay functionality
    const proceedToPaymentBtn = document.getElementById('proceedToPaymentBtn');
    const paymentOverlay = document.getElementById('paymentOverlay');
    const closePaymentOverlay = document.getElementById('closePaymentOverlay');
    const applicationForm = document.getElementById('applicationForm');
    const paymentForm = document.getElementById('paymentForm');

    proceedToPaymentBtn.addEventListener('click', function() {
        // Validate the form first
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
        
        // If all valid, show payment overlay
        paymentOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    closePaymentOverlay.addEventListener('click', function() {
        paymentOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });

    // Handle payment form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create FormData object from both forms
        const formData = new FormData(applicationForm);
        const paymentFormData = new FormData(paymentForm);
        
        // Append payment data to the main form data
        for (let [key, value] of paymentFormData.entries()) {
            formData.append(key, value);
        }
        
        // Submit the combined form data
        fetch(applicationForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            }
            return response.json();
        })
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Image preview functionality
    window.previewImage = function(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
});

// Show/hide license section based on checkbox
document.getElementById('hasLicense').addEventListener('change', function() {
    const licenseSection = document.getElementById('license-info');
    if (this.checked) {
        licenseSection.style.display = 'block';
        // Make license fields required
        document.getElementById('licenseClass').required = true;
        document.getElementById('licenseNumber').required = true;
        document.getElementById('expirationDate').required = true;
    } else {
        licenseSection.style.display = 'none';
        // Remove required attributes
        document.getElementById('licenseClass').required = false;
        document.getElementById('licenseNumber').required = false;
        document.getElementById('expirationDate').required = false;
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

// Other relationship field handling
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
</script>
</x-app-layout>