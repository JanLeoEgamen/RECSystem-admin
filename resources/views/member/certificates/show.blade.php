<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        {{ $certificate->title }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Certificate Details & Preview</p>
                </div>

                <a href="{{ route('member.certificates.index') }}" class="group inline-flex items-center justify-center sm:justify-start px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg text-center sm:text-left">
                    <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to My Certificates
                </a>
            </div>
        </div>
    </x-slot>

    @vite('resources/css/certificates.css')

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Certificate Information Card -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex items-start space-x-4">
                            <div class="p-3 bg-white/20 dark:bg-white/10 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white dark:text-gray-100 mb-2">{{ $certificate->title }}</h3>
                                <div class="flex flex-wrap items-center gap-4 text-blue-100 dark:text-blue-200">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Issued: {{ \Carbon\Carbon::parse($issuedAt)->format('F j, Y') }}
                                    </div>
                                    <div class="status-badge bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        ✓ Verified & Authentic
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Download button - Hidden on mobile -->
                            <button onclick="downloadCertificateAsImage({{ $certificate->id }}, {{ $member->id }})" 
                               class="hidden sm:inline-flex interactive-btn items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download as Image
                            </button>
                            
                            <button onclick="shareCertificate('{{ $certificate->title }}', '{{ route('member.certificates.show', $certificate) }}')" 
                               class="interactive-btn inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                Share Certificate
                            </button>
                        </div>
                    </div>
                    
                    <!-- Mobile Note -->
                    <div class="block lg:hidden mt-4 p-4 bg-white/10 dark:bg-white/5 rounded-xl border border-white/20">
                        <div class="flex items-center text-sm text-blue-100 dark:text-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Best viewed on desktop for optimal certificate preview quality</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Certificate Display Section -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/20 dark:bg-white/10 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white dark:text-white">Certificate Preview</h3>
                        </div>
                        
                        <div class="hidden sm:flex items-center space-x-2 text-blue-100 dark:text-blue-200 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>High-quality preview</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <!-- Instructions -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-700/50 rounded-2xl p-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-2 bg-blue-100 dark:bg-blue-800/50 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">How to Save Your Certificate</h4>
                                <p class="text-blue-700 dark:text-blue-300 text-sm leading-relaxed">
                                    Use the "Download as Image" button above to save your certificate as a high-quality PNG file. Perfect for sharing on professional networks or printing for display.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile View Message -->
                    <div class="block lg:hidden">
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700/50 rounded-2xl p-8 text-center">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-amber-900 dark:text-amber-100 mb-3">Desktop View Recommended</h3>
                            <p class="text-amber-800 dark:text-amber-200 mb-4 leading-relaxed">
                                For the best certificate preview experience, please use a desktop device or switch to desktop view.
                            </p>
                            <p class="text-sm text-amber-700 dark:text-amber-300">
                                The certificate preview is optimized for larger screens to ensure proper formatting and readability.
                            </p>
                            
                            <!-- Download button removed from mobile view -->
                        </div>
                    </div>
                    
                    <!-- Certificate Container - Hidden on Mobile -->
                    <div class="certificate-display-container hidden lg:block custom-scrollbar" id="certificateContainer">
                        <div class="relative">
                            <!-- Certificate Frame -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-inner">
                                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border-4 border-gradient-to-r from-[#101966] to-blue-600">
                                    @include('certificates.jcertificate', [
                                        'certificate' => $certificate,
                                        'member' => $member,
                                        'issueDate' => $issuedAt,
                                        'embedded' => true
                                    ])
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        // Fullscreen toggle function
        window.toggleFullscreen = function() {
            const container = document.getElementById('certificateContainer');
            if (!document.fullscreenElement) {
                container.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
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

        // Use the certificate already displayed on the page
        const certificateElement = document.querySelector('.certificate');
        
        if (!certificateElement) {
            document.body.removeChild(loadingDiv);
            showDownloadError(certificateId, memberId);
            return;
        }

        // Clone the element to avoid affecting the displayed version
        const clonedCertificate = certificateElement.cloneNode(true);
        clonedCertificate.style.position = 'fixed';
        clonedCertificate.style.left = '-9999px';
        clonedCertificate.style.top = '-9999px';
        document.body.appendChild(clonedCertificate);

        // Wait a moment for any images to load
        setTimeout(() => {
            html2canvas(clonedCertificate, {
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
                document.body.removeChild(clonedCertificate);
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
                document.body.removeChild(clonedCertificate);
                document.body.removeChild(loadingDiv);
                showDownloadError(certificateId, memberId);
            });
        }, 500);
    };

        // Show download error and fallback
        function showDownloadError(certificateId, memberId) {
            Swal.fire({
                title: 'Download Options',
                html: `
                    <div class="text-center space-y-6">
                        <div class="w-20 h-20 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Alternative Download Method</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Choose an alternative way to save your certificate:</p>
                        </div>
                        <button onclick="openPreviewForDownload(${certificateId})" 
                            class="w-full bg-gradient-to-r from-[#101966] to-blue-600 hover:from-blue-700 hover:to-[#101966] text-white py-4 px-6 rounded-xl transition-all duration-300 font-medium text-lg">
                            📄 Open in New Tab
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Right-click on the certificate and select "Save image as..." or use your browser's print feature</p>
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

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.fullscreenElement) {
                document.exitFullscreen();
            }
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                downloadCertificateAsImage({{ $certificate->id }}, {{ $member->id }});
            }
        });
    </script>
</x-app-layout>