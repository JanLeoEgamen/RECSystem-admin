<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Password Reset - REC Inc.</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-blue {
                background-image: linear-gradient(-45deg, #101966, #5e6ffb, #1A25A1,rgb(5, 10, 34));
                background-size: 400% 400%;
                animation: gradientFlow 15s ease infinite;
            }
            .container-shadow {
                @apply shadow-lg;
            }
            .dax-regular {
                font-family: 'Dax', sans-serif;
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

            /* Modified from Uiverse.io by gharsh11032000 */ 
            .animated-button {
                position: relative;
                display: flex;
                align-items: center;
                gap: 4px;
                padding: 12px 28px;
                border: 3px solid;
                border-color: transparent;
                font-size: 14px;
                background-color: inherit;
                border-radius: 100px;
                font-weight: 600;
                color:rgb(255, 255, 255);
                box-shadow: 0 0 0 2px #101966;
                cursor: pointer;
                overflow: hidden;
                transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button svg {
                position: absolute;
                width: 20px;
                fill: #101966;
                z-index: 9;
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button .arr-1 {
                right: 12px;
            }

            .animated-button .arr-2 {
                left: -25%;
            }

            .animated-button .circle {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 16px;
                height: 16px;
                background-color: #101966;
                border-radius: 50%;
                opacity: 0;
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button .text {
                position: relative;
                z-index: 1;
                transform: translateX(-10px);
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button:hover {
                box-shadow: 0 0 0 12px transparent;
                color: white;
                border-radius: 12px;
            }

            .animated-button:hover .arr-1 {
                right: -25%;
            }

            .animated-button:hover .arr-2 {
                left: 12px;
            }

            .animated-button:hover .text {
                transform: translateX(10px);
            }

            .animated-button:hover svg {
                fill: white;
            }

            .animated-button:active {
                scale: 0.95;
                box-shadow: 0 0 0 4px #101966;
            }

            .animated-button:hover .circle {
                width: 180px;
                height: 180px;
                opacity: 1;
            }    

            /* From Uiverse.io by doniaskima - Modified for text color fix */
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
            
            /* Form styling */
            .form-input {
                @apply w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/30 rounded-lg text-white placeholder-white/70 focus:ring-2 focus:ring-blue-400 focus:border-transparent;
            }
            
            .form-label {
                @apply block text-white font-medium mb-2 text-sm;
            }
            
            .form-button {
                @apply w-full bg-blue-600/90 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5 shadow-md;
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

    <header class="header relative py-4 px-4 sm:px-8 flex justify-between items-center text-white bg-white/10 shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1)]">
        <!-- Logo Section -->
        <div class="logo flex items-center">
            <img src="/images/Logo.png" alt="Club Logo" class="w-12 h-12 sm:w-16 sm:h-16 object-contain hover:scale-110 transition-transform">
            <h2 class="text-xl sm:text-xl font-bold ml-2 sm:ml-4">RADIO ENGINEERING CIRCLE INC.</h2>
        </div>

        <!-- Back to Home Button -->
        <a href="{{ url('/') }}" class="animated-button">
            <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
            <span class="text">Back to Home</span>
            <span class="circle"></span>
            <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
        </a>
    </header>

    <main class="flex-1 py-8 px-4 sm:px-8 flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-[#101966] backdrop-blur-lg p-8 rounded-lg border-2 border-white shadow-xl">
                <div class="flex flex-col items-center mb-6">
                    <img src="/images/Logo.png" alt="Club Logo" class="w-20 h-20 object-contain mb-4">
                    <h2 class="text-2xl font-extrabold text-white drop-shadow-md">Password Reset</h2>
                </div>

                <div class="mb-6 text-sm text-white/90">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-3 bg-green-500/20 backdrop-blur-sm text-green-100 rounded-lg border border-green-400/30">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address" />
                        @error('email')
                            <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center mt-6">
                        <button type="submit" class="form-button">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="text-center text-sm text-white bg-white/10 py-4 sm:py-6 px-4 rounded-xl shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)] mt-8">
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
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
            </a>
        </div>
        <p class="text-xs sm:text-sm">&copy; {{ date('Y') }} Radio Engineering Circle Inc. All rights reserved.</p>
    </footer>
</body>
</html>