<x-app-layout>
    <x-slot name="header">
        @php
            $from = request()->query('from');
            $backRoute = $from === 'rejected' ? route('cashier.rejected') :
                        ($from === 'verified' ? route('cashier.verified') :
                        route('cashier.index'));
            $backLabel = $from === 'rejected' ? 'Rejected Payments' :
                        ($from === 'verified' ? 'Verified Payments' :
                        'Applicants');
        @endphp

        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Payment Verification
            </h2>
            <a href="{{ $backRoute }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to {{ $backLabel }}
            </a>             
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Applicant Information -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4">Applicant Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium">Full Name</label>
                                    <p class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                        {{ $applicant->first_name }} {{ $applicant->last_name }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Reference Number</label>
                                    <p class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                        {{ $applicant->reference_number }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Payment Status</label>
                                    <p class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $applicant->payment_status === 'verified' ? 'bg-green-100 text-green-800' : 
                                               ($applicant->payment_status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($applicant->payment_status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Submitted At</label>
                                    <p class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                        {{ $applicant->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof Section -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4">Payment Proof</h3>
                            <div id="paymentProofContent" class="mt-2 border border-gray-200 dark:border-gray-600 rounded-md p-2">
                                @if($applicant->payment_proof_path)
                                    @php
                                    $fileExtension = pathinfo($applicant->payment_proof_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="relative text-center">
                                            <img src="{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}"
                                                class="max-h-64 mx-auto rounded-md shadow cursor-zoom-in"
                                                onclick="openZoomModal('{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}')">

                                            <button onclick="openZoomModal('{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}')"
                                                    class="mt-3 inline-block px-4 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded transition">
                                                Zoom
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-center text-gray-500 py-4">No payment proof uploaded</p>
                                @endif
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-6 flex justify-center space-x-3">
                                @if ($applicant->payment_status !== 'rejected' && $applicant->payment_status !== 'verified')
                                    <div class="mt-6 flex justify-center space-x-3">
                                        <button onclick="verifyPayment({{ $applicant->id }})"
                                                class="px-4 py-2 rounded-md bg-green-500 hover:bg-green-600 text-white text-sm font-medium transition-colors">
                                            Verify
                                        </button>

                                        <button onclick="rejectPayment({{ $applicant->id }})"
                                                class="px-4 py-2 rounded-md bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
                                            Reject
                                        </button>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zoom Modal -->
    <div id="zoomModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden justify-center items-center">
        <div class="relative max-w-5xl max-h-[90vh] p-4">
            <button onclick="closeZoomModal()"
                    class="absolute top-2 right-2 bg-white hover:bg-gray-200 text-black rounded-full p-1 shadow-md">
                ✕
            </button>
            <img id="zoomedImage" src="" alt="Zoomed Payment Proof" class="max-w-full max-h-[80vh] rounded-md shadow-lg mx-auto">
        </div>
    </div>

    <!-- Confirmation Message -->
    <div id="confirmationBox" class="hidden mt-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded-md text-center">
        <p class="mb-4 font-medium">Are you sure you want to verify this payment?</p>
        <div class="flex justify-center space-x-4">
            <button id="confirmYesBtn"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                Yes, Verify
            </button>
            <button onclick="cancelConfirmation()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Cancel
            </button>
        </div>
    </div>

    <!-- Status Message Box -->
    <div id="statusMessage" class="hidden mt-4 p-4 rounded-md text-center font-medium"></div>


    <script>
        // Store the current applicant ID when opening the modal
        let pendingVerificationId = null;

        function verifyPayment(id) {
            pendingVerificationId = id;
            document.getElementById('confirmationBox').classList.remove('hidden');
        }

        function showStatusMessage(type, message) {
            const box = document.getElementById('statusMessage');
            box.textContent = message;

            // Set styling
            box.className = `mt-4 p-4 rounded-md text-center font-medium ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-400' :
                'bg-red-100 text-red-800 border border-red-400'
            }`;
            
            box.classList.remove('hidden');

            if (type === 'success') {
                // Redirect after showing message
                setTimeout(() => {
                    window.location.href = "{{ route('cashier.index') }}";
                }, 2000); // Wait 2 seconds before redirect
            }
        }

        document.getElementById('confirmYesBtn').addEventListener('click', function () {
            if (!pendingVerificationId) return;

            fetch(`/cashier/${pendingVerificationId}/verify`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Verification failed.');
                return response.json();
            })
            .then(data => {
                // ✅ Show message and redirect
                showStatusMessage('success', data.message || 'Payment verified successfully.');

                // ✅ Hide confirmation box
                document.getElementById('confirmationBox').classList.add('hidden');
                pendingVerificationId = null;
            })
            .catch(error => {
                console.error(error);
                showStatusMessage('error', 'An error occurred during verification.');
            });
        });


        function cancelConfirmation() {
            pendingVerificationId = null;
            document.getElementById('confirmationBox').classList.add('hidden');
        }


        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
        }

        // Use the stored ID when confirming
        function confirmVerification() {
            closePreviewModal();
            
            if (!currentApplicantId) return;
            
            fetch(`/cashier/${currentApplicantId}/verify`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                showToast('success', data.message || 'Payment verified successfully');
                setTimeout(() => window.location.href = "{{ route('cashier.index') }}", 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'An error occurred while verifying payment');
            });
        }

        function rejectPayment(id) {
            const reason = prompt('Please enter the reason for rejection:');
            if (reason === null) return;
            
            if (reason.trim() === '') {
                alert('Rejection reason cannot be empty');
                return;
            }

            if (confirm(`Are you sure you want to reject this payment? Reason: ${reason}`)) {
                fetch(`/cashier/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ reason: reason })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message || 'Payment rejected successfully');
                        setTimeout(() => {
                            window.location.href = "{{ route('cashier.index') }}";
                        }, 1500);
                    } else {
                        showToast('error', data.message || 'Error rejecting payment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'An error occurred while rejecting payment');
                });
            }
        }

        function showToast(type, message) {
            // Implement your toast notification system here
            // Example: Using Alpine.js or a toast library
            alert(`${type.toUpperCase()}: ${message}`);
        }

        function zoomImage(url) {
            const zoomWindow = window.open('', '_blank');
            zoomWindow.document.write(`
                <html>
                <head>
                    <title>Zoomed Image</title>
                    <style>
                        body {
                            margin: 0;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background: #111;
                            height: 100vh;
                        }
                        img {
                            max-width: 100%;
                            max-height: 100%;
                            object-fit: contain;
                            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
                        }
                    </style>
                </head>
                <body>
                    <img src="${url}" alt="Zoomed Payment Proof">
                </body>
                </html>
            `);
        }

        function openZoomModal(imageUrl) {
            const modal = document.getElementById('zoomModal');
            const zoomedImage = document.getElementById('zoomedImage');

            zoomedImage.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeZoomModal() {
            const modal = document.getElementById('zoomModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('zoomedImage').src = '';
        }
    </script>
    
</x-app-layout>