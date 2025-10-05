<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="your-csrf-token-here">
    <title>RECInc - Login</title>
    <link rel="icon" href="https://example.com/Application-logo/Logo.png" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <!-- Vite CSS and JS -->
    @vite(['resources/css/login.css', 'resources/js/login.js'])
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

    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden">
        <div class="flex flex-col items-center">
            <div class="relative w-24 h-24 flex items-center justify-center">
                <div class="w-6 h-6 bg-blue-500 rounded-full z-10"></div>
                <span class="absolute w-6 h-6 rounded-full border-4 border-blue-400 animate-wave"></span>
                <span class="absolute w-6 h-6 rounded-full border-4 border-blue-400 animate-wave delay-200"></span>
                <span class="absolute w-6 h-6 rounded-full border-4 border-blue-400 animate-wave delay-400"></span>
            </div>
            <p class="mt-6 text-white font-medium">Connecting to REC...</p>
        </div>
    </div>

    <!-- Lockout Timer Modal -->
    <div id="lockout-modal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Too Many Attempts</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">Please wait before trying again.</p>
            <div class="flex items-center justify-center space-x-2 mb-6">
                <div id="lockout-timer" class="text-2xl font-bold text-red-600 dark:text-red-400">05:00</div>
            </div>
            <button id="close-lockout-modal" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                OK
            </button>
        </div>
    </div>

    <!-- Header -->
    <header class="relative z-10">
        <nav class="px-6 py-4">
            <div class="flex items-center justify-between w-full">
                
                <!-- Logo + Title (hard left, with little space) -->
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

                <a href="{{ route('welcome') }}"
                class="hidden sm:flex pr-6 bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-full items-center space-x-2 transition-all duration-300">
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
    <main class="flex-1 flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-md">
           <!-- Welcome Section -->
            <div class="text-center mb-8 slide-in">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 flex items-center justify-center">
                    <span class="text-4xl mr-3">👋</span>
                    Welcome Back
                </h2>
                <p class="text-white/80 text-lg">Sign in to access your member portal</p>
            </div>

            <!-- Login Form -->
            <div class="glass-card rounded-2xl p-8 slide-in">
                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="login-form">
                    @csrf
                    <!-- Email Field -->
                    <div class="slide-in">
                        <label for="email" class="block text-white font-medium mb-3 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            class="modern-input w-full text-white placeholder-white/60" 
                            type="email" 
                            name="email" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email address" 
                            value="{{ old('email') }}"
                            @if(session('lockout_time')) disabled @endif
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-200" />
                    </div>

                    <!-- Password Field -->
                    <div class="slide-in">
                        <label for="password" class="block text-white font-medium mb-3 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                class="modern-input w-full text-white placeholder-white/60 pr-12"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                oninput="handlePasswordInput(this)"
                                @if(session('lockout_time')) disabled @endif
                            />
                            <button type="button" 
                                    id="password-toggle"
                                    class="absolute inset-y-0 right-4 flex items-center justify-center text-white/60 hover:text-white transition-colors eye-toggle"
                                    onclick="togglePasswordVisibility()"
                                    aria-label="Toggle password visibility"
                                    @if(session('lockout_time')) disabled @endif>
                                <!-- Open eye -->
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                                            8.268 2.943 9.542 7-1.274 4.057-5.064 
                                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Closed eye -->
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 
                                        3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 
                                        9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>                              
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-200" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between slide-in">
                        <label for="remember_me" class="inline-flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded bg-white/20 border-white/30 text-purple-600 focus:ring-purple-400 focus:ring-offset-0" 
                                name="remember"
                                @if(session('lockout_time')) disabled @endif
                            >
                            <span class="ml-3 text-sm text-white/90">Remember me</span>
                        </label>

                        <a class="text-sm text-white/80 hover:text-white transition-colors duration-300" 
                            href="{{ route('password.request') }}">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>Forgot password?
                        </a>
                    </div>

                     <!-- reCAPTCHA -->
                    <div id="recaptcha-wrapper" class="hidden">
                        <div class="flex justify-center">
                            <div class="g-recaptcha" 
                                    data-sitekey="6LdvJtArAAAAAPSZCSvboizEY01ToCw0973Mez29" 
                                    data-theme="light" 
                                    data-size="normal">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="slide-in">
                        <button dusk="login-button" 
                                type="submit" 
                                class="modern-btn w-full font-semibold text-lg dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-600 flex items-center justify-center"
                                id="submit-btn"
                                @if(session('lockout_time')) disabled @endif>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span id="submit-text">Sign In</span>
                            <span id="submit-loading" class="hidden">Please wait...</span>
                        </button>
                    </div>
                </form>

                <div class="my-6 border-t border-white/30"></div>

                <!-- Registration Link -->
                <div class="text-center slide-in">
                    <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white/30 rounded-xl text-white font-medium hover:bg-white/10 transition-all duration-300"
                    @if(session('lockout_time')) style="pointer-events: none; opacity: 0.5;" @endif>
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                        </svg>
                        Create New Account
                    </a>
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
                    &copy; 2016 Radio Engineering Circle Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lockoutTime = {{ session('lockout_seconds', 0) }}; // Use lockout_seconds instead
        const errorMessage = "{{ $errors->first('email') }}";
        
        console.log('Lockout time:', lockoutTime);
        console.log('Error message:', errorMessage);
        
        // Check if there's a lockout from session OR from error message
        let actualLockoutTime = lockoutTime;
        
        // If no session lockout but error message indicates lockout, extract time
        if (lockoutTime === 0 && errorMessage.includes('Too many login attempts')) {
            const timeMatch = errorMessage.match(/(\d+)/);
            if (timeMatch) {
                const minutes = parseInt(timeMatch[1]);
                actualLockoutTime = minutes * 60; // Convert minutes to seconds
                console.log('Extracted lockout time from message:', actualLockoutTime);
            }
        }
        
        // If we still don't have a time but there's a lockout message, use 5 minutes (300 seconds)
        if (actualLockoutTime === 0 && errorMessage.includes('Too many login attempts')) {
            actualLockoutTime = 300; // 5 minutes in seconds
            console.log('Using default lockout time:', actualLockoutTime);
        }
        
        if (actualLockoutTime > 0) {
            console.log('Showing lockout timer for:', actualLockoutTime, 'seconds');
            showLockoutTimer(actualLockoutTime);
            disableForm();
        } else {
            console.log('No lockout detected');
        }

        // Handle form submission to show loading
        const loginForm = document.getElementById('login-form');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        if (loginForm && !actualLockoutTime) {
            loginForm.addEventListener('submit', function(e) {
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                submitBtn.disabled = true;
            });
        }

        // Close lockout modal
        const closeBtn = document.getElementById('close-lockout-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                document.getElementById('lockout-modal').classList.add('hidden');
            });
        }
    });

    function showLockoutTimer(seconds) {
        const modal = document.getElementById('lockout-modal');
        const timer = document.getElementById('lockout-timer');
        
        modal.classList.remove('hidden');
        
        let timeLeft = seconds;
        console.log('Starting timer with:', timeLeft, 'seconds');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const secs = timeLeft % 60;
            timer.textContent = `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            
            console.log('Time left:', timeLeft, 'seconds');
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                console.log('Timer finished');
                modal.classList.add('hidden');
                enableForm();
                // Remove the session data by refreshing
                window.location.href = '{{ route("login") }}';
            }
        }
        
        updateTimer();
    }

    function disableForm() {
        const inputs = document.querySelectorAll('#login-form input, #login-form button, #login-form a');
        inputs.forEach(input => {
            input.disabled = true;
            if (input.tagName === 'A') {
                input.style.pointerEvents = 'none';
                input.style.opacity = '0.5';
            }
        });
        
        // Also disable the form itself to prevent submission
        const form = document.getElementById('login-form');
        if (form) {
            form.style.pointerEvents = 'none';
            form.style.opacity = '0.7';
        }
        
        console.log('Form disabled');
    }

    function enableForm() {
        const inputs = document.querySelectorAll('#login-form input, #login-form button, #login-form a');
        inputs.forEach(input => {
            input.disabled = false;
            if (input.tagName === 'A') {
                input.style.pointerEvents = 'auto';
                input.style.opacity = '1';
            }
        });
        
        // Re-enable the form
        const form = document.getElementById('login-form');
        if (form) {
            form.style.pointerEvents = 'auto';
            form.style.opacity = '1';
        }
        
        // Reset submit button text
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');
        if (submitText && submitLoading) {
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        }
        
        console.log('Form enabled');
    }

    // Your existing password functions
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }

    function handlePasswordInput(input) {
        // Your existing password input handling
    }
</script>
</body>
</html>