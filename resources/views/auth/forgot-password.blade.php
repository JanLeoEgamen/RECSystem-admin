<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RECInc') }} - Password Reset</title>
    <link rel="icon" href="{{ asset('Application-logo/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/forgot-password.css', 'resources/js/forgot-password.js'])
</head>
<body class="bg-gradient-blue min-h-screen">
    <div class="radio-waves">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Header -->
    <header class="relative z-10 dark">
        <nav class="px-6 py-4">
            <div class="flex items-center justify-between w-full">
                
                <!-- Logo + Title (hard left, with little space) -->
                <div class="flex items-center space-x-6 pl-6">
                    <div class="relative">
                        <img src="{{ asset('Application-logo/Logo.png') }}" 
                            alt="REC Logo" 
                            class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
                        <div class="absolute -inset-2 bg-white/10 rounded-full blur-md dark:bg-gray-800/30"></div>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg sm:text-xl dark:text-white">
                            Radio Engineering Circle Inc.
                        </h1>
                        <p class="text-white/70 text-sm dark:text-gray-300">
                            DZ1REC — Connecting Radio Enthusiasts
                        </p>
                    </div>
                </div>

                <a href="{{ url('/') }}" 
                    class="hidden sm:flex pr-6 bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-full items-center space-x-2 transition-all duration-300 dark:bg-gray-700/60 dark:hover:bg-gray-600/60 dark:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Back to Home</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-6 py-8 dark">
        <div class="w-full max-w-md">
            <!-- Welcome Section -->
            <div class="text-center mb-8 slide-in">
                <div class="floating mb-4">
                    <div class="glass-card p-4 rounded-full inline-block">
                        <i class="fas fa-key text-white text-4xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 dark:text-white">Password Reset</h2>
                <p class="text-white/80 text-lg dark:text-gray-300">Enter your email to receive reset instructions</p>
            </div>

            <!-- Password Reset Form -->
            <div class="glass-card rounded-2xl p-8 slide-in dark:bg-gray-800/80 dark:backdrop-blur-md dark:border dark:border-gray-700/50">
                
                <!-- Information Text -->
                <div class="mb-6 p-4 bg-[#101966] backdrop-blur-sm border border-blue-400/30 rounded-xl text-white/90 text-sm slide-in dark:bg-blue-600/20 dark:border-blue-500/30 text-justify">
                    <p class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="success-notification mb-6 p-4 bg-green-500/20 backdrop-blur-sm border border-green-400/30 rounded-xl text-white font-medium dark:bg-green-600/20 dark:border-green-500/30 slide-in">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6" id="passwordResetForm">
                    @csrf

                <!-- Email Field -->
                <div class="slide-in">
                    <label for="email" class="block text-white font-medium mb-3 text-sm flex items-center dark:text-gray-200">
                        <!-- Email Icon -->
                        <svg class="w-4 h-4 mr-2 text-white/70 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Email Address <span class="text-red-400 ml-1">*</span>
                    </label>
                    <input 
                        id="email" 
                        class="modern-input w-full text-white placeholder-white/60 dark:bg-gray-700/50 dark:border-gray-600 dark:placeholder-gray-400/60 dark:text-white" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="Enter your email address" 
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-300 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div class="slide-in">
                    <button type="submit" 
                            id="submitBtn"
                            class="modern-btn w-full font-semibold text-lg pulse dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-600">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>

                    <!-- Enhanced Countdown Container -->
                    <div id="countdownContainer" class="hidden slide-in">
                        <div class="glass-card p-6 rounded-xl">
                            <p class="text-white/90 mb-4 flex items-center justify-center text-sm">
                                <i class="fas fa-clock mr-2 text-blue-300"></i>
                                Please wait before requesting another reset email
                            </p>
                            
                            <div class="flex justify-center items-center space-x-4 mb-4">
                                <div class="text-center">
                                    <div class="countdown-digit text-xl" id="minutes">01</div>
                                    <div class="text-xs text-white/60 mt-1">Minutes</div>
                                </div>
                                <div class="text-xl text-white/60">:</div>
                                <div class="text-center">
                                    <div class="countdown-digit text-xl" id="seconds">00</div>
                                    <div class="text-xs text-white/60 mt-1">Seconds</div>
                                </div>
                            </div>
                            
                            <div class="relative w-full h-2 bg-white/20 rounded-full overflow-hidden">
                                <div id="progressBar" class="absolute h-2 progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="my-6 border-t border-white/30 dark:border-gray-700"></div>

                <!-- Back to Login Link -->
                <div class="text-center slide-in">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white/30 rounded-xl text-white font-medium hover:bg-white/10 transition-all duration-300 dark:border-gray-600 dark:text-white dark:hover:bg-gray-700/50">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 py-8 dark">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center">
                <div class="flex justify-center space-x-6 mb-6">
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300 dark:bg-gray-800/50 dark:backdrop-blur-md dark:border dark:border-gray-700/30 dark:group-hover:bg-gray-700/50">
                            <svg class="w-5 h-5 text-white dark:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300 dark:bg-gray-800/50 dark:backdrop-blur-md dark:border dark:border-gray-700/30 dark:group-hover:bg-gray-700/50">
                            <svg class="w-5 h-5 text-white dark:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300 dark:bg-gray-800/50 dark:backdrop-blur-md dark:border dark:border-gray-700/30 dark:group-hover:bg-gray-700/50">
                            <svg class="w-5 h-5 text-white dark:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.40-1.439-1.40z"/>
                            </svg>
                        </div>
                    </a>
                </div>
                <p class="text-white/70 text-sm dark:text-gray-400">
                    &copy; 2016 Radio Engineering Circle Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>