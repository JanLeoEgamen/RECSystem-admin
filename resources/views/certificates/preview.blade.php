<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Certificate Preview
            </h2>

            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <!-- Single Download Button -->
                <!-- <button onclick="downloadCertificateAsImage()" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                            bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                            focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                            dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                            w-full sm:w-auto text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Download as PNG
                </button> -->

                <a href="{{ route('certificates.send', $certificate->id) }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send Certificate
                </a>

                <a href="{{ route('certificates.edit', $certificate->id) }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full sm:w-auto text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Certificate
                </a>

                <a href="{{ route('certificates.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto mt-4 md:mt-0">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Certificates
                </a> 
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Mobile View Message -->
                    <div class="block md:hidden">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                Desktop View Required
                            </h3>
                            <p class="text-blue-700 dark:text-blue-300 mb-4">
                                To view the certificate preview, please use a desktop or switch to desktop site view for the best experience.
                            </p>
                            <p class="text-sm text-blue-600 dark:text-blue-400">
                                The certificate preview is optimized for larger screens to ensure proper formatting and readability.
                            </p>
                        </div>
                    </div>

                    <!-- Desktop View Certificate Preview -->
                    <div class="hidden md:block">
                        <div class="certificate-preview border-2 border-gray-200 p-8">
                            @include('certificates.jcertificate', [
                                'certificate' => $certificate,
                                'member' => null,
                                'issueDate' => now()->format('F j, Y'),
                                'embedded' => true
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <script>
        function downloadCertificateAsImage() {
            const certificateElement = document.querySelector('.certificate-preview');
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            loadingDiv.innerHTML = `
                <div class="bg-white rounded-lg p-6 text-center dark:bg-gray-800 dark:text-white">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"></div>
                    <p class="text-lg font-medium">Generating certificate image...</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Please wait</p>
                </div>
            `;
            document.body.appendChild(loadingDiv);
            
            html2canvas(certificateElement, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false
            }).then(function(canvas) {
                document.body.removeChild(loadingDiv);
                const image = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                const fileName = 'certificate_preview.png';
                
                downloadLink.href = image;
                downloadLink.download = fileName;
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                
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
                
            }).catch(function(error) {
                document.body.removeChild(loadingDiv);
                console.error('Error generating image:', error);
                Swal.fire({
                    title: 'Download Failed',
                    text: 'Error generating certificate image. Please try again.',
                    icon: 'error',
                    background: '#101966',
                    color: '#fff'
                });
            });
        }

        // Add CSS for loading animation
        const loadingStyles = document.createElement('style');
        loadingStyles.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .animate-spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(loadingStyles);
    </script> -->
</x-app-layout>