<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RECInc') }} - Register</title>
    <link rel="icon" href="{{ asset('Application-logo/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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

            .modern-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 40px rgba(94, 111, 251, 0.4);
            }

            .modern-btn:active {
                transform: translateY(0);
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

            .modern-btn:hover::before {
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

            /* Password Validation Tooltip - UPDATED */
            .validation-item {
                display: flex;
                align-items: center;
                margin-bottom: 2px;
            }

            .validation-icon {
                margin-right: 8px;
                width: 16px;
                height: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-size: 0.6rem;
                font-weight: bold;
            }

            .validation-icon.valid {
                background-color: rgba(72, 187, 120, 0.2);
                color: #48bb78;
            }

            .validation-icon.invalid {
                background-color: rgba(245, 101, 101, 0.2);
                color: #f56565;
            }

            /* Password Strength Meter Styles */
            .password-strength-meter {
                height: 6px;
                width: 100%;
                margin-top: 8px;
                border-radius: 3px;
                background-color: rgba(255, 255, 255, 0.2);
                overflow: hidden;
            }

            .password-strength-meter-fill {
                height: 100%;
                width: 0%;
                border-radius: 3px;
                transition: width 0.3s ease, background-color 0.3s ease;
            }

            .password-strength-text {
                font-size: 0.75rem;
                margin-top: 4px;
                text-align: right;
                height: 16px;
            }

            /* Validation Requirements - UPDATED */
            .validation-list {
                margin-top: 8px;
                padding-left: 16px;
                font-size: 0.75rem;
            }
            
            /* NEW: Tooltip positioning and styling */
            .password-validation-container {
                position: relative;
            }
            
            #passwordValidationTooltip {
                position: absolute;
                top: calc(100% + 10px); /* Position below the input field */
                left: 0;
                width: 100%;
                z-index: 20;
                background: white; /* Solid white background */
                border-radius: 8px;
                padding: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                border: 1px solid #e2e8f0;
            }
            
            #passwordValidationTooltip .text-sm {
                color: #2d3748; /* Dark text for better contrast on white */
                font-weight: 600;
            }
            
            #passwordValidationTooltip .text-xs {
                color: #4a5568; /* Slightly lighter text for content */
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
    <header class="relative z-10">
        <nav class="px-6 py-4">
            <div class="flex items-center justify-between w-full">
                
                <!-- Logo + Title (hard left, with little space) -->
                <div class="flex items-center space-x-6 pl-6">
                    <div class="relative">
                        <img src="{{ asset('Application-logo/Logo.png') }}" 
                            alt="REC Logo" 
                            class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
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

                <a href="{{ url('/') }}" 
                    class="pr-6 bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-lg flex items-center space-x-2 transition-all duration-300">
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
        <div class="w-full max-w-3xl">
            <!-- Welcome Section -->
            <div class="text-center mb-8 slide-in">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">Create Your Account</h2>
                <p class="text-white/80 text-lg">Join us today to get started!</p>
            </div>

            <!-- Registration Form -->
            <div class="glass-card rounded-2xl p-8 slide-in">
                <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
                    @csrf

                    <!-- Name Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 slide-in">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-white font-medium mb-3 text-sm">First Name</label>
                            <input 
                                id="first_name" 
                                class="modern-input w-full text-white placeholder-white/60" 
                                type="text" 
                                name="first_name" 
                                value="{{ old('first_name') }}" 
                                required 
                                autofocus 
                                autocomplete="given-name"
                                placeholder="Juan" 
                                pattern="[A-Za-z. ]+"
                                oninput="validateName(this)"
                            />
                            <div class="mt-2 text-sm text-red-300">{{ $errors->first('first_name') }}</div>
                            <div id="first_name_error" class="text-sm mt-1 h-5 text-red-300"></div>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-white font-medium mb-3 text-sm">Last Name</label>
                            <input 
                                id="last_name" 
                                class="modern-input w-full text-white placeholder-white/60" 
                                type="text" 
                                name="last_name" 
                                value="{{ old('last_name') }}" 
                                required 
                                autocomplete="family-name"
                                placeholder="Cruz" 
                                pattern="[A-Za-z. ]+"
                                oninput="validateName(this)"
                            />
                            <div class="mt-2 text-sm text-red-300">{{ $errors->first('last_name') }}</div>
                            <div id="last_name_error" class="text-sm mt-1 h-5 text-red-300"></div>
                        </div>
                    </div>

                    <!-- Birthdate -->
                    <div class="slide-in">
                        <label for="birthdate" class="block text-white font-medium mb-3 text-sm">Birthdate</label>
                        <input 
                            id="birthdate" 
                            class="modern-input w-full text-white placeholder-white/60" 
                            type="date" 
                            name="birthdate" 
                            value="{{ old('birthdate') }}" 
                            required
                        />
                        <div class="mt-2 text-sm text-red-300">{{ $errors->first('birthdate') }}</div>
                    </div>
                    
                    <!-- Email Address -->
                    <div class="slide-in">
                        <label for="email" class="block text-white font-medium mb-3 text-sm">Email</label>
                        <input 
                            id="email" 
                            class="modern-input w-full text-white placeholder-white/60" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username"
                            placeholder="your@email.com" 
                        />
                        <div class="mt-2 text-sm text-red-300">{{ $errors->first('email') }}</div>
                    </div>

                    <!-- Password Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 slide-in">
                        <!-- Password -->
                        <div class="password-validation-container">
                            <label for="password" class="block text-white font-medium mb-3 text-sm">Password</label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    class="modern-input w-full text-white placeholder-white/60 pr-12"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Enter your password"
                                    onfocus="showPasswordValidation()"
                                    oninput="checkPasswordStrength()"
                                    onblur="hidePasswordValidation()"
                                />
                                <button type="button" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors"
                                        onclick="togglePasswordVisibility('password')"
                                        aria-label="Toggle password visibility">
                                    <svg id="password-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="password-eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                                
                                <!-- Password Validation Tooltip (initially hidden) -->
                                <div id="passwordValidationTooltip" class="absolute z-10 mt-4 w-full bg-white rounded-lg p-3 shadow-lg border border-gray-200 hidden">
                                    <div class="text-sm text-gray-800 font-medium mb-2">Password must contain:</div>
                                    <div class="space-y-1">
                                        <div class="validation-item">
                                            <span class="validation-icon invalid" id="lengthIcon">✕</span>
                                            <span class="text-xs text-gray-700">Minimum 8 characters</span>
                                        </div>
                                        <div class="validation-item">
                                            <span class="validation-icon invalid" id="uppercaseIcon">✕</span>
                                            <span class="text-xs text-gray-700">Uppercase letter (A-Z)</span>
                                        </div>
                                        <div class="validation-item">
                                            <span class="validation-icon invalid" id="lowercaseIcon">✕</span>
                                            <span class="text-xs text-gray-700">Lowercase letter (a-z)</span>
                                        </div>
                                        <div class="validation-item">
                                            <span class="validation-icon invalid" id="numberIcon">✕</span>
                                            <span class="text-xs text-gray-700">Number (0-9)</span>
                                        </div>
                                        <div class="validation-item">
                                            <span class="validation-icon invalid" id="specialIcon">✕</span>
                                            <span class="text-xs text-gray-700">Special character (!@#$%^&*)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Password Strength Meter -->
                            <div class="password-strength-meter mt-2">
                                <div class="password-strength-meter-fill" id="passwordStrengthMeter"></div>
                            </div>
                            <div class="password-strength-text" id="passwordStrengthText"></div>
                            
                            <div class="mt-2 text-sm text-red-300">{{ $errors->first('password') }}</div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-white font-medium mb-3 text-sm">Confirm Password</label>
                            <div class="relative">
                                <input 
                                    id="password_confirmation" 
                                    class="modern-input w-full text-white placeholder-white/60 pr-12"
                                    type="password"
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Confirm your password"
                                    oninput="checkPasswordMatch()"
                                />
                                <button type="button" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors"
                                        onclick="togglePasswordVisibility('password_confirmation')"
                                        aria-label="Toggle password visibility">
                                    <svg id="password_confirmation-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="password_confirmation-eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <div id="passwordMatchText" class="text-sm mt-1 h-5"></div>
                            <div class="mt-2 text-sm text-red-300">{{ $errors->first('password_confirmation') }}</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8 slide-in">
                        <a class="text-sm text-white/80 hover:text-white transition-colors duration-300" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button dusk="register-button" type="submit" class="modern-btn font-semibold text-lg" id="registerButton">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
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
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.40-1.439-1.44z"/>
                            </svg>
                        </div>
                    </a>
                </div>
                <p class="text-white/70 text-sm">
                    &copy; {{ date('Y') }} Radio Engineering Circle Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`${fieldId}-eye-icon`);
            const eyeSlashIcon = document.getElementById(`${fieldId}-eye-slash-icon`);
            
            if (!passwordInput || !eyeIcon || !eyeSlashIcon) return;
            
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

        function showPasswordValidation() {
            const tooltip = document.getElementById('passwordValidationTooltip');
            tooltip.classList.remove('hidden');
        }

        function hidePasswordValidation() {
            const passwordInput = document.getElementById('password');
            const tooltip = document.getElementById('passwordValidationTooltip');
            
            // Use a small timeout to allow clicks on the tooltip
            setTimeout(() => {
                // Check if the tooltip is being hovered
                if (!tooltip.matches(':hover')) {
                    tooltip.classList.add('hidden');
                }
            }, 200);
        }

        // Add event listeners to the tooltip to keep it visible when hovered
        document.addEventListener('DOMContentLoaded', function() {
            const tooltip = document.getElementById('passwordValidationTooltip');
            if (tooltip) {
                tooltip.addEventListener('mouseenter', function() {
                    // Keep tooltip visible when hovering over it
                });
                
                tooltip.addEventListener('mouseleave', function() {
                    // Hide tooltip when mouse leaves it
                    tooltip.classList.add('hidden');
                });
            }
        });

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthMeter = document.getElementById('passwordStrengthMeter');
            const strengthText = document.getElementById('passwordStrengthText');
            const tooltip = document.getElementById('passwordValidationTooltip');
            
            // Show tooltip when user starts typing
            if (password.length > 0) {
                tooltip.classList.remove('hidden');
            }
            
            // Check individual requirements
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*]/.test(password);
            
            // Update requirement icons
            document.getElementById('lengthIcon').className = `validation-icon ${hasMinLength ? 'valid' : 'invalid'}`;
            document.getElementById('lengthIcon').innerHTML = hasMinLength ? '✓' : '✕';
            
            document.getElementById('uppercaseIcon').className = `validation-icon ${hasUppercase ? 'valid' : 'invalid'}`;
            document.getElementById('uppercaseIcon').innerHTML = hasUppercase ? '✓' : '✕';
            
            document.getElementById('lowercaseIcon').className = `validation-icon ${hasLowercase ? 'valid' : 'invalid'}`;
            document.getElementById('lowercaseIcon').innerHTML = hasLowercase ? '✓' : '✕';
            
            document.getElementById('numberIcon').className = `validation-icon ${hasNumber ? 'valid' : 'invalid'}`;
            document.getElementById('numberIcon').innerHTML = hasNumber ? '✓' : '✕';
            
            document.getElementById('specialIcon').className = `validation-icon ${hasSpecialChar ? 'valid' : 'invalid'}`;
            document.getElementById('specialIcon').innerHTML = hasSpecialChar ? '✓' : '✕';
            
            // Calculate strength score
            let strength = 0;
            if (hasMinLength) strength += 20;
            if (hasUppercase) strength += 20;
            if (hasLowercase) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecialChar) strength += 20;
            
            // Update strength meter and text
            strengthMeter.style.width = `${strength}%`;
            
            if (password.length === 0) {
                strengthText.textContent = '';
                strengthMeter.style.backgroundColor = 'transparent';
            } else if (strength < 60) {
                strengthText.textContent = 'Weak password';
                strengthText.className = 'password-strength-text text-red-400';
                strengthMeter.style.backgroundColor = '#f56565';
            } else if (strength < 100) {
                strengthText.textContent = 'Medium password';
                strengthText.className = 'password-strength-text text-yellow-400';
                strengthMeter.style.backgroundColor = '#ecc94b';
            } else {
                strengthText.textContent = 'Strong password';
                strengthText.className = 'password-strength-text text-green-400';
                strengthMeter.style.backgroundColor = '#48bb78';
            }
            
            // Check if passwords match
            checkPasswordMatch();
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('passwordMatchText');
            
            if (confirmPassword.length === 0) {
                matchText.textContent = '';
                matchText.className = 'text-sm mt-1 h-5';
            } else if (password !== confirmPassword) {
                matchText.textContent = 'Passwords do not match';
                matchText.className = 'text-sm mt-1 h-5 text-red-400';
            } else {
                matchText.textContent = 'Passwords match';
                matchText.className = 'text-sm mt-1 h-5 text-green-400';
            }
        }
        
        // Add form validation
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            
            // Check if password meets all requirements
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            if (!hasMinLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
                event.preventDefault();
                
                // Show SweetAlert instead of standard alert
                Swal.fire({
                    icon: 'error',
                    title: 'Password Requirements Not Met',
                    html: `
                        <div class="text-left">
                            <p class="mb-2">Please make sure your password meets all the requirements:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li class="${hasMinLength ? 'text-green-600' : 'text-red-600'}">Minimum 8 characters</li>
                                <li class="${hasUppercase ? 'text-green-600' : 'text-red-600'}">At least one uppercase letter (A-Z)</li>
                                <li class="${hasLowercase ? 'text-green-600' : 'text-red-600'}">At least one lowercase letter (a-z)</li>
                                <li class="${hasNumber ? 'text-green-600' : 'text-red-600'}">At least one number (0-9)</li>
                                <li class="${hasSpecialChar ? 'text-green-600' : 'text-red-600'}">At least one special character (!@#$%^&*)</li>
                            </ul>
                        </div>
                    `,
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK, I\'ll fix it'
                });
                return;
            }
            
            // Check if passwords match
            const confirmPassword = document.getElementById('password_confirmation').value;
            if (password !== confirmPassword) {
                event.preventDefault();
                
                // Show SweetAlert for password mismatch
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords Do Not Match',
                    text: 'Please make sure your passwords match before submitting.',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
            }

            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const namePattern = /^[A-Za-z. ]+$/;
            
            if (!namePattern.test(firstName)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid First Name',
                    text: 'First name can only contain letters, spaces, and dots (.)',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (!namePattern.test(lastName)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Last Name',
                    text: 'Last name can only contain letters, spaces, and dots (.)',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
                return;
            }
        });
        
        // Check for existing validation errors from server
        document.addEventListener('DOMContentLoaded', function() {
            const errorElements = document.querySelectorAll('.text-red-300');
            if (errorElements.length > 0) {
                // Extract error messages
                const errorMessages = Array.from(errorElements).map(el => el.textContent.trim()).filter(msg => msg !== '');
                
                if (errorMessages.length > 0) {
                    // Show SweetAlert with error messages
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Error',
                        html: `
                            <div class="text-left">
                                <p class="mb-2">Please fix the following errors:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    ${errorMessages.map(msg => `<li class="text-red-600">${msg}</li>`).join('')}
                                </ul>
                            </div>
                        `,
                        confirmButtonColor: '#101966',
                        confirmButtonText: 'OK'
                    });
                }
            }

            // Add entrance animations on page load
            const elements = document.querySelectorAll('.slide-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.animationDelay = `${index * 0.1}s`;
                    el.classList.add('animate');
                }, 100);
            });
        });

        function validateName(input) {
            const errorElement = document.getElementById(`${input.id}_error`);
            const namePattern = /^[A-Za-z. ]+$/;
            
            if (input.value.length === 0) {
                errorElement.textContent = '';
            } else if (!namePattern.test(input.value)) {
                errorElement.textContent = 'Name can only contain letters, spaces, and dots (.)';
            } else {
                errorElement.textContent = '';
            }
        }
    </script>
</body>
</html>