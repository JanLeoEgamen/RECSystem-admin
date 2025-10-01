<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .privacy-section {
            scroll-margin-top: 100px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .privacy-section.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hover transforms */
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .hover-scale-sm {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        
        .hover-scale-sm:hover {
            transform: scale(1.05);
        }

        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Navigation link hover effects */
        .nav-link {
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-link:hover {
            transform: translateX(4px);
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 2px;
            background: #5e6ffb;
            transition: width 0.2s ease;
        }
        
        .nav-link:hover::before {
            width: 4px;
        }

        /* Button hover effects */
        .btn-hover {
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(94, 111, 251, 0.3);
        }
    </style>

    <!-- <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('applicant.dashboard') }}" 
            class="inline-flex items-center px-4 py-2 bg-[#101966] text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Application
        </a>
    </div> -->

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-[#101966] via-[#5e6ffb] to-[#1A25A1] rounded-2xl shadow-2xl mb-8 hover-scale">
                <div class="relative overflow-hidden">
                    <!-- Radio Wave Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(350, 30)">
                                <circle cx="0" cy="0" r="15" stroke="white" stroke-width="1.5" fill="none" opacity="0.4"/>
                                <circle cx="0" cy="0" r="25" stroke="white" stroke-width="1" fill="none" opacity="0.3"/>
                                <circle cx="0" cy="0" r="35" stroke="white" stroke-width="0.8" fill="none" opacity="0.2"/>
                                <circle cx="0" cy="0" r="3" fill="white" opacity="0.5"/>
                            </g>
                            <g transform="translate(50, 170)">
                                <circle cx="0" cy="0" r="20" stroke="white" stroke-width="1.5" fill="none" opacity="0.3"/>
                                <circle cx="0" cy="0" r="30" stroke="white" stroke-width="1" fill="none" opacity="0.2"/>
                                <circle cx="0" cy="0" r="3" fill="white" opacity="0.4"/>
                            </g>
                        </svg>
                    </div>
                    
                    <div class="relative z-10 px-8 py-12 text-center">
                        <div class="mb-6">
                            <div class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full backdrop-blur-sm hover-scale-sm hover:bg-opacity-30 transition-all duration-300">
                                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-white font-semibold text-lg">Data Privacy & Security</span>
                            </div>
                        </div>
                        
                        <h1 class="text-4xl font-bold text-white mb-4">Privacy Policy</h1>
                        <p class="text-xl text-white text-opacity-90 max-w-3xl mx-auto leading-relaxed">
                            Radio Engineering Circle Incorporated Membership Information Management System
                        </p>
                        <p class="text-lg text-white text-opacity-80 mt-4">
                            Protecting your personal information in compliance with the Data Privacy Act of 2012
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Table of Contents - Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#5e6ffb]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Table of Contents
                        </h3>
                        <nav class="space-y-2">
                            <a href="#overview" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Overview</a>
                            <a href="#information-collected" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Information We Collect</a>
                            <a href="#purpose" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Purpose of Collection</a>
                            <a href="#data-sharing" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Data Sharing & Access</a>
                            <a href="#data-storage" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Data Storage & Retention</a>
                            <a href="#rights" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Rights of Data Subjects</a>
                            <a href="#security" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Security Measures</a>
                            <a href="#contact" class="nav-link block text-sm text-gray-600 dark:text-gray-300 hover:text-[#5e6ffb] dark:hover:text-[#5e6ffb] hover:bg-gray-50 dark:hover:bg-gray-700 rounded px-2 py-1">Contact Information</a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Overview Section -->
                    <section id="overview" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Privacy Statement</h2>
                        </div>
                        <div class="flex items-start p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 hover-scale-sm hover:bg-blue-100 dark:hover:bg-blue-900/30">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-md text-justify">
                                The <strong class="text-gray-900 dark:text-white"> Radio Engineering Circle Inc.</strong> values your privacy and is committed to protecting the personal information you provide through this Membership Management System. This Privacy Policy outlines how we collect, use, store, and safeguard your personal data in compliance with the <strong class="text-gray-900 dark:text-white">Data Privacy Act of 2012 (Republic Act Number 10173)</strong> of the Republic of the Philippines.
                            </p>
                        </div>
                    </section>

                    <!-- Information We Collect -->
                    <section id="information-collected" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Information We Collect</h2>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            In the course of your membership application and registration, the Radio Engineering Circle Incorporated may collect the following personal information:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg border-l-4 border-[#5e6ffb] card-hover hover:bg-blue-100 dark:hover:bg-gray-600">
                                <h3 class="font-semibold text-[#101966] dark:text-[#5e6ffb] mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Personal Identification
                                </h3>
                                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                    <li>• Last name, first name, middle name, suffix</li>
                                    <li>• Sex, date of birth, civil status</li>
                                    <li>• Citizenship and blood type</li>
                                </ul>
                            </div>

                            <div class="bg-green-50 dark:bg-gray-700 p-6 rounded-lg border-l-4 border-green-500 card-hover hover:bg-green-100 dark:hover:bg-gray-600">
                                <h3 class="font-semibold text-green-700 dark:text-green-400 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Contact Information
                                </h3>
                                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                    <li>• Cellphone and telephone numbers</li>
                                    <li>• Email address</li>
                                    <li>• Complete address details</li>
                                </ul>
                            </div>

                            <div class="bg-yellow-50 dark:bg-gray-700 p-6 rounded-lg border-l-4 border-yellow-500 card-hover hover:bg-yellow-100 dark:hover:bg-gray-600">
                                <h3 class="font-semibold text-yellow-700 dark:text-yellow-400 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Emergency Contact
                                </h3>
                                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                    <li>• Emergency contact name</li>
                                    <li>• Contact number</li>
                                    <li>• Relationship to applicant</li>
                                </ul>
                            </div>

                            <div class="bg-purple-50 dark:bg-gray-700 p-6 rounded-lg border-l-4 border-purple-500 card-hover hover:bg-purple-100 dark:hover:bg-gray-600">
                                <h3 class="font-semibold text-purple-700 dark:text-purple-400 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Membership & Licensing
                                </h3>
                                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                    <li>• Application status and reference number</li>
                                    <li>• License details and callsign</li>
                                    <li>• License expiration and status</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Purpose of Collection -->
                    <section id="purpose" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Purpose of Collection</h2>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            Your personal information is collected and processed for the following purposes:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700 border border-blue-500 rounded-lg hover-scale-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="bg-[#5e6ffb] p-2 rounded-lg mr-4 mt-1 hover-scale-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">To verify and validate membership applications</span>
                            </div>
                            
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700 border border-blue-500 rounded-lg hover-scale-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="bg-[#5e6ffb] p-2 rounded-lg mr-4 mt-1 hover-scale-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">To maintain accurate records of members</span>
                            </div>
                            
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700 border border-blue-500 rounded-lg hover-scale-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="bg-[#5e6ffb] p-2 rounded-lg mr-4 mt-1 hover-scale-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">To facilitate communication and updates</span>
                            </div>
                            
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700 border border-blue-500 rounded-lg hover-scale-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="bg-[#5e6ffb] p-2 rounded-lg mr-4 mt-1 hover-scale-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">To process licensing requests and renewals</span>
                            </div>
                        </div>
                    </section>

                    <!-- Data Sharing & Access -->
                    <section id="data-sharing" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Data Sharing and Access</h2>
                        </div>
                        
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 hover-scale-sm hover:bg-red-100 dark:hover:bg-red-900/30">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-red-800 dark:text-red-300 mb-2">Strict Access Control</h3>
                                    <p class="text-red-700 dark:text-red-400">
                                        Access to your personal data is strictly limited to authorized officers and administrators of the Radio Engineering Circle Incorporated. Your information shall not be sold, shared, or disclosed to third parties without your consent, unless required by law or a competent authority.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Data Storage & Retention -->
                    <section id="data-storage" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Data Storage and Retention</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500 hover-scale-sm hover:bg-blue-100 dark:hover:bg-blue-900/30">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-gray-700 dark:text-gray-300">
                                    Your personal information will be stored in a secure environment within this Membership Management System.
                                </p>
                            </div>
                            
                            <div class="flex items-start p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500 hover-scale-sm hover:bg-green-100 dark:hover:bg-green-900/30">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-700 dark:text-gray-300">
                                    Records shall be retained only for as long as necessary to fulfill the purposes stated above or as required by law.
                                </p>
                            </div>
                            
                            <div class="flex items-start p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border-l-4 border-purple-500 hover-scale-sm hover:bg-purple-100 dark:hover:bg-purple-900/30">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <p class="text-gray-700 dark:text-gray-300">
                                    Upon termination of membership, you may formally request the deletion of your data, subject to applicable organizational and legal requirements.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Rights of Data Subjects -->
                    <section id="rights" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l-3-3m3 3l3-3"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Rights of Data Subjects</h2>
                        </div>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            In accordance with the <strong class="text-gray-900 dark:text-white">Data Privacy Act of 2012</strong>, you, as a data subject, have the right to:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-500 rounded-lg hover-scale-sm hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/30 dark:hover:to-indigo-900/30">
                                <div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-full mr-4 hover-scale-sm">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Access the personal information that we hold about you</span>
                            </div>
                            
                            <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-500 rounded-lg hover-scale-sm hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30">
                                <div class="bg-green-100 dark:bg-green-800 p-2 rounded-full mr-4 hover-scale-sm">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Request correction of any inaccurate or outdated data</span>
                            </div>
                            
                            <div class="flex items-center p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-500 rounded-lg hover-scale-sm hover:from-red-100 hover:to-pink-100 dark:hover:from-red-900/30 dark:hover:to-pink-900/30">
                                <div class="bg-red-100 dark:bg-red-800 p-2 rounded-full mr-4 hover-scale-sm">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Request deletion of your personal data</span>
                            </div>
                            
                            <div class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 border border-violet-500 rounded-lg hover-scale-sm hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-900/30 dark:hover:to-violet-900/30">
                                <div class="bg-purple-100 dark:bg-purple-800 p-2 rounded-full mr-4 hover-scale-sm">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364L18.364 5.636"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Withdraw consent to data processing</span>
                            </div>
                            
                            <div class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 border border-orange-500 rounded-lg hover-scale-sm hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-900/30 dark:hover:to-amber-900/30">
                                <div class="bg-orange-100 dark:bg-orange-800 p-2 rounded-full mr-4 hover-scale-sm">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">File a complaint with the National Privacy Commission</span>
                            </div>
                        </div>
                    </section>

                    <!-- Security Measures -->
                    <section id="security" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Security Measures</h2>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 p-6 rounded-lg border border-green-200 dark:border-green-800 hover-scale-sm hover:from-green-100 hover:to-blue-100 dark:hover:from-green-900/30 dark:hover:to-blue-900/30">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                The Radio Engineering Circle Incorporated implements <strong class="text-gray-900 dark:text-white">organizational, physical, and technical measures</strong> to ensure the confidentiality, integrity, and availability of your personal information, and to safeguard it against loss, unauthorized access, alteration, disclosure, or misuse.
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div class="text-center p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg card-hover hover:bg-blue-100 dark:hover:bg-blue-900/30 border border-blue-200 dark:border-blue-800">
                                <div class="bg-blue-100 dark:bg-blue-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 hover-scale-sm">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-blue-700 dark:text-blue-300 mb-2">Organizational</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Access controls and staff training</p>
                            </div>
                            
                            <div class="text-center p-6 bg-green-50 dark:bg-green-900/20 rounded-lg card-hover hover:bg-green-100 dark:hover:bg-green-900/30 border border-green-200 dark:border-green-800">
                                <div class="bg-green-100 dark:bg-green-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 hover-scale-sm">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-green-700 dark:text-green-300 mb-2">Physical</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Secure facilities and equipment</p>
                            </div>
                            
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg card-hover hover:bg-purple-100 dark:hover:bg-purple-900/30 border border-purple-200 dark:border-purple-800">
                                <div class="bg-purple-100 dark:bg-purple-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 hover-scale-sm">
                                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-purple-700 dark:text-purple-300 mb-2">Technical</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Encryption and secure systems</p>
                            </div>
                        </div>
                    </section>

                    <!-- Contact Information -->
                    <section id="contact" class="privacy-section bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 hover-scale border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-3 rounded-lg mr-4 hover-scale-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#101966] to-[#5e6ffb] bg-clip-text text-transparent dark:from-blue-300 dark:to-indigo-300">Contact Information</h2>
                        </div>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            For any questions, concerns, or requests relating to this Privacy Policy or to the exercise of your rights under the Data Privacy Act, you may contact us through the following:
                        </p>
                        
                        <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-8 rounded-lg text-white hover-scale">
                            <h3 class="text-2xl font-bold mb-4 text-center">Radio Engineering Circle Incorporated</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            
                                <div class="flex flex-col items-center hover-scale-sm">
                                    <div class="bg-white bg-opacity-20 p-3 rounded-full mb-3 hover-scale-sm hover:bg-opacity-30">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold mb-2">Email</h4>
                                    <p class="text-white text-opacity-90">radio@rec.org.ph</p>
                                </div>

                                <div class="flex flex-col items-center hover-scale-sm">
                                    <div class="bg-white bg-opacity-20 p-3 rounded-full mb-3 hover-scale-sm hover:bg-opacity-30">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold mb-2">Address</h4>
                                    <p class="text-white text-opacity-90">Room 407 Building A, Polytechnic University of the Philippines-Taguig Campus, 
                                        General Santos Avenue, Lower Bicutan, Taguig, Philippines</p>
                                </div>
                                
                                <div class="flex flex-col items-center hover-scale-sm">
                                    <div class="bg-white bg-opacity-20 p-3 rounded-full mb-3 hover-scale-sm hover:bg-opacity-30">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold mb-2">Phone</h4>
                                    <p class="text-white text-opacity-90">+63 917 541 8836</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Last Updated Notice -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 text-center hover-scale-sm hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            This Privacy Policy is effective as of <strong class="text-gray-900 dark:text-white">{{ now()->format('F d, Y') }}</strong> and may be updated from time to time.
                            <br>
                            Please review this policy periodically for any changes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-[#5e6ffb] hover:bg-[#101966] text-white p-3 rounded-full shadow-lg btn-hover opacity-0 pointer-events-none z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                scrollToTopBtn.classList.add('opacity-100');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                scrollToTopBtn.classList.remove('opacity-100');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Scroll-triggered animations for sections
        const observerOptions = {
            root: null,
            rootMargin: '-10% 0px -10% 0px',
            threshold: 0.1
        };

        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe all privacy sections for animation
        document.querySelectorAll('.privacy-section').forEach(section => {
            animationObserver.observe(section);
        });

        // Highlight active section in navigation
        const navigationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const navLink = document.querySelector(`a[href="#${entry.target.id}"]`);
                if (entry.isIntersecting) {
                    document.querySelectorAll('nav a').forEach(link => {
                        link.classList.remove('text-[#5e6ffb]', 'font-semibold');
                        link.classList.add('text-gray-600', 'dark:text-gray-300');
                    });
                    if (navLink) {
                        navLink.classList.remove('text-gray-600', 'dark:text-gray-300');
                        navLink.classList.add('text-[#5e6ffb]', 'font-semibold');
                    }
                }
            });
        }, {
            root: null,
            rootMargin: '-20% 0px -80% 0px',
            threshold: 0
        });

        document.querySelectorAll('.privacy-section').forEach(section => {
            navigationObserver.observe(section);
        });
    </script>
</x-app-layout>