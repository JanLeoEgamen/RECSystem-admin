<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        Document Details
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">View and manage your document</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.documents') }}" class="group inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Documents
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes slideInUp {
            from { 
                opacity: 0; 
                transform: translateY(60px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from { 
                opacity: 0; 
                transform: scale(0.9) translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: scale(1) translateY(0); 
            }
        }
        
        .animate-slide-in-up {
            opacity: 0;
            animation: slideInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .animate-scale-in {
            opacity: 0;
            animation: scaleIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
    </style>



    <div class="py-8 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Document Header Card -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-3xl shadow-2xl overflow-hidden mb-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 animate-slide-in-up" style="animation-delay: 0.2s;">
                <div class="p-8 sm:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex-1">
                            <div class="flex items-start space-x-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                    @if($document->url)
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    @else
                                        <i class="fas {{ $document->file_icon }} text-white text-2xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                                        {{ $document->title }}
                                    </h1>
                                    <div class="flex flex-wrap items-center gap-4 text-sm">
                                        <div class="flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Posted: {{ $document->created_at->format('M d, Y h:i A') }}
                                        </div>
                                        @if($document->pivot->viewed_at)
                                            <div class="flex items-center bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full shadow-lg">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Viewed: {{ \Carbon\Carbon::parse($document->pivot->viewed_at)->format('M d, Y h:i A') }}
                                            </div>
                                        @else
                                            <div class="flex items-center bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-full shadow-lg animate-pulse">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Unviewed
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Description Section -->
                    @if($document->description)
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white ml-4">Description</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($document->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Document Information -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-fade-in" style="animation-delay: 0.6s;">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white ml-4">Document Information</h2>
                        </div>
                        <div class="bg-blue-50 dark:bg-gray-800/60 rounded-xl p-4 sm:p-6 border border-blue-400 dark:border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                @if($document->url)
                                    <div class="flex items-center">
                                        <div class="p-2 bg-blue-100 dark:bg-blue-800/50 rounded-lg mr-3 sm:mr-4">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Type</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">External Link</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="p-2 bg-green-300 dark:bg-green-300 rounded-lg mr-3 sm:mr-4">
                                            <i class="fas {{ $document->file_icon }} text-green-600 dark:text-green-700 text-base sm:text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">File Type</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">{{ $document->file_type }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="p-2 bg-orange-100 dark:bg-orange-800/50 rounded-lg mr-3 sm:mr-4">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">File Size</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">{{ $document->file_size }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-6 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-scale-in" style="animation-delay: 0.8s;">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg mr-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Quick Actions
                        </h3>
                        <div class="space-y-4">
                            @if($document->url)
                                <a href="{{ $document->url }}" target="_blank" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 dark:from-blue-600 dark:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 text-white rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View External Document
                                </a>
                                <a href="{{ route('member.download-document', $document->id) }}" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 dark:from-green-600 dark:to-green-700 dark:hover:from-green-700 dark:hover:to-green-800 text-white rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Link
                                </a>
                            @elseif($document->file_path)
                                <a href="{{ Storage::disk('public')->url($document->file_path) }}" target="_blank" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-300 to-green-100 border border-green-600 hover:from-green-600 hover:to-green-700 dark:from-green-600 dark:to-green-700 dark:hover:from-green-700 dark:hover:to-green-800 hover:text-gray-100 dark:text-gray-200 text-gray-700 rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Document
                                </a>                     
                                <a href="{{ route('member.download-document', $document->id) }}" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-300 to-blue-100 hover:from-blue-600 border border-blue-600 hover:to-blue-700 dark:from-blue-600 dark:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 hover:text-gray-100 dark:text-gray-200 text-gray-700 rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Document
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Document Stats -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-4 sm:p-6 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-scale-in" style="animation-delay: 1.0s;">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6 flex items-center">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg mr-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            Document Stats
                        </h3>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 sm:p-4 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl border border-blue-400 dark:border-gray-600 shadow-sm">
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-0 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Created
                                </span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $document->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 sm:p-4 bg-gradient-to-r from-green-200 to-green-50 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl border border-green-400 dark:border-gray-600 shadow-sm">
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-0 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Status
                                </span>
                                @if($document->pivot->is_viewed)
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Viewed
                                    </span>
                                @else
                                    <span class="text-sm font-bold text-orange-600 dark:text-orange-400 flex items-center animate-pulse">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Unviewed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>