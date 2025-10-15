<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        {{ __('My Certificates') }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Your achievement certificates and credentials</p>
                </div>

                <div class="flex justify-center sm:justify-end space-x-3">
                    <div class="group inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 transition-all duration-300">
                        <svg class="h-5 w-5 mr-2 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        {{ $certificates->total() ?? 0 }} Certificate{{ $certificates->total() != 1 ? 's' : '' }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @vite('resources/css/certificates.css')

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-500 dark:border-green-700/50 rounded-2xl p-6 mb-8 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 dark:bg-green-800/50 rounded-xl">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                            Certificate Collection
                        </h4>
                        <p class="text-green-700 dark:text-green-300 text-sm leading-relaxed">
                            Manage and download your professional certificates. Each certificate represents your achievements and can be downloaded as high-quality images for sharing or printing.
                        </p>
                    </div>
                </div>
            </div>

            @if($certificates->isEmpty())
                <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-bounce-in">
                    <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 text-white">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-white/20 dark:bg-white/10 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Certificate Vault</h3>
                                <p class="text-blue-100 text-sm">Your achievement showcase</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-12 text-center">
                        <div class="mb-6">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Certificates Yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            Your certificates will appear here once they are issued. Complete courses and assessments to earn your professional credentials.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Secure Storage
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Easy Download
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Verified Authenticity
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Certificates Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($certificates as $index => $certificate)
                        @php
                            $issuedAt = $certificate->pivot->issued_at;
                            $delayClass = 'style="animation-delay: ' . (0.2 + ($index * 0.1)) . 's;"';
                        @endphp
                        <div class="certificate-card bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up" {!! $delayClass !!}>
                            
                            <!-- Certificate Header -->
                            <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-white dark:text-gray-100 mb-2 line-clamp-2">
                                            {{ $certificate->title }}
                                        </h3>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center text-blue-100 dark:text-blue-200 text-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Issued: {{ \Carbon\Carbon::parse($issuedAt)->format('M j, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="status-badge bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        ✓ Verified
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <!-- Certificate Image Preview -->
                                @php
                                    $imagePath = $certificate->pivot->image_path ?? null;
                                @endphp

                                @if($imagePath && Storage::disk('public')->exists($imagePath))
                                    <div class="certificate-image mb-6 rounded-2xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-600">
                                        <img src="{{ Storage::disk('public')->url($imagePath) }}" 
                                            alt="{{ $certificate->title }}" 
                                            class="w-full h-40 object-cover cursor-pointer transition-transform duration-300 hover:scale-105"
                                            onclick="window.open('{{ route('member.certificates.show', $certificate) }}', '_blank')">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-medium">Click to view full certificate</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-6 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-8 text-center border border-blue-200 dark:border-blue-700/50">
                                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Certificate Preview</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Click view to see full certificate</p>
                                    </div>
                                @endif
                                                                
                                <div class="space-y-4">
                                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 leading-relaxed">
                                        {{ strip_tags(Str::limit($certificate->content, 150)) }}
                                    </p>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('member.certificates.show', $certificate) }}" 
                                           class="interactive-btn inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-700 hover:to-[#101966] text-white text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Certificate
                                        </a>
                                        
                                        <div class="flex space-x-2">
                                            <!-- Download button - Hidden on mobile -->
                                            <button onclick="downloadCertificateAsImage({{ $certificate->id }}, {{ Auth::user()->member->id }})" 
                                               class="hidden sm:flex interactive-btn group p-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl transition-all duration-300 transform hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </button>
                                            
                                            <button onclick="shareCertificate('{{ $certificate->title }}', '{{ route('member.certificates.show', $certificate) }}')" 
                                               class="interactive-btn group p-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white rounded-xl transition-all duration-300 transform hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Help Button -->
    <div class="floating-btn">
        <button onclick="showHelpModal()" class="interactive-btn p-4 bg-gradient-to-r from-[#101966] to-blue-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>

    <!-- Include required libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Share certificate function
        window.shareCertificate = function(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: `My Certificate: ${title}`,
                    text: `Check out my certificate: ${title}`,
                    url: url
                }).catch(console.error);
            } else {
                // Fallback to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    Swal.fire({
                        title: 'Link Copied!',
                        text: 'Certificate link has been copied to clipboard',
                        icon: 'success',
                        background: '#101966',
                        color: '#fff',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            }
        };

        // Help modal function
        window.showHelpModal = function() {
            Swal.fire({
                title: 'Certificate Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Viewing Certificates</h4>
                                <p class="text-sm text-gray-600">Click "View Certificate" to see the full certificate with all details.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Downloading</h4>
                                <p class="text-sm text-gray-600">Use the download button to save your certificate as a high-quality PNG image.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Sharing</h4>
                                <p class="text-sm text-gray-600">Share your certificate link with others or copy it to your clipboard.</p>
                            </div>
                        </div>
                    </div>
                `,
                background: '#ffffff',
                color: '#374151',
                confirmButtonColor: '#101966',
                confirmButtonText: 'Got it!'
            });
        };

        window.downloadCertificateAsImage = function(certificateId, memberId) {
        // Show loading overlay with enhanced design
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'loading-overlay fixed inset-0 flex items-center justify-center z-50';
        loadingDiv.innerHTML = `
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl p-8 text-center shadow-2xl border border-gray-200 dark:border-gray-700 max-w-sm mx-4">
                <div class="w-16 h-16 mx-auto mb-6">
                    <div class="animate-spin rounded-full h-full w-full border-4 border-gray-200 dark:border-gray-700 border-t-[#101966]"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Generating Certificate</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    Creating high-quality image of your certificate...
                </p>
                <div class="mt-4 flex items-center justify-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                    <div class="w-2 h-2 bg-[#101966] rounded-full animate-pulse"></div>
                    <span>Processing</span>
                </div>
            </div>
        `;
        document.body.appendChild(loadingDiv);

        // Use AJAX to get the certificate HTML
        $.ajax({
            url: `/member/certificates/${certificateId}/preview-content`,
            type: 'GET',
            success: function(html) {
                // Create a temporary container for the certificate
                const tempContainer = document.createElement('div');
                tempContainer.style.position = 'fixed';
                tempContainer.style.left = '-9999px';
                tempContainer.style.top = '-9999px';
                tempContainer.style.width = '297mm';
                tempContainer.style.height = '210mm';
                tempContainer.innerHTML = html;
                document.body.appendChild(tempContainer);

                // Wait a moment for images to load
                setTimeout(() => {
                    const certificateElement = tempContainer.querySelector('.certificate') || tempContainer;
                    
                    html2canvas(certificateElement, {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: '#ffffff',
                        logging: false
                    }).then(canvas => {
                        // Convert canvas to PNG and download
                        const image = canvas.toDataURL('image/png');
                        const downloadLink = document.createElement('a');
                        const fileName = `certificate_${certificateId}_${memberId}.png`;
                        
                        downloadLink.href = image;
                        downloadLink.download = fileName;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                        // Clean up
                        document.body.removeChild(tempContainer);
                        document.body.removeChild(loadingDiv);
                        
                        // Show success message
                        Swal.fire({
                            title: 'Download Complete!',
                            text: 'Certificate has been downloaded as PNG',
                            icon: 'success',
                            background: '#101966',
                            color: '#fff',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                    }).catch(error => {
                        console.error('Error generating image:', error);
                        document.body.removeChild(tempContainer);
                        document.body.removeChild(loadingDiv);
                        showDownloadError(certificateId, memberId);
                    });
                }, 500);
            },
            error: function() {
                document.body.removeChild(loadingDiv);
                showDownloadError(certificateId, memberId);
            }
        });
    };

        // Show download error and fallback
        function showDownloadError(certificateId, memberId) {
            Swal.fire({
                title: 'Download Options',
                html: `
                    <div class="text-center space-y-4">
                        <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Choose an alternative download method:</p>
                        <button onclick="openPreviewForDownload(${certificateId})" 
                            class="w-full bg-gradient-to-r from-[#101966] to-blue-600 hover:from-blue-700 hover:to-[#101966] text-white py-3 px-6 rounded-xl transition-all duration-300 font-medium">
                            📄 Open Preview Page
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400">You can manually save the certificate using your browser's save options</p>
                    </div>
                `,
                background: '#ffffff',
                color: '#374151',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl',
                    cancelButton: 'rounded-xl'
                }
            });
        }

        // Open preview page for manual download
        function openPreviewForDownload(certificateId) {
            window.open(`/member/certificates/${certificateId}`, '_blank');
            Swal.close();
        }
    </script>
</x-app-layout>