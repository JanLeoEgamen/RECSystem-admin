<!-- Payment Overlay -->
<div id="paymentOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-8">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl">
            <div class="p-6">
                <!-- Error Display Container -->
<div id="paymentErrors" class="hidden mb-6">
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-700 p-4 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission:</h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <ul id="paymentErrorsList" class="list-disc pl-5 space-y-1">
                        <!-- Errors will be inserted here dynamically -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        <!-- Left Column -->
                        <div class="space-y-6">
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
                        </div>
                        
                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Address Info Summary -->
                            <div>
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
                            </div>
                        </div>
                    </div>
                    
                    <!-- Extended Important Notes Container -->
                    <div class="max-w-6xl mt-4 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
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
                
                <!-- Upload Payment Section -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Upload Payment Proof</h4>
                    
                    <!-- File Upload -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Receipt or Proof of Payment *</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                            <div class="space-y-1 text-center" id="upload-container">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="paymentProof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="paymentProof" name="paymentProof" type="file" class="sr-only" required onchange="handleFileUpload(this)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, PDF up to 5MB
                                </p>
                            </div>
                            
                            <!-- File Preview Container (hidden by default) -->
                            <div id="file-preview" class="hidden text-center w-full">
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div id="file-icon" class="flex-shrink-0">
                                            <!-- File icon will be inserted here -->
                                        </div>
                                        <div class="text-left">
                                            <p id="file-name" class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-xs"></p>
                                            <p id="file-size" class="text-xs text-gray-500 dark:text-gray-400"></p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Image Preview (for image files only) -->
                                <div id="image-preview-container" class="mt-4 hidden">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                                    <img id="image-preview" class="max-h-60 mx-auto rounded-md border border-gray-200 dark:border-gray-600" src="" alt="Preview">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reference Number Input -->
                    <div class="mt-4">
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number *</label>
                        <input type="text" id="reference_number" name="reference_number" placeholder="Input GCash ref number" required
                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400">
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button type="button" id="submitPaymentBtn" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Submit Payment Proof
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Payment Overlay Functions
function zoomQRCode() {
    // Implementation for zooming QR code
    console.log("Zoom QR code functionality");
}

// File Upload Handling
function handleFileUpload(input) {
    const file = input.files[0];
    if (!file) return;

    const uploadContainer = document.getElementById('upload-container');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const fileIcon = document.getElementById('file-icon');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');

    // Hide upload container and show preview
    uploadContainer.classList.add('hidden');
    filePreview.classList.remove('hidden');

    // Set file info
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);

    // Set appropriate icon
    const icon = getFileIcon(file);
    fileIcon.innerHTML = icon;

    // If file is an image, show preview
    if (file.type.match('image.*')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreviewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        imagePreviewContainer.classList.add('hidden');
    }

    // Clear any previous error
    clearUploadError();
}

