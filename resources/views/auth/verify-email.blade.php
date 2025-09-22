<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RECInc - Email Verification</title>
    <link rel="icon" href="https://example.com/Application-logo/Logo.png" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/verify-email.css', 'resources/js/verify-email.js'])
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
    <header class="relative z-10">
        <nav class="px-6 py-4">
            <div class="flex items-center justify-between w-full">
                <!-- Logo + Title -->
                <div class="flex items-center space-x-6 pl-6">
                    <div class="relative">
                        <img src="{{ asset('Application-logo/Logo.png') }}" alt="REC Logo" class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
                        <div class="absolute -inset-2 bg-white/10 rounded-full blur-md"></div>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg sm:text-xl">
                            Radio Engineering Circle Inc.
                        </h1>
                        <p class="text-white/70 text-sm">
                            DZ1REC — Connecting Radio Enthusiasts
                        </p>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-md">
            <!-- Welcome Section -->
            <div class="text-center mb-8 slide-in">
                <div class="floating mb-4">
                    <div class="glass-card p-4 rounded-full inline-block">
                        <i class="fas fa-envelope text-white text-4xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">Verify Your Email</h2>
                <p class="text-white/80 text-lg">Secure access to your member portal</p>
            </div>

            <!-- Verification Content -->
            <div class="glass-card rounded-2xl p-8 slide-in">
                <!-- Success Message (if verification link was sent) -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 font-medium text-sm success-message-dark backdrop-filter backdrop-blur-10 p-4 rounded-lg slide-in">
                        <i class="fas fa-check-circle mr-2"></i>
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <!-- Info Message -->
                <div class="mb-6 text-sm info-message backdrop-filter bg-[#101966] text-white/80 backdrop-blur-10 p-4 rounded-lg slide-in">
                    <p class="flex items-start text-justify">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>
                </div>

                <!-- Status Message (for AJAX responses) -->
                <div id="statusMessage" class="hidden mb-6 font-medium text-sm p-4 rounded-lg backdrop-filter backdrop-blur-10">
                    <i class="fas mr-2" id="statusIcon"></i>
                    <span id="statusText"></span>
                </div>

                <div class="space-y-6">
                    <!-- Resend Button -->
                    <div class="slide-in">
                        <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                            @csrf
                            <button type="submit" id="resendButton" 
                                    class="modern-btn w-full font-semibold text-lg pulse">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Resend Verification Email
                            </button>
                        </form>
                    </div>

                    <!-- Countdown Container -->
                    <div id="countdownContainer" class="hidden slide-in">
                        <div class="glass-card p-6 rounded-xl">
                            <p class="text-white/90 mb-4 flex items-center justify-center text-sm">
                                <i class="fas fa-clock mr-2 text-blue-300"></i>
                                Please wait before requesting another email
                            </p>
                            
                            <div class="flex justify-center items-center space-x-4 mb-4">
                                <div class="text-center">
                                    <div class="countdown-digit text-xl" id="minutes">02</div>
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

                    <div class="my-6 border-t border-white/30"></div>

                    <!-- Log Out Button -->
                    <div class="slide-in">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white/30 rounded-xl text-white font-medium hover:bg-white/10 transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Back to Home
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 py-8">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center">
                <div class="flex justify-center space-x-6 mb-6">
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="group">
                        <div class="glass-card p-3 rounded-full group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.40-1.439-1.40z"/>
                            </svg>
                        </div>
                    </a>
                </div>
                <p class="text-white/70 text-sm">
                    &copy; 2023 Radio Engineering Circle Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>