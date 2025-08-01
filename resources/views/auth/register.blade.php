<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RECInc') }} - Register</title>
    <link rel="icon" href="{{ asset('Application-logo/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-blue {
                background-image: linear-gradient(-45deg, #101966, #5e6ffb, #1A25A1,rgb(5, 10, 34));
                background-size: 400% 400%;
                animation: gradientFlow 15s ease infinite;
            }
            
            @keyframes gradientFlow {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }

            /* Radio Wave Animation */
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
            /* Top-left waves */
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
            /* Bottom-right waves */
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

            .btn-17,
            .btn-17 *,
            .btn-17 :after,
            .btn-17 :before,
            .btn-17:after,
            .btn-17:before {
                border: 0 solid;
                box-sizing: border-box;
            }

            .btn-17 {
                -webkit-tap-highlight-color: transparent;
                -webkit-appearance: button;
                background-color: #101966;
                background-image: none;
                color: #fff;
                cursor: pointer;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
                Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
                Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
                font-size: 100%;
                font-weight: 900;
                line-height: 1.5;
                margin: 0;
                -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
                padding: 0;
                text-transform: uppercase;
                border: 2px solid transparent;
                transition: border-color 0.3s ease;
            }

            .btn-17:hover {
                border-color: #536ffb;
            }

            .btn-17:disabled {
                cursor: default;
            }

            .btn-17:-moz-focusring {
                outline: auto;
            }

            .btn-17 svg {
                display: block;
                vertical-align: middle;
            }

            .btn-17 [hidden] {
                display: none;
            }

            .btn-17 {
                border-radius: 99rem;
                padding: 0.8rem 3rem;
                z-index: 0;
            }

            .btn-17,
            .btn-17 .text-container {
                overflow: hidden;
                position: relative;
            }

            .btn-17 .text-container {
                display: block;
            }

            .btn-17 .text {
                display: block;
                position: relative;
                color: white;
                transition: color 0.3s ease;
            }

            .btn-17:hover .text {
                color: #101966;
                -webkit-animation: move-up-alternate 0.3s forwards;
                animation: move-up-alternate 0.3s forwards;
            }

            @-webkit-keyframes move-up-alternate {
                0% { transform: translateY(0); }
                50% { transform: translateY(80%); }
                51% { transform: translateY(-80%); }
                to { transform: translateY(0); }
            }

            @keyframes move-up-alternate {
                0% { transform: translateY(0); }
                50% { transform: translateY(80%); }
                51% { transform: translateY(-80%); }
                to { transform: translateY(0); }
            }

            .btn-17:after,
            .btn-17:before {
                --skew: 0.2;
                background: #fff;
                content: "";
                display: block;
                height: 102%;
                left: calc(-50% - 50% * var(--skew));
                pointer-events: none;
                position: absolute;
                top: -104%;
                transform: skew(calc(150deg * var(--skew))) translateY(var(--progress, 0));
                transition: transform 0.2s ease;
                width: 100%;
            }

            .btn-17:after {
                --progress: 0%;
                left: calc(50% + 50% * var(--skew));
                top: 102%;
                z-index: -1;
            }

            .btn-17:hover:before {
                --progress: 100%;
            }

            .btn-17:hover:after {
                --progress: -102%;
            }
        }
    </style>
</head>
<body class="bg-gradient-blue flex flex-col min-h-screen">
    <!-- Radio Wave Background Animation -->
    <div class="radio-waves">
        <!-- Top-left waves -->
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <!-- Bottom-right waves -->
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <header class="relative py-4 px-4 sm:px-8 flex justify-center items-center text-white bg-white/10 shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1)]">
        <!-- Logo Section -->
        <div class="logo flex items-center">
            <img src="{{ asset('Application-logo/Logo.png') }}" alt="Club Logo" class="w-12 h-12 sm:w-16 sm:h-16 object-contain hover:scale-110 transition-transform">
            <h2 class="text-xl sm:text-xl font-bold ml-2 sm:ml-4">RADIO ENGINEERING CIRCLE INC.</h2>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center py-8 px-4 sm:px-8">
        <div class="w-full max-w-md bg-white/30 backdrop-blur-lg rounded-xl border-2 border-white shadow-xl overflow-hidden p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white">Create Your Account</h2>
                <p class="text-white/80 mt-2">Join us today to get started!</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" class="text-white" />
                        <x-text-input 
                            id="first_name" 
                            class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white" 
                            type="text" 
                            name="first_name" 
                            :value="old('first_name')" 
                            required 
                            autofocus 
                            autocomplete="given-name"
                            placeholder="Juan" 
                        />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2 text-sm text-red-200" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" class="text-white" />
                        <x-text-input 
                            id="last_name" 
                            class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white" 
                            type="text" 
                            name="last_name" 
                            :value="old('last_name')" 
                            required 
                            autocomplete="family-name"
                            placeholder="Cruz" 
                        />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-sm text-red-200" />
                    </div>
                </div>

                <!-- Birthdate -->
                <div>
                    <x-input-label for="birthdate" :value="__('Birthdate')" class="text-white" />
                    <x-text-input 
                        id="birthdate" 
                        class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white" 
                        type="date" 
                        name="birthdate" 
                        :value="old('birthdate')" 
                    />
                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2 text-sm text-red-200" />
                </div>
                
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username"
                        placeholder="your@email.com" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-200" />
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-white" />
                        <div class="relative">
                            <x-text-input 
                                id="password" 
                                class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white pr-12"
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <button type="button" 
                                    class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-white/50 hover:text-white"
                                    onclick="togglePasswordVisibility('password')"
                                    aria-label="Toggle password visibility">
                                <svg id="password-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="password-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-200" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                        <div class="relative">
                            <x-text-input 
                                id="password_confirmation" 
                                class="block mt-1 w-full px-4 py-3 bg-white/20 backdrop-blur-sm text-white placeholder-white/50 rounded-lg border-white/30 focus:border-white focus:ring-white pr-12"
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <button type="button" 
                                    class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-white/50 hover:text-white"
                                    onclick="togglePasswordVisibility('password_confirmation')"
                                    aria-label="Toggle password visibility">
                                <svg id="password_confirmation-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="password_confirmation-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-200" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a class="text-sm text-white hover:text-white/80 transition-colors" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button dusk="register-button" type="submit" class="btn-17 backdrop-blur-sm border border-white/30">
                        <span class="text-container">
                            <span class="text tracking-wider">{{ __('Register') }}</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="mt-8 text-center text-sm text-white bg-white/10 py-4 sm:py-6 px-4 rounded-xl shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)]">
        <div class="flex justify-center gap-4 sm:gap-6 mb-3 sm:mb-4">
            <a href="#" class="transition-colors">
                <div class="bg-white p-2 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-blue-600">
                        <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                    </svg>
                </div>
            </a>
            <a href="#" class="transition-colors">
                <div class="bg-white p-2 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-red-600">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                    </svg>
                </div>
            </a>
            <a href="#" class="transition-colors">
                <div class="bg-white p-2 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-pink-600">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
            </a>
        </div>
        <p class="text-xs sm:text-sm">&copy; {{ date('Y') }} Radio Engineering Circle Inc. All rights reserved.</p>
    </footer>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`${fieldId}-eye-icon`);
            const eyeSlashIcon = document.getElementById(`${fieldId}-eye-slash-icon`);
            
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
    </script>
</body>
</html>