function removeFile() {
    const uploadContainer = document.getElementById('upload-container');
    const filePreview = document.getElementById('file-preview');
    const fileInput = document.getElementById('paymentProof');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    // Reset file input
    fileInput.value = '';
    
    // Hide preview and show upload container
    filePreview.classList.add('hidden');
    uploadContainer.classList.remove('hidden');
    imagePreviewContainer.classList.add('hidden');

    // Clear any error
    clearUploadError();
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function getFileIcon(file) {
    const type = file.type;
    const name = file.name.toLowerCase();
    
    if (type.match('image.*')) {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>`;
    } else if (name.endsWith('.pdf')) {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>`;
    } else {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>`;
    }
}

// Validation Functions
function clearUploadError() {
    const errorElement = document.querySelector('.payment-upload-error');
    if (errorElement) {
        errorElement.remove();
    }
    document.getElementById('paymentProof').classList.remove('border-red-500');
}

function clearReferenceError() {
    const errorElement = document.querySelector('.payment-ref-error');
    if (errorElement) {
        errorElement.remove();
    }
    document.getElementById('reference_number').classList.remove('border-red-500');
}

function validatePaymentForm() {
    const paymentProof = document.getElementById('paymentProof');
    const referenceNumber = document.getElementById('reference_number');
    let isValid = true;

    // Clear previous errors
    clearUploadError();
    clearReferenceError();

    // Validate payment proof
    if (!paymentProof.files || !paymentProof.files[0]) {
        paymentProof.classList.add('border-red-500');
        const uploadContainer = document.querySelector('.border-dashed');
        uploadContainer.insertAdjacentHTML('beforebegin', 
            '<p class="payment-upload-error text-red-600 text-xs mb-2">Payment proof is required</p>');
        isValid = false;
    } else {
        const file = paymentProof.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!validTypes.includes(file.type)) {
            paymentProof.classList.add('border-red-500');
            const uploadContainer = document.querySelector('.border-dashed');
            uploadContainer.insertAdjacentHTML('beforebegin', 
                '<p class="payment-upload-error text-red-600 text-xs mb-2">Only JPG, PNG, or PDF files are allowed</p>');
            isValid = false;
        } else if (file.size > maxSize) {
            paymentProof.classList.add('border-red-500');
            const uploadContainer = document.querySelector('.border-dashed');
            uploadContainer.insertAdjacentHTML('beforebegin', 
                '<p class="payment-upload-error text-red-600 text-xs mb-2">File size must be less than 5MB</p>');
            isValid = false;
        }
    }

    // Validate reference number
    if (!referenceNumber.value.trim()) {
        referenceNumber.classList.add('border-red-500');
        referenceNumber.insertAdjacentHTML('beforebegin', 
            '<p class="payment-ref-error text-red-600 text-xs mb-2">Reference number is required</p>');
        isValid = false;
    } else if (!/^[a-zA-Z0-9]+$/.test(referenceNumber.value.trim())) {
        referenceNumber.classList.add('border-red-500');
        referenceNumber.insertAdjacentHTML('beforebegin', 
            '<p class="payment-ref-error text-red-600 text-xs mb-2">Enter a valid reference number</p>');
        isValid = false;
    }

    return isValid;
}

function handlePaymentSubmission(e) {
    e.preventDefault();
    
    // Clear previous errors
    document.getElementById('paymentErrors').classList.add('hidden');
    document.getElementById('paymentErrorsList').innerHTML = '';
    
    if (!validatePaymentForm()) {
        const firstError = document.querySelector('.payment-upload-error, .payment-ref-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return false;
    }
    
    const submitBtn = document.getElementById('submitPaymentBtn');
    submitBtn.disabled = true;
    
    // Create FormData from the main form
    const form = document.getElementById('applicationForm');
    const formData = new FormData(form);
    
    // Append payment-specific fields
    formData.append('payment_proof', document.getElementById('paymentProof').files[0]);
    formData.append('reference_number', document.getElementById('reference_number').value);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            document.getElementById('formContainer').classList.add('hidden');
            document.getElementById('paymentOverlay').classList.add('hidden');
            document.getElementById('thankYouMessage').classList.remove('hidden');
        } else if (data && data.errors) {
            const errorContainer = document.getElementById('paymentErrors');
            const errorList = document.getElementById('paymentErrorsList');
            
            errorContainer.classList.remove('hidden');
            
            Object.values(data.errors).forEach(messages => {
                messages.forEach(message => {
                    errorList.innerHTML += `<li>${message}</li>`;
                });
            });
            
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    })
    .finally(() => {
        const submitBtn = document.getElementById('submitPaymentBtn');
        if (submitBtn) {
            submitBtn.disabled = false;
        }
    });
    
    return false;
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close payment overlay
    document.getElementById('closeOverlayBtn').addEventListener('click', function() {
        document.getElementById('paymentOverlay').classList.add('hidden');
    });

    // Payment proof upload change
    document.getElementById('paymentProof').addEventListener('change', function() {
        handleFileUpload(this);
    });

    // Reference number input validation
    document.getElementById('reference_number').addEventListener('input', function() {
        clearReferenceError();
    });

    // Submit payment - strict validation
    document.getElementById('submitPaymentBtn').addEventListener('click', handlePaymentSubmission);

    // Prevent form submission on enter key in reference number field
    document.getElementById('reference_number').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            handlePaymentSubmission(e);
        }
    });
});

// Strict validation before showing payment overlay
function showPaymentOverlay() {
    // Clear any previous errors
    clearUploadError();
    clearReferenceError();
    
    // Validate both fields
    const paymentProof = document.getElementById('paymentProof');
    const referenceNumber = document.getElementById('reference_number');
    let isValid = true;

    if (!paymentProof.files || !paymentProof.files[0]) {
        paymentProof.classList.add('border-red-500');
        const uploadContainer = document.querySelector('.border-dashed');
        uploadContainer.insertAdjacentHTML('beforebegin', 
            '<p class="payment-upload-error text-red-600 text-xs mb-2">Payment proof is required</p>');
        isValid = false;
    }

    if (!referenceNumber.value.trim()) {
        referenceNumber.classList.add('border-red-500');
        referenceNumber.insertAdjacentHTML('beforebegin', 
            '<p class="payment-ref-error text-red-600 text-xs mb-2">Reference number is required</p>');
        isValid = false;
    }

    if (isValid) {
        document.getElementById('paymentOverlay').classList.remove('hidden');
    } else {
        const firstError = document.querySelector('.payment-upload-error, .payment-ref-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    return false; // Prevent default form submission
}
</script>
