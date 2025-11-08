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
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg sm:text-xl leading-normal transition-colors duration-200 
                    w-full sm:w-auto mt-4 sm:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to {{ $backLabel }}
            </a>             
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header with Icon -->
            <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Verification</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Review and verify applicant payment proof</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Applicant Information Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Applicant Information</h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Full Name
                                </label>
                                <div class="p-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                    <p class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $applicant->first_name }} {{ $applicant->last_name }}
                                    </p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Reference Number
                                </label>
                                <div class="p-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                    <p class="text-gray-900 dark:text-gray-100 font-mono font-semibold">
                                        {{ $applicant->reference_number }}
                                    </p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payment Status
                                </label>
                                <div class="p-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold shadow-sm
                                        {{ $applicant->payment_status === 'verified' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border-2 border-green-300' : 
                                           ($applicant->payment_status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-2 border-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 border-2 border-yellow-300') }}">
                                        @if($applicant->payment_status === 'verified')
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        @elseif($applicant->payment_status === 'rejected')
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                        {{ ucfirst($applicant->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Submitted At
                                </label>
                                <div class="p-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                    <p class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $applicant->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Payment Proof</h4>
                        </div>

                        <div id="paymentProofContent" class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-600 p-4">
                            @if($applicant->payment_proof_path)
                                @php
                                $fileExtension = pathinfo($applicant->payment_proof_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                @endphp
                                
                                @if($isImage)
                                    <div class="relative text-center">
                                        <img src="{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}"
                                            class="max-h-80 mx-auto rounded-lg shadow-lg dark:shadow-gray-900/50 cursor-zoom-in hover:shadow-xl dark:hover:shadow-gray-900/70 transition-all duration-200 transform hover:scale-105"
                                            onclick="openZoomModal('{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}')">

                                        <button type="button" onclick="openZoomModal('{{ asset('images/payment_proofs/' . $applicant->payment_proof_path) }}')"
                                            class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                            Zoom Image
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-center text-gray-500 dark:text-gray-400 mt-3 font-medium">No payment proof uploaded</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        @if ($applicant->payment_status !== 'rejected' && $applicant->payment_status !== 'verified')
                            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                                <button onclick="verifyPayment({{ $applicant->id }})"
                                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-lg">Verify Payment</span>
                                </button>

                                <button onclick="rejectPayment({{ $applicant->id }})"
                                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-lg">Reject Payment</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zoom Modal -->
    <div id="zoomModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden justify-center items-center">
        <div class="relative max-w-5xl max-h-[90vh] p-4">
            <button onclick="closeZoomModal()"
                    class="absolute top-2 right-2 bg-white hover:bg-gray-200 text-black rounded-full p-1  shadow-md">
                ✕
            </button>
            <img id="zoomedImage" src="" alt="Zoomed Payment Proof" class="max-w-full max-h-[80vh] rounded-md shadow-lg mx-auto ">
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
                        title: 'Please wait...',
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
