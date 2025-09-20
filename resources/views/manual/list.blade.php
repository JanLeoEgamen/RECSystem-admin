<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Super Admin Manual Help and Support') }}">
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-[#101966] to-blue-600 text-white p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-xl mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Super Admin Help and Support</h1>
                    <p class="text-blue-100">Comprehensive guide for Membership Information Management System</p>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Navigation Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                        <ul class="flex flex-wrap justify-center -mb-px text-sm font-medium text-center" id="manualTabs" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 border-blue-600 dark:border-blue-500" 
                                        id="videos-tab" data-tabs-target="#videos" type="button" role="tab">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                    Tutorial Videos
                                </button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                                        id="faq-tab" data-tabs-target="#faq" type="button" role="tab">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    FAQ
                                </button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                                        id="guide-tab" data-tabs-target="#guide" type="button" role="tab">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    User Guide
                                </button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                                        id="support-tab" data-tabs-target="#support" type="button" role="tab">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd" />
                                    </svg>
                                    Support
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div id="manualTabsContent">
                        <!-- Tutorial Videos Tab -->
                        <div class="block" id="videos" role="tabpanel">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 transition-transform hover:scale-105">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">How to: Use Super Admin </h4>
                                    </div>
                                    <div class="bg-black rounded-lg aspect-video mb-4 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        <!-- Replace with your actual video embed -->
                                        <!-- <iframe src="your-video-url" class="w-full h-full rounded-lg" frameborder="0" allowfullscreen></iframe> -->
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">Learn the basics of navigating the admin dashboard and understanding core features.</p>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        Watch Now
                                    </button>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 transition-transform hover:scale-105">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">How to: Use Member Portal</h4>
                                    </div>
                                    <div class="bg-black rounded-lg aspect-video mb-4 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        <!-- Replace with your actual video embed -->
                                        <!-- <iframe src="your-video-url" class="w-full h-full rounded-lg" frameborder="0" allowfullscreen></iframe> -->
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">Deep dive into member management, reports, and advanced system features.</p>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        Watch Now
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Tab -->
                        <div class="hidden" id="faq" role="tabpanel">
                            <div class="max-w-2xl mx-auto mb-6">
                                <div class="relative">
                                    <input type="text" id="faqSearch" placeholder="Search frequently asked questions..." 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <div id="faqContainer" class="space-y-4">
                                @foreach($faqs as $index => $faq)
                                <div class="faq-item bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden transition-all hover:shadow-md">
                                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $faq['question'] }}</span>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="faq-answer px-6 py-4 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-600 hidden">
                                        <p>{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- User Management Guide Tab -->
                        <div class="hidden" id="guide" role="tabpanel">
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach($userGuides as $index => $guide)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 transition-transform hover:scale-105">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            @if($index === 0)
                                                <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM9 18H7v-3a1 1 0 112 0v3zm4 0h-2v-3a1 1 0 112 0v3z" clip-rule="evenodd" />
                                            @elseif($index === 1)
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            @elseif($index === 2)
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            @else
                                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                            @endif
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">{{ $guide['title'] }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $guide['description'] }}</p>
                                    <ol class="space-y-3">
                                        @foreach($guide['steps'] as $step)
                                        <li class="flex items-start">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">
                                                {{ $loop->iteration }}
                                            </span>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $step }}</span>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Help & Support Tab -->
                        <div class="hidden" id="support" role="tabpanel">
                            <div class="text-center mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Need Help? We're Here for You!</h3>
                                <p class="text-gray-600 dark:text-gray-300">Contact our support team for any questions or issues</p>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                @foreach($supportContacts as $contact)
                                <div class="bg-gradient-to-r from-[#101966] to-blue-600 text-white rounded-lg p-6 text-center">
                                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            @if($contact['type'] === 'Technical Support')
                                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            @else
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold mb-4">{{ $contact['type'] }}</h4>
                                    <div class="space-y-2 mb-6">
                                        <p class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            {{ $contact['email'] }}
                                        </p>
                                        <p class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            {{ $contact['phone'] }}
                                        </p>
                                        <p class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $contact['hours'] }}
                                        </p>
                                    </div>
                                    <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                                        Contact Now
                                    </button>
                                </div>
                                @endforeach
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-6">Quick Support Resources</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h6 class="font-semibold text-gray-900 dark:text-white">Documentation</h6>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Detailed system docs</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                                            </svg>
                                        </div>
                                        <h6 class="font-semibold text-gray-900 dark:text-white">Live Chat</h6>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Instant support chat</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h6 class="font-semibold text-gray-900 dark:text-white">Submit Ticket</h6>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Report issues</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                            </svg>
                                        </div>
                                        <h6 class="font-semibold text-gray-900 dark:text-white">Video Call</h6>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Screen sharing support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab functionality
                const tabButtons = document.querySelectorAll('[data-tabs-target]');
                const tabContents = document.querySelectorAll('[role="tabpanel"]');

                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-tabs-target');
                        
                        // Remove active state from all tabs
                        tabButtons.forEach(btn => {
                            btn.classList.remove('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                            btn.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300', 'dark:hover:text-gray-300');
                        });
                        
                        // Add active state to clicked tab
                        button.classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                        button.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300', 'dark:hover:text-gray-300');
                        
                        // Hide all tab contents
                        tabContents.forEach(content => {
                            content.classList.add('hidden');
                            content.classList.remove('block');
                        });
                        
                        // Show target tab content
                        const targetContent = document.querySelector(targetId);
                        if (targetContent) {
                            targetContent.classList.remove('hidden');
                            targetContent.classList.add('block');
                        }
                    });
                });

                // FAQ Toggle Functionality
                document.querySelectorAll('.faq-question').forEach(button => {
                    button.addEventListener('click', () => {
                        const answer = button.nextElementSibling;
                        const icon = button.querySelector('svg');
                        
                        // Toggle answer visibility
                        if (answer.classList.contains('hidden')) {
                            // Close all other answers
                            document.querySelectorAll('.faq-answer').forEach(ans => {
                                ans.classList.add('hidden');
                            });
                            document.querySelectorAll('.faq-question svg').forEach(ic => {
                                ic.classList.remove('rotate-180');
                            });
                            
                            // Open current answer
                            answer.classList.remove('hidden');
                            icon.classList.add('rotate-180');
                        } else {
                            answer.classList.add('hidden');
                            icon.classList.remove('rotate-180');
                        }
                    });
                });

                // FAQ Search Functionality
                document.getElementById('faqSearch').addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const faqItems = document.querySelectorAll('.faq-item');
                    
                    faqItems.forEach(item => {
                        const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                        const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
                        
                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>