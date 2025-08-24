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

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                Payment <span class="block sm:hidden">Verification</span>
                <span class="hidden sm:inline">Verification</span>
            </h2>

            <a href="{{ $backRoute }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0">

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
                                               class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                                dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">
                                            Verify
                                        </button>

                                        <button onclick="rejectPayment({{ $applicant->id }})"
                                                class="inline-flex items-center px-5 py-2 text-white hover:text-red-600 hover:border-red-600 
                                                  bg-red-600 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                  focus:ring-red-600 border border-white font-medium dark:border-[#3E3E3A] 
                                                  dark:hover:bg-black dark:hover:border-red-600 rounded-lg text-xl leading-normal transition-colors duration-200">
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let pendingVerificationId = null;

        function verifyPayment(id) {
            pendingVerificationId = id;
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to verify this payment?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                background: '#101966',
                color: '#fff',
                confirmButtonText: 'Yes, Verify',
                cancelButtonText: 'Cancel',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Verifying...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

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
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Verified',
                            text: data.message || 'Payment has been successfully verified.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('cashier.index') }}";
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error', 'An error occurred during verification.', 'error');
                        console.error(error);
                    });
                }
            });
        }


        function rejectPayment(id) {
            Swal.fire({
                title: 'Reason for Rejection',
                input: 'text',
                inputPlaceholder: 'Enter reason...',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                background: '#101966',
                color: '#fff',
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Rejection reason cannot be empty!';
                    }
                },
                reverseButtons: false,
                didOpen: () => {
                    const input = Swal.getInput();
                    if (input) {
                        input.style.color = '#000';
                        input.style.backgroundColor = '#fff';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const reason = result.value;

                    Swal.fire({
                        title: 'Rejecting...',
                        allowOutsideClick: false,
                        background: '#101966',
                        color: '#fff',
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

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
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Rejected',
                            text: data.message || 'Payment has been successfully rejected.',
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#101966',
                            color: '#fff'
                        }).then(() => {
                            window.location.href = "{{ route('cashier.index') }}";
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error', 'An error occurred while rejecting payment.', 'error');
                        console.error(error);
                    });
                }
            });
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
