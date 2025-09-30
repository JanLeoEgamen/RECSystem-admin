<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RECInc - Reset Password</title>
    <link rel="icon" href="/images/Logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <!-- Vite CSS and JS -->
    @vite(['resources/css/reset-pass.css', 'resources/js/reset-pass.js'])
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
            <p class="mt-6 text-white font-medium">Resetting Password...</p>
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
           <!-- Reset Password Section -->
            <div class="text-center mb-8 slide-in">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 flex items-center justify-center">
                    <span class="text-4xl mr-3">🔒</span>
                    Reset Password
                </h2>
                <p class="text-white/80 text-lg">Create a new password for your account</p>
            </div>

            <!-- Reset Password Form -->
            <div class="glass-card rounded-2xl p-8 slide-in">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6" id="reset-password-form">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="slide-in">
                        <label for="email" class="block text-white font-medium mb-3 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Email Address<span class="text-red-400 ml-1">*</span>
                        </label>
                        <input 
                            id="email" 
                            class="modern-input w-full text-white placeholder-white/60 opacity-60" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autocomplete="username" 
                            readonly
                        />
                        @if ($errors->has('email'))
                            <div class="error-message mt-2">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="slide-in password-validation-container">
                        <label for="password" class="block text-white font-medium mb-3 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            New Password  <span class="text-red-400 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                class="modern-input w-full text-white placeholder-white/60 pr-12 password-field"
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password"
                                placeholder="Enter your new password"
                                onfocus="showPasswordValidation()"
                                oninput="checkPasswordStrength()"
                                onblur="hidePasswordValidation()"
                            />
                            <button type="button" 
                                    id="password-toggle"
                                    class="absolute inset-y-0 right-4 flex items-center justify-center text-white/60 hover:text-white transition-colors password-toggle"
                                    aria-label="Toggle password visibility">
                                <!-- Open eye -->
                                <svg id="password-eye-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                                            8.268 2.943 9.542 7-1.274 4.057-5.064 
                                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Closed eye -->
                                <svg id="password-eye-slash-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 
                                        3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 
                                        9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>                              
                            </button>
                        </div>
                        
                        <!-- Password Strength Meter -->
                        <div class="password-strength-meter mt-2">
                            <div class="password-strength-meter-fill" id="passwordStrengthMeter"></div>
                        </div>
                        <div class="password-strength-text text-xs mt-1 text-right" id="passwordStrengthText"></div>
                        
                        <!-- Compact Password Validation Tooltip -->
                        <div id="passwordValidationTooltip" class="mt-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-3 hidden">
                            <div class="text-xs text-white/80 font-medium mb-2">Password Validation</div>
                            <div class="grid grid-cols-2 gap-1">
                                <div class="validation-item">
                                    <span class="validation-icon invalid" id="lengthIcon">✕</span>
                                    <span class="text-xs text-white/70">8+ characters</span>
                                </div>
                                <div class="validation-item">
                                    <span class="validation-icon invalid" id="uppercaseIcon">✕</span>
                                    <span class="text-xs text-white/70">A-Z uppercase</span>
                                </div>
                                <div class="validation-item">
                                    <span class="validation-icon invalid" id="lowercaseIcon">✕</span>
                                    <span class="text-xs text-white/70">a-z lowercase</span>
                                </div>
                                <div class="validation-item">
                                    <span class="validation-icon invalid" id="numberIcon">✕</span>
                                    <span class="text-xs text-white/70">0-9 number</span>
                                </div>
                                <div class="validation-item">
                                    <span class="validation-icon invalid" id="specialIcon">✕</span>
                                    <span class="text-xs text-white/70">!@#$% special</span>
                                </div>
                            </div>
                        </div>
                        
                        @if ($errors->has('password'))
                            <div class="error-message mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div class="slide-in mt-4">
                        <label for="password_confirmation" class="block text-white font-medium mb-3 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Confirm Password  <span class="text-red-400 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                class="modern-input w-full text-white placeholder-white/60 pr-12 password-field"
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="Confirm your new password"
                            />
                            <button type="button" 
                                    id="confirm-password-toggle"
                                    class="absolute inset-y-0 right-4 flex items-center justify-center text-white/60 hover:text-white transition-colors password-toggle"
                                    aria-label="Toggle password visibility">
                                <!-- Open eye -->
                                <svg id="confirm-password-eye-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                                            8.268 2.943 9.542 7-1.274 4.057-5.064 
                                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Closed eye -->
                                <svg id="confirm-password-eye-slash-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 
                                        3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 
                                        9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>                              
                            </button>
                        </div>
                        
                        <!-- Password Match Validation -->
                        <div id="passwordMatchText" class="text-sm mt-1 h-5"></div>
                        
                        @if ($errors->has('password_confirmation'))
                            <div class="error-message mt-2">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>

                    <!-- reCAPTCHA -->
                    <div id="recaptcha-wrapper" class="hidden slide-in">
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
                        <button 
                                type="submit" 
                                class="modern-btn w-full font-semibold text-lg flex items-center justify-center"
                                id="submit-btn">                   
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Password
                        </button>
                    </div>
                </form>

                <div class="my-6 border-t border-white/30"></div>

                <!-- Back to Login Link -->
                <div class="text-center slide-in">
                    <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white/30 rounded-xl text-white font-medium hover:bg-white/10 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                        Back to Login
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
</body>
</html>