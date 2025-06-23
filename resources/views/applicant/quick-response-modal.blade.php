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
</script>