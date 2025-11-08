<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center gap-4 justify-center md:justify-start">
                <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl md:text-3xl text-white dark:text-gray-200 leading-tight">
                        Super Admin Manual
                    </h2>
                    <p class="text-sm text-white/80 dark:text-gray-300 mt-1">Help and Support Resources</p>
                </div>
            </div>

            @can('edit manuals')
                <a href="{{ route('manual.index') }}" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full md:w-auto">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modify Manual
                </a>
          @endcan
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tab Navigation Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl mb-6 md:mb-8 overflow-hidden border border-gray-100 dark:border-gray-700">
                <!-- Mobile Dropdown -->
                <div class="md:hidden p-4 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-600">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Select Section</label>
                    <select id="mobileTabDropdown" class="w-full p-3 border-2 border-indigo-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="tutorial-videos">📹 Tutorial Videos</option>
                        <option value="faq">❓ FAQ</option>
                        <option value="user-guide">📖 User Guide</option>
                        <option value="support">💬 Support</option>
                    </select>
                </div>
                
                <!-- Desktop Tabs -->
                <div class="hidden md:block bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-600">
                    <nav class="flex justify-center px-4 md:px-6" aria-label="Tabs">
                        <div class="flex space-x-2">
                            <button data-tab="tutorial-videos" 
                                    class="tab-button active-tab py-4 px-6 font-semibold text-sm rounded-t-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Tutorial Videos</span>
                            </button>
                            <button data-tab="faq" 
                                    class="tab-button py-4 px-6 font-semibold text-sm rounded-t-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>FAQ</span>
                            </button>
                            <button data-tab="user-guide" 
                                    class="tab-button py-4 px-6 font-semibold text-sm rounded-t-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>User Guide</span>
                            </button>
                            <button data-tab="support" 
                                    class="tab-button py-4 px-6 font-semibold text-sm rounded-t-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
                                </svg>
                                <span>Support</span>
                            </button>
                        </div>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6 md:p-8 bg-white dark:bg-gray-800">                  
                    <!-- Tutorial Videos Tab -->
                    <div id="tutorial-videos" class="tab-content">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-red-500 to-pink-600 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">Tutorial Videos</h3>
                        </div>
                        @if($tutorialVideos->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-full w-20 h-20 mx-auto mb-4 shadow-lg">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No tutorial videos available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach($tutorialVideos as $video)
                                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-600 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-600 group">
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
                                                    <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                                        <svg class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                    @if($videoId)
                                                        <div class="bg-red-600 rounded-full p-5 transform scale-90 group-hover:scale-110 transition-transform duration-300 shadow-2xl">
                                                            <svg class="h-10 w-10 text-white ml-1" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="bg-white rounded-full p-5 transform scale-90 group-hover:scale-110 transition-transform duration-300 shadow-2xl">
                                                            <svg class="h-10 w-10 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($video->duration)
                                                    <div class="absolute bottom-3 right-3 bg-black/80 text-white text-xs px-3 py-1 rounded-lg font-semibold backdrop-blur-sm">
                                                        {{ $video->duration }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <div class="p-5">
                                            <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-2 text-lg leading-tight line-clamp-2">
                                                {{ $video->title }}
                                            </h4>
                                            @if($video->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                                    {{ $video->description }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                                @if($video->video_url)
                                                    <a href="{{ $video->video_url }}" 
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Watch Video</span>
                                                    </a>
                                                @endif
                                                
                                                <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                                    @if($video->created_at)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ $video->created_at->format('M d, Y') }}
                                                        </span>
                                                    @endif
                                                    @if($video->views)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            {{ $video->views }}
                                                        </span>
                                                    @endif
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
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">Frequently Asked Questions</h3>
                            </div>
                            @if($faqs->isNotEmpty())
                                <div class="relative w-full md:w-80">
                                    <input type="text" id="faqSearch" placeholder="Search FAQs..." 
                                           class="w-full pl-10 pr-4 py-3 border-2 border-green-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        @if($faqs->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-full w-20 h-20 mx-auto mb-4 shadow-lg">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No FAQs available yet.</p>
                            </div>
                        @else
                            <div id="faqList" class="space-y-4">
                                @foreach($faqs as $faq)
                                    <div class="faq-item bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-600">
                                        <button onclick="toggleFaq({{ $faq->id }})" 
                                                class="w-full text-left flex justify-between items-center focus:outline-none group">
                                            <div class="flex items-start gap-3 flex-1 pr-4">
                                                <div class="flex-shrink-0 mt-1">
                                                    <div class="p-2 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-lg">
                                                        <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-base md:text-lg group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                                    {{ $faq->title }}
                                                </h4>
                                            </div>
                                            <svg id="faq-icon-{{ $faq->id }}" class="h-6 w-6 text-green-600 dark:text-green-400 transform transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div id="faq-content-{{ $faq->id }}" class="mt-4 ml-14 text-gray-600 dark:text-gray-400 hidden text-sm md:text-base leading-relaxed bg-white/50 dark:bg-gray-800/50 rounded-lg p-4 border-l-4 border-green-500">
                                            {!! nl2br(e($faq->content)) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- User Guide Tab -->
                    <div id="user-guide" class="tab-content hidden">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">User Guides</h3>
                        </div>
                        @if($userGuides->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-full w-20 h-20 mx-auto mb-4 shadow-lg">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No user guides available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach($userGuides as $guide)
                                    <div class="bg-gradient-to-br from-white to-indigo-50 dark:from-gray-700 dark:to-indigo-900/20 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 border border-indigo-100 dark:border-gray-600">
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="flex-shrink-0">
                                                <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-2 text-lg">{{ $guide->title }}</h4>
                                                @if($guide->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $guide->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @if($guide->steps && count($guide->steps) > 0)
                                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-5 border-l-4 border-indigo-500">
                                                <ol class="space-y-3">
                                                    @foreach($guide->steps as $index => $step)
                                                        <li class="flex items-start gap-3">
                                                            <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-indigo-600 to-purple-600 text-white text-sm rounded-full flex items-center justify-center font-bold shadow-md">
                                                                {{ $index + 1 }}
                                                            </span>
                                                            <span class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed pt-0.5">{{ $step }}</span>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Support Tab -->
                    <div id="support" class="tab-content hidden">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
                                </svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">Support Contacts</h3>
                        </div>
                        @if($supportContacts->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-full w-20 h-20 mx-auto mb-4 shadow-lg">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No support contacts available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($supportContacts as $contact)
                                    <div class="bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-50 dark:from-blue-900/20 dark:via-cyan-900/20 dark:to-blue-900/20 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-blue-200 dark:border-gray-600">
                                        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </div>
                                                <h4 class="font-bold text-white text-lg">{{ $contact->title }}</h4>
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            @if($contact->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">{{ $contact->description }}</p>
                                            @endif
                                            <div class="space-y-3">
                                                @if($contact->contact_email)
                                                    <div class="flex items-start gap-3 bg-white/70 dark:bg-gray-800/50 rounded-lg p-3 border-l-4 border-blue-500">
                                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <a href="mailto:{{ $contact->contact_email }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm break-all">{{ $contact->contact_email }}</a>
                                                    </div>
                                                @endif
                                                @if($contact->contact_phone)
                                                    <div class="flex items-start gap-3 bg-white/70 dark:bg-gray-800/50 rounded-lg p-3 border-l-4 border-green-500">
                                                        <svg class="h-5 w-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <a href="tel:{{ $contact->contact_phone }}" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium text-sm">{{ $contact->contact_phone }}</a>
                                                    </div>
                                                @endif
                                                @if($contact->contact_hours)
                                                    <div class="flex items-start gap-3 bg-white/70 dark:bg-gray-800/50 rounded-lg p-3 border-l-4 border-amber-500">
                                                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span class="text-gray-700 dark:text-gray-300 font-medium text-sm">{{ $contact->contact_hours }}</span>
                                                    </div>
                                                @endif
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
                background-color: transparent;
                border: none;
            }
            .tab-button:hover {
                color: #4f46e5;
                background-color: rgba(99, 102, 241, 0.1);
                transform: translateY(-2px);
            }
            .active-tab {
                color: #4f46e5 !important;
                background-color: white !important;
                box-shadow: 0 -2px 10px rgba(99, 102, 241, 0.1);
            }
            .dark .active-tab {
                background-color: #1f2937 !important;
            }
            .tab-content {
                animation: fadeIn 0.4s ease-in-out;
            }
            @keyframes fadeIn {
                from { 
                    opacity: 0; 
                    transform: translateY(15px); 
                }
                to { 
                    opacity: 1; 
                    transform: translateY(0); 
                }
            }
            
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Enhanced scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
            .dark ::-webkit-scrollbar-track {
                background: #374151;
            }
            .dark ::-webkit-scrollbar-thumb {
                background: #4b5563;
            }
            .dark ::-webkit-scrollbar-thumb:hover {
                background: #6b7280;
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