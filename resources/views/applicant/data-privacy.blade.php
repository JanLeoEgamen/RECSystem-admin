<x-app-layout>
    <div class="bg-gray-300 dark:bg-gray-900 min-h-screen py-8 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-[#101966] dark:bg-blue-800 px-6 py-6">
                    <div class="text-center">
                        <h1 class="text-2xl font-bold text-white">Data Privacy Policy</h1>
                        <p class="text-blue-100 dark:text-blue-200 mt-2">
                            How we collect, use, and protect your personal information
                        </p>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                            This page is under construction. Please check back later for our complete Data Privacy Policy.
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                                    We are currently updating our Data Privacy Policy to ensure compliance with the Data Privacy Act of 2012.
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('applicant.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 bg-[#101966] text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Application
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>