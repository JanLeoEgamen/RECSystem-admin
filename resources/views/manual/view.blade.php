<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-2xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center">
                Super Admin Manual 
                <br class="block md:hidden">
                Help and Support
            </h2>

            @can('edit manuals')
                <a href="{{ route('manual.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                            bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                            focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                            dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                            w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    Modify Manual
                </a>
          @endcan
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-6 md:mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <!-- Mobile Dropdown -->
                    <div class="md:hidden p-4">
                        <select id="mobileTabDropdown" class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="tutorial-videos">Tutorial Videos</option>
                            <option value="faq">FAQ</option>
                            <option value="user-guide">User Guide</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                    
                    <!-- Desktop Tabs - Centered -->
                    <nav class="hidden md:flex justify-center px-4 md:px-6" aria-label="Tabs">
                        <div class="flex space-x-8">
                            <button data-tab="tutorial-videos" 
                                    class="tab-button active-tab py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                                <div class="flex items-center justify-start space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m2-10V7a3 3 0 11-6 0V4a3 3 0 016 0zM7 21h10a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>Tutorial Videos</span>
                                </div>
                            </button>
                            <button data-tab="faq" 
                                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                                <div class="flex items-center justify-start space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>FAQ</span>
                                </div>
                            </button>
                            <button data-tab="user-guide" 
                                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                                <div class="flex items-center justify-start space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>User Guide</span>
                                </div>
                            </button>
                            <button data-tab="support" 
                                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                                <div class="flex items-center justify-start space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Support</span>
                                </div>
                            </button>
                        </div>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-4 md:p-6">                  
                    <!-- Tutorial Videos Tab -->
                    <div id="tutorial-videos" class="tab-content">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 md:mb-6 text-center md:text-left">Tutorial Videos</h3>
                        @if($tutorialVideos->isEmpty())
                            <div class="text-center py-6 md:py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16 mx-auto text-gray-400 mb-3 md:mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No tutorial videos available yet.</p>
                            </div>
                        @else
                            <!-- Grid Layout for Tutorial Videos with Previews -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                                @foreach($tutorialVideos as $video)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-all duration-300 hover:bg-blue-50 dark:hover:bg-gray-600 group">
                                        <!-- Video Preview Section -->
                                        @if($video->video_url)
                                            @php
                                                $videoId = null;
                                                $url = $video->video_url;
                                                
                                                if (preg_match('/youtu\.be\/([^?&]+)/', $url, $matches)) {
                                                    $videoId = $matches[1];
                                                }

                                                elseif (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
                                                    $videoId = $matches[1];
                                                }
    
                                                elseif (preg_match('/youtube\.com\/embed\/([^?&]+)/', $url, $matches)) {
                                                    $videoId = $matches[1];
                                                }
                                                
                                                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
                                            @endphp
                                            
                                            <div class="relative aspect-video bg-black cursor-pointer" onclick="window.open('{{ $video->video_url }}', '_blank')">
                                                @if($thumbnailUrl)
                                                    <img src="{{ $thumbnailUrl }}" 
                                                        alt="{{ $video->title }} thumbnail"
                                                        class="w-full h-full object-cover"
                                                        onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
                                                @else
                                                    <!-- Fallback for non-YouTube videos -->
                                                    <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                
                                                <!-- YouTube Play Button Overlay -->
                                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    @if($videoId)
                                                        <!-- YouTube Play Button -->
                                                        <div class="bg-red-600 rounded-full p-4 transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                                            <svg class="h-8 w-8 text-white ml-1" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <!-- Generic Play Button -->
                                                        <div class="bg-white bg-opacity-90 rounded-full p-4 transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Video Duration Badge -->
                                                @if($video->duration)
                                                    <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                                                        {{ $video->duration }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- Video Info Section -->
                                        <div class="p-4 md:p-6">
                                            <div class="flex items-start space-x-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 md:h-6 w-5 md:w-6 text-red-600 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1 md:mb-2 text-base md:text-lg leading-tight">
                                                        {{ $video->title }}
                                                    </h4>
                                                    @if($video->description)
                                                        <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm mb-2 md:mb-3 line-clamp-2">
                                                            {{ $video->description }}
                                                        </p>
                                                    @endif
                                                    
                                                    <!-- Video Metadata -->
                                                    <div class="flex items-center justify-between mt-3">
                                                        @if($video->video_url)
                                                            <a href="{{ $video->video_url }}" 
                                                            target="_blank"
                                                            class="inline-flex items-center space-x-2 px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                                                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-sm leading-normal transition-colors duration-200">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span>Watch Video</span>
                                                            </a>
                                                        @endif
                                                        
                                                        <!-- Additional Info -->
                                                        <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                                            @if($video->created_at)
                                                                <span>{{ $video->created_at->format('M d, Y') }}</span>
                                                            @endif
                                                            @if($video->views)
                                                                <span class="flex items-center space-x-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    <span>{{ $video->views }}</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- FAQ Tab -->
                    <div id="faq" class="tab-content hidden">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3 md:gap-0">
                            <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200 text-center md:text-left">Frequently Asked Questions</h3>
                            @if($faqs->isNotEmpty())
                                <div class="relative w-full md:w-auto">
                                    <input type="text" id="faqSearch" placeholder="Search FAQs..." 
                                           class="w-full md:w-64 pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">
                                    <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        @if($faqs->isEmpty())
                            <div class="text-center py-6 md:py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16 mx-auto text-gray-400 mb-3 md:mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No FAQs available yet.</p>
                            </div>
                        @else
                            <div id="faqList" class="space-y-3 md:space-y-4">
                                @foreach($faqs as $faq)
                                    <div class="faq-item bg-gray-50 dark:bg-gray-700 rounded-lg p-3 md:p-4 hover:bg-blue-50 dark:hover:bg-gray-600 transition-colors">
                                        <button onclick="toggleFaq({{ $faq->id }})" 
                                                class="w-full text-left flex justify-between items-center focus:outline-none">
                                            <h4 class="font-medium text-gray-800 dark:text-gray-200 pr-3 md:pr-4 text-sm md:text-base">{{ $faq->title }}</h4>
                                            <svg id="faq-icon-{{ $faq->id }}" xmlns="http://www.w3.org/2000/svg" class="h-4 md:h-5 w-4 md:w-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div id="faq-content-{{ $faq->id }}" class="mt-2 md:mt-3 text-gray-600 dark:text-gray-400 hidden text-sm md:text-base">
                                            {!! nl2br(e($faq->content)) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- User Guide Tab -->
                    <div id="user-guide" class="tab-content hidden">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 md:mb-6 text-center md:text-left">User Guides</h3>
                        @if($userGuides->isEmpty())
                            <div class="text-center py-6 md:py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16 mx-auto text-gray-400 mb-3 md:mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No user guides available yet.</p>
                            </div>
                        @else
                            <!-- REVISION 2: 2 columns for user guides on larger screens -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                                @foreach($userGuides as $guide)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 md:p-6 hover:bg-green-50 dark:hover:bg-gray-600 transition-colors">
                                        <div class="flex items-start space-x-3 mb-3 md:mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 md:h-6 w-5 md:w-6 text-green-600 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1 md:mb-2 text-base md:text-lg">{{ $guide->title }}</h4>
                                                @if($guide->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm mb-3 md:mb-4">{{ $guide->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @if($guide->steps && count($guide->steps) > 0)
                                            <ol class="space-y-2 md:space-y-3">
                                                @foreach($guide->steps as $index => $step)
                                                    <li class="flex items-start space-x-2 md:space-x-3">
                                                        <span class="flex-shrink-0 w-5 h-5 md:w-6 md:h-6 bg-blue-600 text-white text-xs md:text-sm rounded-full flex items-center justify-center font-medium">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        <span class="text-gray-700 dark:text-gray-300 text-xs md:text-sm">{{ $step }}</span>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Support Tab -->
                    <div id="support" class="tab-content hidden">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 md:mb-6 text-center md:text-left">Support Contacts</h3>
                        @if($supportContacts->isEmpty())
                            <div class="text-center py-6 md:py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16 mx-auto text-gray-400 mb-3 md:mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No support contacts available yet.</p>
                            </div>
                        @else
                            <!-- REVISION 1: 3 columns for support contacts on larger screens -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                                @foreach($supportContacts as $contact)
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 md:p-6 border border-blue-200 dark:border-gray-600 hover:shadow-md transition-all">
                                        <div class="flex items-start space-x-3 md:space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:h-8 w-6 md:w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 md:mb-3 text-base md:text-lg">{{ $contact->title }}</h4>
                                                @if($contact->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm mb-3 md:mb-4">{{ $contact->description }}</p>
                                                @endif
                                                <div class="space-y-1 md:space-y-2 text-xs md:text-sm">
                                                    @if($contact->contact_email)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 md:h-4 w-3 md:w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            <a href="mailto:{{ $contact->contact_email }}" class="text-blue-600 hover:text-blue-700 break-all">{{ $contact->contact_email }}</a>
                                                        </div>
                                                    @endif
                                                    @if($contact->contact_phone)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 md:h-4 w-3 md:w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            <a href="tel:{{ $contact->contact_phone }}" class="text-blue-600 hover:text-blue-700">{{ $contact->contact_phone }}</a>
                                                        </div>
                                                    @endif
                                                    @if($contact->contact_hours)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 md:h-4 w-3 md:w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="text-gray-700 dark:text-gray-300">{{ $contact->contact_hours }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <style>
            .tab-button {
                color: #6b7280;
                border-color: transparent;
            }
            .tab-button:hover {
                color: #374151;
                border-color: #d1d5db;
                background-color: #f9fafb;
            }
            .active-tab {
                color: #2563eb !important;
                border-color: #2563eb !important;
            }
            .tab-content {
                animation: fadeIn 0.3s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Mobile-specific styles */
            @media (max-width: 768px) {
                .tab-button {
                    border-bottom: 2px solid transparent;
                    margin-bottom: -2px;
                }
            }
            
            /* Line clamp utility for description text */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>

        <script>
            function showTab(tabName, event = null) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Remove active class from all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active-tab');
                });
                
                // Show selected tab content
                const tabContent = document.getElementById(tabName);
                if (tabContent) {
                    tabContent.classList.remove('hidden');
                }
                
                // Add active class to clicked tab button (desktop only)
                if (event && event.currentTarget) {
                    event.currentTarget.classList.add('active-tab');
                } else {
                    // Find the button with matching data-tab attribute
                    const tabButton = document.querySelector(`[data-tab="${tabName}"]`);
                    if (tabButton) {
                        tabButton.classList.add('active-tab');
                    }
                }
                
                // Update mobile dropdown to match selected tab
                const dropdown = document.getElementById('mobileTabDropdown');
                if (dropdown) {
                    dropdown.value = tabName;
                }
            }

            function toggleFaq(faqId) {
                const content = document.getElementById(`faq-content-${faqId}`);
                const icon = document.getElementById(`faq-icon-${faqId}`);
                
                if (content && icon) {
                    if (content.classList.contains('hidden')) {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            }

            // Initialize the page
            document.addEventListener('DOMContentLoaded', function() {
                // Set up tab button event listeners
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.addEventListener('click', function(e) {
                        const tabName = this.getAttribute('data-tab');
                        showTab(tabName, e);
                    });
                });
                
                // FAQ Search functionality
                const faqSearch = document.getElementById('faqSearch');
                if (faqSearch) {
                    faqSearch.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const faqItems = document.querySelectorAll('.faq-item');
                        
                        faqItems.forEach(item => {
                            const title = item.querySelector('h4')?.textContent.toLowerCase() || '';
                            const content = item.querySelector('[id^="faq-content-"]')?.textContent.toLowerCase() || '';
                            
                            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }

                // Mobile dropdown functionality
                const mobileDropdown = document.getElementById('mobileTabDropdown');
                if (mobileDropdown) {
                    mobileDropdown.addEventListener('change', function() {
                        showTab(this.value);
                    });
                }

                // Initialize first tab as active
                showTab('tutorial-videos');
            });
        </script>
    </x-slot>
</x-app-layout>