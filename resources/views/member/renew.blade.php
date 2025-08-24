<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Membership Renewal') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                @if($hasPendingRenewal)
                    {{-- Show pending renewal message --}}
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">Renewal Request in Progress</h3>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <p>Your membership renewal request is currently being processed.</p>
                            <p class="mt-2">Reference Number: <span class="font-semibold">{{ $pendingRenewal->reference_number }}</span></p>
                            <p class="mt-2">Submitted on: {{ $pendingRenewal->created_at->format('F j, Y g:i a') }}</p>
                        </div>
                         <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 rounded-md text-white hover:bg-blue-700 transition-colors duration-300">
                Return to Login
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
                    </div>
                @else

                {{-- Payment + Upload Form --}}
                <form method="POST" action="{{ route('renew.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-col md:flex-row gap-8">
                        {{-- Left: QR Code + Payment Details --}}
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="border border-gray-300 dark:border-gray-600 p-3 rounded-lg relative w-full max-w-xs mx-auto">
                                <img src="/images/gcash.jpg" alt="GCash QR Code" class="w-full h-auto">
                                <button type="button" onclick="zoomQRCode()" class="absolute bottom-2 right-2 bg-blue-600 text-white p-1 rounded-full hover:bg-blue-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                            <button type="button" onclick="zoomQRCode()" class="text-sm text-center text-blue-600 dark:text-blue-400 hover:underline w-full">Click to enlarge</button>

                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <h5 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Payment Details</h5>
                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <p><strong>Amount:</strong> ₱500.00</p>
                                    <p><strong>GCash Name:</strong> Your Organization Name</p>
                                    <p><strong>GCash No.:</strong> 0912 345 6789</p>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Upload + Reference --}}
                        <div class="w-full md:w-1/2 space-y-6">
                            {{-- File Upload --}}
                            <div>
                                <label for="receipt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Receipt *</label>
                                <input type="file" id="receipt" name="receipt" accept="image/*" required onchange="handleFileUpload(this)"
                                    class="block w-full px-4 py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-white">
                                <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                                <div id="file-preview" class="hidden mt-4"></div>
                            </div>

                            {{-- Reference Number --}}
                            <div>
                                <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number *</label>
                                <input type="text" id="reference_number" name="reference_number" placeholder="Input GCash ref number" required
                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                                    value="{{ old('reference_number') }}">
                                <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                            </div>

                            {{-- Buttons --}}
                            <div class="flex justify-end gap-4 pt-2">
                                <a href="{{ route('member.dashboard') }}" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-white transition">
                                    Cancel
                                </a>
                                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    Submit Renewal Request
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif

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

<script>
    function zoomQRCode() {
        document.getElementById('qrZoomModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeZoom() {
        document.getElementById('qrZoomModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

// Handle file upload preview
function handleFileUpload(input) {
    const file = input.files[0];
    if (!file) return;

    const filePreview = document.getElementById('file-preview');
    filePreview.innerHTML = ''; // Clear any previous preview
    filePreview.classList.remove('hidden');

    const isImage = file.type.match('image.*');
    const isPDF = file.type === 'application/pdf';

    let previewHTML = `
        <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
            <div class="flex items-center space-x-4">
                <div>${getFileIcon(file)}</div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-xs">${file.name}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">${formatFileSize(file.size)}</p>
                </div>
            </div>
            <button type="button" onclick="removeFile()" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    `;

    if (isImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewHTML += `
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                    <img src="${e.target.result}" class="max-h-60 mx-auto rounded-md border border-gray-300 dark:border-gray-600" />
                </div>
            `;
            filePreview.innerHTML = previewHTML;
        };
        reader.readAsDataURL(file);
    } else {
        filePreview.innerHTML = previewHTML;
    }
}

function removeFile() {
    const input = document.getElementById('receipt');
    input.value = '';
    document.getElementById('file-preview').classList.add('hidden');
    document.getElementById('file-preview').innerHTML = '';
}

// Utility Functions
function formatFileSize(bytes) {
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    if (bytes === 0) return '0 Bytes';
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
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
</script>

</x-app-layout>
