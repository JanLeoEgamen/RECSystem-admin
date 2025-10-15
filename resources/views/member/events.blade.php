@vite('resources/css/events.css')

<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        My Events
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Discover and manage your event registrations</p>
                </div>
                <div class="flex items-center space-x-3 justify-center sm:justify-start">
                    <div class="px-4 py-2 bg-[#101966] dark:bg-white/20 backdrop-blur-sm rounded-lg">
                        <span class="text-white text-sm font-medium">{{ $events->count() }} Events</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                $totalEvents = $events->count();
                $registeredEvents = $events->filter(function($event) {
                    $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                    return $registration && $registration->status === 'registered';
                })->count();
                $attendedEvents = $events->filter(function($event) {
                    $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                    return $registration && $registration->status === 'attended';
                })->count();
                $upcomingEvents = $events->filter(function($event) {
                    return $event->start_date > now();
                })->count();
            @endphp

            <!-- Events Statistics -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8 text-white">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between space-y-4 sm:space-y-0 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Events Overview</h3>
                                <p class="text-blue-100 dark:text-gray-300">Discover and manage your event registrations</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.1s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $totalEvents }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Total Events</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.2s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-green-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $registeredEvents }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Registered</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.3s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-purple-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $attendedEvents }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Attended</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.4s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-yellow-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $upcomingEvents }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Upcoming</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($events->isEmpty())
                <!-- Empty State -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-up">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6">
                            <svg class="w-full h-full text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">No Events Available</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">
                            There are no events available at this time. Check back later for upcoming events and opportunities!
                        </p>
                        <button onclick="window.location.reload()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>
            @else
                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.3s">
                    @foreach($events as $index => $event)
                        @php
                            $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                            $isUpcoming = $event->start_date > now();
                            $isPast = $event->start_date < now();
                        @endphp
                        
                        <div class="event-card bg-gray-100 dark:bg-gray-700 rounded-3xl shadow-xl overflow-hidden animate-slide-up" style="animation-delay: {{ ($index * 0.1) + 0.4 }}s">

                            <!-- Event Header -->
                            <div class="relative p-6 bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:bg-gradient-to-br dark:from-gray-700 dark:via-gray-800 dark:to-gray-900 text-white">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-2 pr-4">{{ $event->title }}</h3>
                                        <div class="flex items-center space-x-2 text-sm opacity-90">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $event->start_date->format('M d, Y h:i A') }}</span>
                                        </div>
                                        @if($event->location)
                                            <div class="flex items-center space-x-2 text-sm opacity-90 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ Str::limit($event->location, 25) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div class="flex-shrink-0">
                                        @if($registration)
                                            @if($registration->status === 'attended')
                                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Attended
                                                </span>
                                            @elseif($registration->status === 'cancelled')
                                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Cancelled
                                                </span>
                                            @else
                                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-emerald-400 to-green-500 text-white shadow-lg">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Registered
                                                </span>
                                            @endif
                                        @else
                                            <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-500 text-white shadow-lg">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Available
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($isUpcoming)
                                    <div class="inline-flex items-center px-2 py-1 bg-white/20 rounded-lg text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        Upcoming Event
                                    </div>
                                @elseif($isPast)
                                    <div class="inline-flex items-center px-2 py-1 bg-white/20 rounded-lg text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Past Event
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Event Content -->
                            <div class="p-6">
                                <!-- Description -->
                                <div class="mb-6">
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {{ Str::limit($event->description, 120) }}
                                    </p>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-col gap-3">
                                    @if($registration)
                                        @if($registration->status === 'registered')
                                            <form action="{{ route('member.cancel-registration', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 w-full inline-flex items-center justify-center px-4 py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Cancel Registration
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('member.register-event', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 w-full inline-flex items-center justify-center px-4 py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Register Now
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('member.view-event', $event->id) }}" class="shimmer-button bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 w-full inline-flex items-center justify-center px-4 py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Help modal function
        window.showHelpModal = function() {
            Swal.fire({
                title: 'Events Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">🎯 Event Management</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">Discover and manage your event registrations. View upcoming events, register for new ones, and track your participation.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">📅 Event Status</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">Events show different statuses: Upcoming (blue), Registered (green), Attended (purple), and Past events are marked accordingly.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">📊 Event Statistics</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">Track your event participation with statistics showing total events, registered events, attended events, and upcoming events.</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">🎟️ Registration</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">Click on any event card to view details and register. Some events may have registration deadlines or capacity limits.</p>
                        </div>
                    </div>
                `,
                background: '#ffffff',
                color: '#374151',
                confirmButtonColor: '#101966',
                confirmButtonText: 'Got it!'
            });
        };
    </script>

    <style>
        /* Floating Help Button */
        .floating-btn {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            z-index: 50;
        }
        
        .interactive-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .interactive-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .interactive-btn:active {
            transform: scale(0.95);
        }
    </style>
</x-app-layout>