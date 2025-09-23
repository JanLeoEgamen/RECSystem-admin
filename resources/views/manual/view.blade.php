<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Super Admin Manual Help and Support') }}
            </h2>
            @can('edit manuals')
                <a href="{{ route('manual.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit</span>
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 rounded-xl shadow-xl mb-8 overflow-hidden">
                <div class="px-8 py-12 text-center">
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-white opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        Super Admin Help and Support
                    </h1>
                    <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                        Comprehensive guide for Membership Information Management System
                    </p>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('tutorial-videos')" 
                                class="tab-button active-tab py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m2-10V7a3 3 0 11-6 0V4a3 3 0 016 0zM7 21h10a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Tutorial Videos</span>
                            </div>
                        </button>
                        <button onclick="showTab('faq')" 
                                class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>FAQ</span>
                            </div>
                        </button>
                        <button onclick="showTab('user-guide')" 
                                class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>User Guide</span>
                            </div>
                        </button>
                        <button onclick="showTab('support')" 
                                class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Support</span>
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <!-- Tutorial Videos Tab -->
                    <div id="tutorial-videos" class="tab-content">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Tutorial Videos</h3>
                        @if($tutorialVideos->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No tutorial videos available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($tutorialVideos as $video)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-start space-x-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1" />
                                            </svg>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $video->title }}</h4>
                                                @if($video->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $video->description }}</p>
                                                @endif
                                                @if($video->video_url)
                                                    <a href="{{ $video->video_url }}" 
                                                       target="_blank"
                                                       class="inline-flex items-center space-x-1 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                        <span>Watch Video</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- FAQ Tab -->
                    <div id="faq" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Frequently Asked Questions</h3>
                            @if($faqs->isNotEmpty())
                                <div class="relative">
                                    <input type="text" id="faqSearch" placeholder="Search FAQs..." 
                                           class="pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">
                                    <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        @if($faqs->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No FAQs available yet.</p>
                            </div>
                        @else
                            <div id="faqList" class="space-y-4">
                                @foreach($faqs as $faq)
                                    <div class="faq-item bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <button onclick="toggleFaq({{ $faq->id }})" 
                                                class="w-full text-left flex justify-between items-center focus:outline-none">
                                            <h4 class="font-medium text-gray-800 dark:text-gray-200 pr-4">{{ $faq->title }}</h4>
                                            <svg id="faq-icon-{{ $faq->id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div id="faq-content-{{ $faq->id }}" class="mt-3 text-gray-600 dark:text-gray-400 hidden">
                                            {!! nl2br(e($faq->content)) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- User Guide Tab -->
                    <div id="user-guide" class="tab-content hidden">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">User Guides</h3>
                        @if($userGuides->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No user guides available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach($userGuides as $guide)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                        <div class="flex items-start space-x-3 mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $guide->title }}</h4>
                                                @if($guide->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $guide->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @if($guide->steps && count($guide->steps) > 0)
                                            <ol class="space-y-3">
                                                @foreach($guide->steps as $index => $step)
                                                    <li class="flex items-start space-x-3">
                                                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white text-sm rounded-full flex items-center justify-center font-medium">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $step }}</span>
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
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Support Contacts</h3>
                        @if($supportContacts->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No support contacts available yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($supportContacts as $contact)
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-6 border border-blue-200 dark:border-gray-600">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">{{ $contact->title }}</h4>
                                                @if($contact->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $contact->description }}</p>
                                                @endif
                                                <div class="space-y-2 text-sm">
                                                    @if($contact->contact_email)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            <a href="mailto:{{ $contact->contact_email }}" class="text-blue-600 hover:text-blue-700">{{ $contact->contact_email }}</a>
                                                        </div>
                                                    @endif
                                                    @if($contact->contact_phone)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            <a href="tel:{{ $contact->contact_phone }}" class="text-blue-600 hover:text-blue-700">{{ $contact->contact_phone }}</a>
                                                        </div>
                                                    @endif
                                                    @if($contact->contact_hours)
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
        </style>

        <script>
            function showTab(tabName) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Remove active class from all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active-tab');
                });
                
                // Show selected tab content
                document.getElementById(tabName).classList.remove('hidden');
                
                // Add active class to clicked tab button
                event.target.closest('.tab-button').classList.add('active-tab');
            }

            function toggleFaq(faqId) {
                const content = document.getElementById(`faq-content-${faqId}`);
                const icon = document.getElementById(`faq-icon-${faqId}`);
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    content.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            }

            // FAQ Search functionality
            document.getElementById('faqSearch')?.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const faqItems = document.querySelectorAll('.faq-item');
                
                faqItems.forEach(item => {
                    const title = item.querySelector('h4').textContent.toLowerCase();
                    const content = item.querySelector('[id^="faq-content-"]').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Initialize first tab as active
            document.addEventListener('DOMContentLoaded', function() {
                showTab('tutorial-videos');
            });
        </script>
    </x-slot>
</x-app-layout>