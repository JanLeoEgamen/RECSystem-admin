<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RECInc') }} - Password Reset</title>
    <link rel="icon" href="{{ asset('Application-logo/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer utilities {
            * {
                font-family: 'Inter', sans-serif;
            }
            
            .bg-gradient-blue {
                background: linear-gradient(135deg, #101966 0%, #5e6ffb 25%, #1A25A1 50%, #101966 100%);
            }

            .radio-waves {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                overflow: hidden;
            }
            .wave {
                position: absolute;
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 1000px;
                animation: waveAnimation 8s infinite ease-out;
            }

            .wave:nth-child(1) {
                width: 300px;
                height: 300px;
                left: -150px;
                top: -150px;
                animation-delay: 0s;
            }
            .wave:nth-child(2) {
                width: 500px;
                height: 500px;
                left: -250px;
                top: -250px;
                animation-delay: 1s;
            }
            .wave:nth-child(3) {
                width: 700px;
                height: 700px;
                left: -350px;
                top: -350px;
                animation-delay: 2s;
            }
            .wave:nth-child(4) {
                width: 900px;
                height: 900px;
                left: -450px;
                top: -450px;
                animation-delay: 3s;
            }

            .wave:nth-child(5) {
                width: 300px;
                height: 300px;
                right: -150px;
                bottom: -150px;
                animation-delay: 0.5s;
            }
            .wave:nth-child(6) {
                width: 500px;
                height: 500px;
                right: -250px;
                bottom: -250px;
                animation-delay: 1.5s;
            }
            .wave:nth-child(7) {
                width: 700px;
                height: 700px;
                right: -350px;
                bottom: -350px;
                animation-delay: 2.5s;
            }
            .wave:nth-child(8) {
                width: 900px;
                height: 900px;
                right: -450px;
                bottom: -450px;
                animation-delay: 3.5s;
            }
            @keyframes waveAnimation {
                0% {
                    transform: scale(0.5);
                    opacity: 0;
                }
                50% {
                    opacity: 0.4;
                }
                100% {
                    transform: scale(1.5);
                    opacity: 0;
                }
            }

            .modern-btn {
                background: linear-gradient(135deg, #1A25A1, #101966);
                border: none;
                border-radius: 12px;
                color: white;
                font-weight: 600;
                padding: 14px 28px;
                position: relative;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 8px 32px rgba(94, 111, 251, 0.3);
            }

            .modern-btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 12px 40px rgba(94, 111, 251, 0.4);
            }

            .modern-btn:active:not(:disabled) {
                transform: translateY(0);
            }

            .modern-btn:disabled {
                opacity: 0.7;
                cursor: not-allowed;
                transform: none;
                box-shadow: 0 8px 32px rgba(94, 111, 251, 0.2);
            }

            .modern-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }

            .modern-btn:hover:not(:disabled)::before {
                left: 100%;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .modern-input {
                background: rgba(255, 255, 255, 0.1);
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                color: white;
                padding: 16px 20px;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .modern-input:focus {
                outline: none;
                border-color: #5e6ffb;
                background: rgba(255, 255, 255, 0.15);
                box-shadow: 0 0 0 4px rgba(94, 111, 251, 0.1);
            }

            .modern-input::placeholder {
                color: rgba(255, 255, 255, 0.6);
            }

            .floating {
                animation: floating 6s ease-in-out infinite;
            }

            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .slide-in {
                animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                opacity: 0;
                transform: translateY(30px);
            }

            @keyframes slideIn {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .slide-in:nth-child(1) { animation-delay: 0.1s; }
            .slide-in:nth-child(2) { animation-delay: 0.2s; }
            .slide-in:nth-child(3) { animation-delay: 0.3s; }
            .slide-in:nth-child(4) { animation-delay: 0.4s; }
            .slide-in:nth-child(5) { animation-delay: 0.5s; }
            
            .countdown-text {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.9rem;
                margin-top: 10px;
            }
        }
    </style>
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
                    class="pr-6 bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-lg flex items-center space-x-2 transition-all duration-300 dark:bg-gray-700/60 dark:hover:bg-gray-600/60 dark:text-gray-200">
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
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 dark:text-white">Password Reset</h2>
                <p class="text-white/80 text-lg dark:text-gray-300">Enter your email to receive reset instructions</p>
            </div>

            <!-- Password Reset Form -->
            <div class="glass-card rounded-2xl p-8 slide-in dark:bg-gray-800/80 dark:backdrop-blur-md dark:border dark:border-gray-700/50">
                
                <!-- Information Text -->
                <div class="mb-6 p-4 bg-[#101966] backdrop-blur-sm border border-blue-400/30 rounded-xl text-white/90 text-sm slide-in dark:bg-blue-600/20 dark:border-blue-500/30 text-justify">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-500/20 backdrop-blur-sm border border-green-400/30 rounded-xl text-white font-medium dark:bg-green-600/20 dark:border-green-500/30">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6" id="passwordResetForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="slide-in">
                        <label for="email" class="block text-white font-medium mb-3 text-sm dark:text-gray-200">Email Address</label>
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
                                class="modern-btn w-full font-semibold text-lg dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-600">
                            {{ __('Email Password Reset Link') }}
                        </button>
                        <div id="countdown" class="countdown-text text-center hidden">
                            Please wait <span id="countdown-timer">60</span> seconds before requesting another email.
                        </div>
                    </div>
                </form>

                <div class="my-6 border-t border-white/30 dark:border-gray-700"></div>

                <!-- Back to Login Link -->
                <div class="text-center slide-in">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white/30 rounded-xl text-white font-medium hover:bg-white/10 transition-all duration-300 dark:border-gray-600 dark:text-white dark:hover:bg-gray-700/50">
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
                    &copy; {{ date('Y') }} Radio Engineering Circle Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Add entrance animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.slide-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.animationDelay = `${index * 0.1}s`;
                    el.classList.add('animate');
                }, 100);
            });
            
            // Check if we need to start a countdown (if user recently submitted a request)
            checkExistingTimer();
        });
        
        // Timer functionality to prevent spam
        const TIMER_DURATION = 60; // 60 seconds
        let countdownInterval = null;
        
        function checkExistingTimer() {
            const endTime = localStorage.getItem('passwordResetTimer');
            if (endTime) {
                const remaining = Math.ceil((endTime - Date.now()) / 1000);
                if (remaining > 0) {
                    startCountdown(remaining);
                } else {
                    localStorage.removeItem('passwordResetTimer');
                }
            }
        }
        
        function startCountdown(seconds = TIMER_DURATION) {
            const submitBtn = document.getElementById('submitBtn');
            const countdownEl = document.getElementById('countdown');
            const countdownTimer = document.getElementById('countdown-timer');
            
            // Disable the button and show countdown
            submitBtn.disabled = true;
            countdownEl.classList.remove('hidden');
            
            // Store the end time in localStorage
            const endTime = Date.now() + (seconds * 1000);
            localStorage.setItem('passwordResetTimer', endTime);
            
            // Update the countdown every second
            let timeLeft = seconds;
            countdownTimer.textContent = timeLeft;
            
            countdownInterval = setInterval(() => {
                timeLeft--;
                countdownTimer.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    submitBtn.disabled = false;
                    countdownEl.classList.add('hidden');
                    localStorage.removeItem('passwordResetTimer');
                }
            }, 1000);
        }
        
        // Add form submission handler
        document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
            // If button is already disabled, prevent submission
            if (document.getElementById('submitBtn').disabled) {
                e.preventDefault();
                return;
            }
            
            // Start the countdown timer
            startCountdown();
        });
    </script>
</body>
</html>