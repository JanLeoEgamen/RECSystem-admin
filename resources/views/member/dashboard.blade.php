<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Member Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @vite('resources/css/dashboard.css')

    <div class="py-8 px-4 sm:px-6 lg:px-8 dark:bg-gray-900 min-h-screen">
        @if($isMembershipNearExpiry)
            <div class="max-w-7xl mx-auto mb-8">
                <div class="relative overflow-hidden bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl shadow-lg hover-lift" role="alert">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-white bg-opacity-20 rounded-full">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 15.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-2">Membership Expiring Soon</h3>
                                <p class="text-white text-opacity-90 mb-4">Your membership will expire on {{ \Carbon\Carbon::parse(auth()->user()->member->membership_end)->format('F j, Y') }}. Please renew to avoid interruption of services.</p>
                                <a href="{{ route('member.renew') }}" class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-opacity-30 transition-all duration-300 hover:scale-105">
                                    <span>Renew Now</span>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mt-10 -mr-10"></div>
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto">
            <!-- Membership Information Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 lg:gap-8 mb-12">
                <!-- REC Number Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.1s;">
                    <div class="absolute inset-0 card-gradient opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">REC Number</h3>
                                <p class="text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300 truncate">
                                    {{ auth()->user()->member->rec_number ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                </div>

                <!-- Membership Type Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="absolute inset-0 card-gradient-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">Membership Type</h3>
                                <p class="text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300 truncate">
                                    {{ auth()->user()->member->membershipType->type_name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-600"></div>
                </div>

                <!-- Section Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.3s;">
                    <div class="absolute inset-0 card-gradient-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">Section</h3>
                                <p class="text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300 truncate">
                                    {{ auth()->user()->member->section->section_name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
                </div>

                <!-- Membership Validity Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="absolute inset-0 card-gradient-5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-yellow-500 to-orange-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">Membership Validity</h3>
                                <p class="text-xl lg:text-2xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300">
                                    @if(auth()->user()->member->is_lifetime_member)
                                        Lifetime
                                    @else
                                        {{ auth()->user()->member->membership_end ? \Carbon\Carbon::parse(auth()->user()->member->membership_end)->format('M d, Y') : 'N/A' }}
                                    @endif
                                </p>
                                @if(!auth()->user()->member->is_lifetime_member && auth()->user()->member->membership_end)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ \Carbon\Carbon::parse(auth()->user()->member->membership_end)->isPast() ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} group-hover:bg-white group-hover:bg-opacity-20 group-hover:text-white transition-all duration-300">
                                            @if(\Carbon\Carbon::parse(auth()->user()->member->membership_end)->isPast())
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                Expired
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Valid
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-orange-600"></div>
                </div>

                <!-- Lifetime Member Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.5s;">
                    <div class="absolute inset-0 card-gradient-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300 {{ auth()->user()->member->is_lifetime_member ? 'pulse-glow' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">Lifetime Member</h3>
                                <div class="flex items-center space-x-2">
                                    <p class="text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300">
                                        {{ auth()->user()->member->is_lifetime_member ? 'Yes' : 'No' }}
                                    </p>
                                    @if(auth()->user()->member->is_lifetime_member)
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-yellow-400 group-hover:text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-pink-600"></div>
                </div>

                <!-- Status Card -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover-lift animate-slide-up" style="animation-delay: 0.6s;">
                    <div class="absolute inset-0 card-gradient-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 p-6 lg:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white transition-colors duration-300">Status</h3>
                                <div class="flex items-center space-x-2">
                                    <p class="text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300 truncate">
                                        {{ auth()->user()->member->status ?? 'N/A' }}
                                    </p>
                                    @if(auth()->user()->member->status)
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-600"></div>
                </div>
            </div>

            <!-- Recent Announcements Section -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-xl animate-slide-up" style="animation-delay: 0.7s;">
                
                <div class="relative z-10 p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Recent Announcements</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Stay updated with the latest news</p>
                            </div>
                        </div>
                        <a href="{{ route('member.announcements') }}" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <span>View All</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                    
                    @if(auth()->user()->member->announcements()->count() > 0)
                        <div class="space-y-4">
                            @foreach(auth()->user()->member->announcements()->orderBy('created_at', 'desc')->take(3)->get() as $announcement)
                                <a href="{{ route('member.view-announcement', $announcement->id) }}" class="group block relative overflow-hidden">
                                    <div class="relative p-6 border-2 border border-blue-400 dark:border-gray-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg bg-blue-50 dark:bg-gray-700 hover:bg-white dark:hover:bg-gray-600">
                                        <!-- Hover effect background -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-blue-200 dark:from-blue-900 dark:to-purple-900 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                        
                                        <div class="relative z-10 flex justify-between items-start space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full group-hover:scale-125 transition-transform duration-300"></div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 truncate">
                                                            {{ $announcement->title }}
                                                        </h4>
                                                        <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-2 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">
                                                            {{ \Illuminate\Support\Str::limit($announcement->content, 120) }}
                                                        </p>
                                                        <div class="flex items-center space-x-4 mt-3">
                                                            <span class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {{ $announcement->created_at->diffForHumans() }}
                                                            </span>
                                                            @if(!$announcement->pivot->is_read)
                                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full shadow-sm pulse-glow">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    New
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="p-2 rounded-full bg-gray-200 dark:bg-gray-600 group-hover:bg-blue-100 dark:group-hover:bg-blue-800 transition-colors duration-300">
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No announcements yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">Check back later for important updates and news.</p>
                        </div>
                    @endif
                </div>
            </div>
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
                title: 'Dashboard Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">🏠 Welcome Home</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">Your dashboard provides an overview of your membership status, important information, and quick access to key features.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">📋 Membership Info</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">View your REC number, membership type, section, validity period, and current status at a glance.</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">⚠️ Important Alerts</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">Pay attention to any alerts or notifications, especially regarding membership expiry or renewal requirements.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">📢 Recent Announcements</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">Stay updated with the latest announcements and news from the organization directly from your dashboard.</p>
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