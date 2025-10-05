<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generation Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 text-center">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-xl font-bold text-gray-900 mb-2">PDF Generation Failed</h1>
        <p class="text-gray-600 mb-6">{{ $error_message }}</p>
        
        <div class="space-y-3">
            <a href="{{ $download_image_url }}" 
               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                Download as High-Quality Image
            </a>
            
            <button onclick="window.close()" 
                    class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                Close Window
            </button>
            
            <a href="{{ url()->previous() }}" 
               class="block w-full text-gray-600 hover:text-gray-800 font-medium py-2 px-4 border border-gray-300 rounded-lg transition duration-200">
                Go Back
            </a>
        </div>
        
        <div class="mt-6 text-sm text-gray-500">
            <p>Certificate ID: {{ $certificate_id }}</p>
            <p>The image download will preserve the exact design and styling.</p>
        </div>
    </div>

    <script>
        // Auto-close after 30 seconds if user doesn't take action
        setTimeout(function() {
            if (confirm('Would you like to automatically download the certificate as an image?')) {
                window.location.href = '{{ $download_image_url }}';
            }
        }, 30000);
    </script>
</body>
</html>