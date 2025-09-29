<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join REC Inc. - Radio Engineering Circle</title>
    <link rel="icon" href="/images/Logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <nav class="bg-[#101966] dark:bg-gray-950 backdrop-blur-md shadow-lg fixed w-full top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="/images/Logo.png" 
                        alt="REC Logo" 
                        class="h-10 w-10 object-contain transform transition-transform duration-300 hover:scale-110">
                    
                    <div>
                        <h1 class="text-xl font-bold text-gray-200 dark:text-gray-100" style="font-family: 'Dax-Regular';">
                            Radio Engineering Circle Inc.
                        </h1>
                        <p class="text-sm text-gray-400 dark:text-gray-400">
                            DZ1REC — <em>Connecting Radio Enthusiasts</em>
                        </p>
                    </div>
                </div>         
                
                <div class="nav-links hidden md:flex items-center space-x-6">
                    <a href="#features" class="text-gray-300 dark:text-gray-300 hover:text-blue-400 transition-colors">Features</a>
                    <a href="#benefits" class="text-gray-300 dark:text-gray-300 hover:text-blue-400 transition-colors">Benefits</a>
                    <a href="#community" class="text-gray-300 dark:text-gray-300 hover:text-blue-400 transition-colors">Community</a>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="https://centralized-website.rec.org.ph/rec-home-page" target="_blank" class="nav-website-btn btn-primary px-6 py-2 rounded-full text-white font-medium hidden md:block">Visit Our Website</a>
                </div>
            </div>
        </div>
    </nav>

    <div id="loading-screen" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden">
        <div class="flex flex-col items-center">
            <div class="relative w-24 h-24 flex items-center justify-center">
                <div class="w-6 h-6 bg-[#5e6ffb] rounded-full z-10"></div>
                <span class="absolute w-6 h-6 rounded-full border-4 border-[#101966] animate-wave"></span>
                <span class="absolute w-6 h-6 rounded-full border-4 border-[#1A25A1] animate-wave delay-200"></span>
                <span class="absolute w-6 h-6 rounded-full border-4 border-[#101966] animate-wave delay-400"></span>
            </div>
            <p class="mt-6 text-white font-medium">Please wait a moment...</p>
            
            <!-- progress bar -->
            <div class="w-64 h-2 bg-gray-700 rounded-full mt-4 overflow-hidden">
                <div id="loading-progress" class="h-full bg-blue-500 rounded-full transition-all duration-300"></div>
            </div>
        </div>
    </div>


    <section id="hero" 
        class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 
            min-h-screen flex items-center relative pt-20 transition-colors duration-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div class="hero-content text-gray-900 dark:text-gray-100">
                <div class="md:hidden mt-10 mb-6">
                    <a href="https://centralized-website.rec.org.ph/rec-home-page" target="_blank" 
                    class="btn-primary px-6 py-3 rounded-full text-white font-medium text-center block hover:scale-105 transition-transform">
                        Visit Our Website
                    </a>
                </div>
                
                <h1 class="text-4xl lg:text-6xl font-black mb-6 leading-tight">
                    Join the Future of 
                    <span class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] dark:bg-gradient-to-r dark:from-blue-600 dark:to-purple-600 bg-clip-text text-transparent">
                    Radio Engineering Circle Inc.
                    </span>
                </h1>
                
                <p class="text-xl lg:text-2xl mb-8 text-gray-600 dark:text-gray-300 leading-relaxed">
                    Connect with passionate radio enthusiasts, access exclusive resources, and advance your engineering journey with our vibrant community.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-12">
                    <a href="#features" 
                        class="relative px-8 py-4 rounded-full text-lg font-semibold inline-flex items-center justify-center space-x-2 
                            border-2 border-[#101966] text-[#101966] transition duration-300
                            hover:bg-[#101966] hover:text-white
                            dark:border-[#5e6ffb] dark:text-[#5e6ffb] dark:hover:bg-[#5e6ffb] dark:hover:text-white">
                        <span>Learn More</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Right Portal Box -->
            <div class="floating member-portal-container">
                <div class="hero-gradient backdrop-blur-lg p-8 rounded-3xl border border-white/20 shadow-2xl 
                            dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="text-center mb-6">
                        <img src="/images/Logo.png" alt="REC Logo" class="h-16 w-16 mx-auto mb-4">
                        <h3 class="text-2xl font-bold text-gray-100 dark:text-white mb-2">Member Portal</h3>
                        <p class="text-gray-200 dark:text-white/80">Access your dashboard and manage your membership</p>
                    </div>
                    
                    <div class="space-y-4">
                        <a href="/login" type="submit" class="portal-button portal-button-primary">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span>LOGIN</span>
                            </div>
                        </a>
                        
                        <a href="/register" class="portal-button">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span>REGISTER</span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-gray-100 dark:text-white/60 text-sm">Click the buttons above to access the portal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="features" 
        class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 
            dark:from-gray-900 dark:to-gray-800 
            transition-colors duration-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Title -->
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-gray-100 mt-20 mb-6">
                    Everything You Need in 
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        One Platform
                    </span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Our comprehensive membership portal provides all the tools and resources you need to make the most of your REC experience.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="feature-grid grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Card 1 -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-blue-100 
                            dark:from-gray-800 dark:to-gray-700 
                            p-8 rounded-2xl border border-blue-200 
                            dark:border-gray-600 reveal">
                    <div class="bg-blue-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Membership Management</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Easily manage your profile, view membership status, and update your information all in one place.</p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li>• Profile management</li>
                        <li>• Document uploads</li>
                        <li>• Status tracking</li>      
                    </ul>
                </div>

                <!-- Card 2 -->
                <div class="feature-card bg-gradient-to-br from-purple-50 to-purple-100 
                            dark:from-gray-800 dark:to-gray-700 
                            p-8 rounded-2xl border border-purple-200 
                            dark:border-gray-600 reveal">
                    <div class="bg-purple-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Event <br> Access</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Register for workshops, seminars, and technical sessions. Never miss an important event again.</p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li>• Reminders & notifications</li>
                        <li>• Event Announcements</li>
                        <li>• Easy registration</li>                    
                    </ul>
                </div>

                <!-- Card 3 -->
                <div class="feature-card bg-gradient-to-br from-green-50 to-green-100 
                            dark:from-gray-800 dark:to-gray-700 
                            p-8 rounded-2xl border border-green-200 
                            dark:border-gray-600 reveal">
                    <div class="bg-green-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Digital Certificates</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Download and share your membership certificates and achievement badges instantly.</p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">                       
                        <li>• Customizable templates</li>
                        <li>• Instant downloads</li>
                        <li>• Secure storage</li>                                              
                    </ul>
                </div>

                <!-- Card 4 -->
                <div class="feature-card bg-gradient-to-br from-orange-50 to-orange-100 
                            dark:from-gray-800 dark:to-gray-700 
                            p-8 rounded-2xl border border-orange-200 
                            dark:border-gray-600 reveal">
                    <div class="bg-orange-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Latest <br> Updates</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Stay informed with real-time announcements, news, and important updates from REC leadership.</p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li>• Priority announcements</li>
                        <li>• Real-time notifications</li>               
                        <li>• News Updates</li>                  
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <section id="benefits" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 mt-20 items-center">
                
                <div class="reveal">
                    <h2 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-gray-100 mb-8">
                        Why Choose 
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">REC Membership?</span>
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-500 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Expert Network Access</h3>
                                <p class="text-gray-600 dark:text-gray-300">Connect with industry professionals, experienced engineers, and radio enthusiasts from around the globe.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-500 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Exclusive Resources</h3>
                                <p class="text-gray-600 dark:text-gray-300">Access technical documentation, research papers, and educational materials not available elsewhere.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="bg-green-500 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Career Advancement</h3>
                                <p class="text-gray-600 dark:text-gray-300">Enhance your professional development through workshops, certifications, and networking opportunities.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="bg-orange-500 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">24/7 Support</h3>
                                <p class="text-gray-600 dark:text-gray-300">Get help when you need it with our dedicated support team and active community forums.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="reveal">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Ready to Get Started?</h3>
                            <p class="text-gray-600 dark:text-gray-300">Join thousands of radio engineering professionals today.</p>
                        </div>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Membership Fee</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">₱50</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Processing</span>
                                <span class="text-green-600 dark:text-green-400 font-semibold">Free</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600 dark:text-gray-300">Digital Certificate</span>
                                <span class="text-green-600 dark:text-green-400 font-semibold">Included</span>
                            </div>
                        </div>
                        
                        <a href="/register" class="btn-primary w-full py-4 rounded-2xl text-lg font-semibold text-white text-center block hover:scale-105 transition-transform">
                            Apply for Membership
                        </a>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-4">
                            Already a member? <a href="/login" class="text-blue-600 dark:text-blue-400 hover:underline">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="community" 
        class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 
            dark:from-gray-900 dark:to-gray-800 
            transition-colors duration-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 text-center">
            <div class="reveal mb-16">
                <!-- Heading -->
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-gray-100 mb-6">
                    Join Our Growing 
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Community
                    </span>
                </h2>

                <!-- Subtitle -->
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    See what our members are saying about their experience with Radio Engineering Circle Inc.
                </p>
            </div>
            
            <!-- Testimonials -->
            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Card 1 -->
                <div class="testimonial-card p-8 bg-white dark:bg-gray-800 rounded-xl 
                            shadow-md border border-gray-200 dark:border-gray-700 
                            reveal transition-all hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full 
                                    flex items-center justify-center text-white font-bold text-xl shadow-md">
                            JD
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">
                        "REC has been instrumental in my career growth. The networking opportunities and technical resources are invaluable."
                    </p>
                    <h4 class="font-bold text-gray-900 dark:text-gray-100">John Dela Cruz</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">President</p>
                </div>
                
                <!-- Card 2 -->
                <div class="testimonial-card p-8 bg-white dark:bg-gray-800 rounded-xl 
                            shadow-md border border-gray-200 dark:border-gray-700 
                            reveal transition-all hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-600 rounded-full 
                                    flex items-center justify-center text-white font-bold text-xl shadow-md">
                            MS
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">
                        "The community support is amazing. I've learned more in the past year than I did in the previous five years combined."
                    </p>
                    <h4 class="font-bold text-gray-900 dark:text-gray-100">Maria Santos</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Executive Vice-President</p>
                </div>
                
                <!-- Card 3 -->
                <div class="testimonial-card p-8 bg-white dark:bg-gray-800 rounded-xl 
                            shadow-md border border-gray-200 dark:border-gray-700 
                            reveal transition-all hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full 
                                    flex items-center justify-center text-white font-bold text-xl shadow-md">
                            RA
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">
                        "The digital portal makes everything so convenient. I can access all my certificates and event registrations in one place."
                    </p>
                    <h4 class="font-bold text-gray-900 dark:text-gray-100">Robert Aquino</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Corporate Secretary</p>
                </div>
            </div>
        </div>
    </section>


    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <div class="reveal">
                
                <!-- Title -->
                <h2 class="text-4xl lg:text-6xl font-black text-gray-900 dark:text-gray-100 mb-6">
                    Committed to
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Excellence
                    </span>
                </h2>

                <!-- Description -->
                <p class="text-xl text-gray-700 dark:text-gray-300 mb-12 max-w-2xl mx-auto">
                    Radio Engineering Circle Inc. has been at the forefront of radio technology innovation, fostering growth and connecting professionals worldwide.
                </p>
                
                <!-- Stats Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md 
                                border border-gray-200 dark:border-gray-700">
                        <div class="text-3xl lg:text-4xl font-black text-[#5e6ffb] dark:text-[#5e6ffb] mb-2">500+</div>
                        <div class="text-gray-700 dark:text-gray-300">Active Members</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md 
                                border border-gray-200 dark:border-gray-700">
                        <div class="text-3xl lg:text-4xl font-black text-[#5e6ffb] dark:text-[#5e6ffb] mb-2">9+</div>
                        <div class="text-gray-700 dark:text-gray-300">Years</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md 
                                border border-gray-200 dark:border-gray-700">
                        <div class="text-3xl lg:text-4xl font-black text-[#5e6ffb] dark:text-[#5e6ffb] mb-2">100+</div>
                        <div class="text-gray-700 dark:text-gray-300">Events Hosted</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md 
                                border border-gray-200 dark:border-gray-700">
                        <div class="text-3xl lg:text-4xl font-black text-[#5e6ffb] dark:text-[#5e6ffb] mb-2">15 +</div>
                        <div class="text-gray-700 dark:text-gray-300">Cities Reached</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="flex justify-center">
                    <a href="/register" 
                    class=" btn-primary bg-blue-600 text-white px-10 py-4 rounded-full text-lg font-bold">
                        Start Your Journey Today
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#101966] dark:bg-gray-950 text-white py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="/images/Logo.png" alt="REC Logo" class="h-12 w-12 object-contain">
                        <div>
                            <h3 class="text-xl font-bold"    style="font-family: 'Dax-Regular';">Radio Engineering Circle Inc.</h3>
                            <p class="text-gray-400 dark:text-gray-500">Connecting Radio Enthusiasts Since 2016</p>
                        </div>
                    </div>
                    <p class="text-gray-400 dark:text-gray-500 mb-6 max-w-md">
                        Advancing radio engineering through education, collaboration, and innovation. Join our community of passionate professionals and hobbyists.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/REC.org.ph" class="bg-blue-600 p-3 rounded-full hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-red-600 p-3 rounded-full hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#benefits" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Benefits</a></li>
                        <li><a href="#community" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Community</a></li>
                        <li><a href="/register" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Join Now</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="https://www.facebook.com/REC.org.ph" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="https://centralized-website.rec.org.ph/rec-home-page" target="_blank" class="text-gray-400 dark:text-gray-500 hover:text-white transition-colors">Main Website</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-400 dark:border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400 dark:text-gray-500">&copy; 2016 Radio Engineering Circle Inc. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- CHATBOT INTEGRATION EMBEDDED CODE -->
    <!-- <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/01/12/14/20250112142449-BTWBU6OV.js"></script> -->

    
    <script src="https://cdn.botpress.cloud/webchat/v3.3/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/09/26/05/20250926053639-SRHW57JT.js" defer></script>
    
    <!-- END OF CHATBOT CALLING -->
</body>
</html>