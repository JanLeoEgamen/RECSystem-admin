<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        {{ $event->title }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Event details and registration information</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.events') }}" class="group inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Events
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Event Header Card -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-3xl shadow-2xl overflow-hidden mb-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 animate-slide-in-up" style="animation-delay: 0.2s;">
                <div class="p-8 sm:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex-1">
                            <div class="flex items-start space-x-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0V9a2 2 0 012-2h4a2 2 0 012-2"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                                        {{ $event->title }}
                                    </h1>
                                    <div class="flex flex-wrap items-center gap-4 text-sm">
                                        <div class="flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Start: {{ $event->start_date->format('M d, Y h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                            $isUpcoming = $event->start_date->isFuture();
                            $daysDiff = $event->start_date->diffInDays(now());
                        @endphp
                        <!-- Registration Status Badge - Top Right -->
                        <div class="flex justify-end lg:justify-start">
                            @if($registration)
                                @if($registration->status === 'attended')
                                    <div class="flex items-center bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Attended
                                    </div>
                                @elseif($registration->status === 'cancelled')
                                    <div class="flex items-center bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancelled
                                    </div>
                                @else
                                    <div class="flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Registered
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-full shadow-lg animate-pulse">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Not Registered
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Event Details -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white ml-4">Event Description</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <!-- Action Section -->
                    @if($registration && $registration->status === 'registered')
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-fade-in" style="animation-delay: 0.6s;">
                            <div class="flex items-center mb-6">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white ml-4">Quick Actions</h2>
                            </div>
                            
                            <div class="space-y-4">
                                <form action="{{ route('member.cancel-registration', $event->id) }}" method="POST" class="flex justify-start">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 dark:from-red-600 dark:to-red-700 dark:hover:from-red-700 dark:hover:to-red-800 text-white rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel Registration
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif(!$registration)
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-fade-in" style="animation-delay: 0.6s;">
                            <div class="flex items-center mb-6">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 hover:scale-110 hover:rotate-3 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white ml-4">Quick Actions</h2>
                            </div>
                            
                            <div class="space-y-4">
                                <form action="{{ route('member.register-event', $event->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 dark:from-green-600 dark:to-green-700 dark:hover:from-green-700 dark:hover:to-green-800 text-white rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Register for this Event
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Event Info -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/90 dark:to-gray-900/90 rounded-2xl shadow-xl p-6 transition-all duration-500 ease-out border border-blue-600 dark:border-gray-600 backdrop-blur-sm animate-scale-in" style="animation-delay: 0.8s;">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg mr-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Event Details
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Date & Time -->
                            <div class="p-4 bg-gradient-to-br from-blue-300 to-blue-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl border border-blue-700 dark:border-gray-600">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-800/50 rounded-lg">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0V9a2 2 0 012-2h4a2 2 0 012-2"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white">Date & Time</span>
                                </div>
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1 ml-12">
                                    <p><strong>Start:</strong> {{ $event->start_date->format('M d, Y h:i A') }}</p>
                                    <p><strong>End:</strong> {{ $event->end_date->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            
                            <!-- Location -->
                            <div class="p-4 bg-gradient-to-br from-orange-300 to-orange-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl border border-orange-700 dark:border-gray-600">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="p-2 bg-green-100 dark:bg-green-800/50 rounded-lg">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white">Location</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 ml-12">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>