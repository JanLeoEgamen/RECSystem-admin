<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Amateur Radio Club</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-10px); }
                }
                .float-animation {
                    animation: float 3s ease-in-out infinite;
                }
                .hover-scale {
                    transition: transform 0.3s ease;
                }
                .hover-scale:hover {
                    transform: scale(1.05);
                }
                .badge {
                    transition: all 0.3s ease;
                }
                .badge:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                }
                .vision-mission-card {
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                .vision-mission-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
                }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <!-- Removed the header with navigation buttons -->
        
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row gap-6">
                <!-- Vision & Mission Section -->
                <div class="flex-1 flex flex-col gap-6">
                    <!-- Vision Card -->
                    <div class="vision-mission-card bg-white dark:bg-[#161615] p-6 rounded-lg shadow-lg">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-300">VISION</h2>
                        </div>
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            To be a distinguished and globally recognized amateur radio club.
                        </p>
                    </div>
                    
                    <!-- Mission Card -->
                    <div class="vision-mission-card bg-white dark:bg-[#161615] p-6 rounded-lg shadow-lg">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-green-600 dark:text-green-300">MISSION</h2>
                        </div>
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            To develop world-class excellence by being proactive in amateur radio and developing members through related activities.
                        </p>
                    </div>
                    
                    <!-- Activities Section -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-blue-700 dark:text-blue-300">Administrator Activities</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">User Management</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">License Management</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                <span class="text-sm">Website Content Management</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">Membership Management</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!--DIV OF THE-->
                <div class="bg-contain bg-center bg-no-repeat bg-[#101966] dark:bg-[#1D0002] relative rounded-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center float-animation"
                style="background-image: url('/images/Logo-1.png'); background-size: 95%; background-position: center 110px; background-repeat: no-repeat;">
                     <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-20 dark:opacity-30"></div>
                     
                    <!-- Title moved to top center -->
                    <div class="absolute top-0 left-0 right-0 p-4 text-center text-white flex flex-col items-center mt-2">
                        <img src="/images/Logo.png" alt="Club Logo" class="w-16 h-16 object-contain hover:scale-110 transition-transform mb-2">
                        <h2 class="text-2xl font-bold">Radio Engineering Circle Inc.</h2>
                        <p class="text-sm opacity-90">DZ1REC — Connecting the world through radio waves!</p>
                    </div>


                     
                     <!-- Buttons moved to bottom center -->
                     <div class="absolute bottom-0 left-0 right-0 p-6 flex justify-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="inline-block px-5 py-3 text-white hover:text-[#3F53E8] bg-[#3F53E8] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-[#3F53E8] border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-all hover-scale">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block px-5 py-3 text-white hover:text-[#3F53E8] bg-[#3F53E8] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 border border-[#3F53E8] border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-all hover-scale">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-block px-5 py-3 text-white hover:text-[#3F53E8] bg-[#3F53E8] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 border border-[#3F53E8] border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-all hover-scale">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                     </div>
                </div>
            </main>
        </div>

        <!-- Footer with Social Links -->
        <footer class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <div class="flex justify-center gap-4 mb-4">
                <a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                    <i class="fab fa-facebook-f text-xl"></i>
                </a>
                <a href="#" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                    <i class="fab fa-youtube text-xl"></i>
                </a>
                <a href="#" class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
            </div>
            <p>&copy; {{ date('Y') }} Amateur Radio Club. All rights reserved.</p>
        </footer>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>