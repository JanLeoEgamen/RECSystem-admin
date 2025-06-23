<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>REC Inc. Admin</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-blue {
                background-image: linear-gradient(-45deg, #101966, #5e6ffb, #1A25A1,rgb(5, 10, 34));
                background-size: 400% 400%;
                animation: gradientFlow 15s ease infinite;
            }
            .admin-activity-item {
                @apply mb-2 text-white flex items-center gap-2 p-2 rounded transition-colors cursor-pointer;
            }
            .admin-activity-item:hover {
                @apply text-white bg-[#5E6FFB];
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
                border: 2px solid rgba(255, 255, 255, 0.2); /* Increased visibility */
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
                    opacity: 0.4; /* Increased visibility */
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
                padding: 12px 28px; /* Reduced padding for smaller size */
                border: 3px solid; /* Reduced border thickness */
                border-color: transparent;
                font-size: 14px; /* Smaller font size */
                background-color: inherit;
                border-radius: 100px;
                font-weight: 600;
                color:rgb(255, 255, 255); /* New text color */
                box-shadow: 0 0 0 2px #101966; /* New shadow color */
                cursor: pointer;
                overflow: hidden;
                transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button svg {
                position: absolute;
                width: 20px; /* Smaller icon size */
                fill: #101966; /* New icon color */
                z-index: 9;
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button .arr-1 {
                right: 12px; /* Adjusted position */
            }

            .animated-button .arr-2 {
                left: -25%;
            }

            .animated-button .circle {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 16px; /* Smaller circle */
                height: 16px; /* Smaller circle */
                background-color: #101966; /* New circle color */
                border-radius: 50%;
                opacity: 0;
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button .text {
                position: relative;
                z-index: 1;
                transform: translateX(-10px); /* Adjusted position */
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .animated-button:hover {
                box-shadow: 0 0 0 12px transparent;
                color: white; /* Changed hover text color for better contrast */
                border-radius: 12px;
            }

            .animated-button:hover .arr-1 {
                right: -25%;
            }

            .animated-button:hover .arr-2 {
                left: 12px; /* Adjusted position */
            }

            .animated-button:hover .text {
                transform: translateX(10px); /* Adjusted position */
            }

            .animated-button:hover svg {
                fill: white; /* Changed hover icon color for better contrast */
            }

            .animated-button:active {
                scale: 0.95;
                box-shadow: 0 0 0 4px #101966; /* New shadow color */
            }

            .animated-button:hover .circle {
                width: 180px; /* Smaller circle expansion */
                height: 180px; /* Smaller circle expansion */
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
                /* Removed mix-blend-mode to fix text color */
            }

            .btn-17 .text {
                display: block;
                position: relative;
                color: white; /* Force white text by default */
                transition: color 0.3s ease;
            }

            .btn-17:hover .text {
                color: #101966; /* Force dark blue text on hover */
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
        
            .animate-showup {
                animation: showup 7s forwards; /* Removed 'infinite', added 'forwards' */
            }
            
            .animate-reveal {
                animation: reveal 7s forwards;
            }
            
            .animate-slidein {
                animation: slidein 7s forwards;
            }
            
            @keyframes showup {
                0% { opacity: 0; }
                20% { opacity: 1; }
                80% { opacity: 1; }
                100% { opacity: 1; } /* Changed to stay visible */
            }
            
            @keyframes slidein {
                0% { margin-left: -200px; }
                20% { margin-left: -200px; }
                35% { margin-left: 0px; }
                100% { margin-left: 0px; } /* Stays in place */
            }
            
            @keyframes reveal {
                0% { opacity: 0; width: 0px; }
                20% { opacity: 1; width: 0px; }
                30% { width: 150px; }
                80% { opacity: 1; }
                100% { opacity: 1; width: 150px; } /* Stays in place */
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

    <header class="relative py-4 px-4 sm:px-8 flex flex-col sm:flex-row justify-between items-center text-white bg-white/10 shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1)]">
        <!-- Logo Section -->
        <div class="logo flex items-center mb-4 sm:mb-0">
            <img src="/images/Logo.png" alt="Club Logo" class="w-12 h-12 sm:w-16 sm:h-16 object-contain hover:scale-110 transition-transform">
            <h2 class="text-xl sm:text-xl font-bold ml-2 sm:ml-4">RADIO ENGINEERING CIRCLE INC.</h2>
        </div>

        <!-- Centered Text -->
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
            <div class="inline-block overflow-hidden whitespace-nowrap animate-showup">
                <span class="text-xl sm:text-lg lg:text-4xl font-extrabold tracking-wide text-white">ADMIN</span>
            </div>
            <div class="inline-block overflow-hidden whitespace-nowrap w-0 animate-reveal">
                <span class="text-xl sm:text-lg lg:text-4xl font-extrabold tracking-wide text-white -ml-[150px] animate-slidein">PORTAL</span>
            </div>
        </div>

        <!-- Button -->
        <button class="animated-button">
            <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
            <span class="text">Visit RECInc. Website</span>
            <span class="circle"></span>
            <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
        </button>
    </header>

    <main class="flex-1 py-5 px-4 sm:px-8">
        <div class="container mx-auto max-w-7xl flex flex-col lg:flex-row justify-center gap-5 mt-4 sm:mt-8">
            <!-- Left Section -->
            <div class="flex-[2] flex flex-col gap-5 order-2 lg:order-1">
                <!-- Animation Container -->
                <div class="bg-white/20 backdrop-blur-sm p-4 sm:p-5 rounded-lg border-2 border-white shadow-lg">
                    <iframe 
                        src="https://lottie.host/embed/e905052e-c38a-4b16-934d-08c8241768aa/HkPG6NrpAB.lottie" 
                        class="w-full h-[300px] sm:h-[350px] border-none rounded-lg transform scale-[1.25] origin-center"
                    ></iframe>
                </div>
                
                <!-- Activities Container -->
                <div class="flex flex-col md:flex-row gap-5">
                    <!-- Admin Activities -->
                    <div class="flex-[2] bg-white/30 backdrop-blur-md p-4 sm:p-5 rounded-lg border-2 border-white shadow-lg">
                        <div class="rounded-md">
                            <h2 class="text-white mb-4 flex items-center gap-2 text-base font-bold sm:text-lg">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 013-3h13.5a3 3 0 013 3V15a3 3 0 01-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 01-.53 1.28h-9a.75.75 0 01-.53-1.28l.621-.622a2.25 2.25 0 00.659-1.59V18h-3a3 3 0 01-3-3V5.25zm1.5 0v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5z" clip-rule="evenodd" />
                                </svg>
                                ADMINISTRATOR ACTIVITIES
                            </h2>
                            <ul class="list-none p-0 m-0">
                                <li class="admin-activity-item">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-[18px] h-[18px] text-[#1d4ed8]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                                        </svg>
                                    </div>
                                    User Management
                                </li>
                                <li class="admin-activity-item">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-[18px] h-[18px] text-[#1d4ed8]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 006 21.75a6.721 6.721 0 003.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 01-.814 1.686.75.75 0 00.44 1.223zM8.25 10.875a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zM10.875 12a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875-1.125a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Website Content Management
                                </li>
                                <li class="admin-activity-item">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-[18px] h-[18px] text-[#1d4ed8]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    License Management
                                </li>
                                <li class="admin-activity-item">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg class="w-[18px] h-[18px] text-[#1d4ed8]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                                            <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                                        </svg>
                                    </div>
                                    Membership Management
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Note Container -->
                    <div class="flex-[3] bg-white/20 backdrop-blur-md p-4 sm:p-5 rounded-lg border-2 border-white shadow-lg">
                        <h3 class="text-base text-center sm:text-lg font-extrabold text-white mb-3 drop-shadow-md">
                            WELCOME TO RECINC. ADMIN PORTAL
                        </h3>
                        <p class="text-white/90 text-sm sm:text-base text-justify indent-6 drop-shadow-sm">
                            This page serves as the administrative portal for REC officers.
                            As an officer of the Radio Engineering Circle Inc., you have access to tools for managing members, overseeing content, and maintaining the organization's operations. Use this platform to help lead, organize, and support the REC community effectively.
                            Only authorized REC officers are permitted to access and manage this portal. Unauthorized use is strictly prohibited.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex-1 text-center flex flex-col justify-start order-1 lg:order-2">
                <div class="bg-white/30 backdrop-blur-lg p-6 sm:p-8 rounded-lg sticky top-4 sm:top-8 border-2 border-white shadow-xl">
                    <div class="flex flex-col items-center mb-4">
                        <img src="/images/Logo.png" alt="Club Logo" class="w-16 h-16 sm:w-20 sm:h-20 object-contain mb-2">
                        <h3 class="text-xl text-white sm:text-2xl font-extrabold drop-shadow-md">Radio Engineering Circle Inc.</h3>
                    </div>

                    @if (Route::has('login'))
                        @auth
                            @php
                                $user = auth()->user();

                                $applicant = App\Models\Applicant::where('user_id', $user->id)->first();
                                
                                if ($user->hasRole('Applicant') && $applicant && $applicant->status === 'Pending') {
                                    $dashboardLink = route('applicant.thankyou');
                                } elseif ($user->hasRole('Member')) {
                                    $dashboardLink = route('member.dashboard');
                                } else {
                                    $dashboardLink = url('/dashboard');
                                }
                            @endphp

                            <div class="sign-in mb-4">
                                <a href="{{ $dashboardLink }}">
                                    <button class="bg-blue-600/90 text-white border-none rounded-full py-2 px-4 sm:py-3 sm:px-6 text-sm sm:text-base cursor-pointer transition-all hover:bg-blue-700 hover:-translate-y-0.5 w-full max-w-[200px] shadow-md">
                                        Dashboard
                                    </button>
                                </a>
                            </div>
                        @else
                            <div class="sign-in mb-6">
                                <a href="{{ route('login') }}">
                                    <button class="btn-17 w-full max-w-[200px] backdrop-blur-sm border border-white/30">
                                        <span class="text-container">
                                            <span class="text tracking-wider text-white drop-shadow-md">Login</span>
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <p class="mb-2 text-sm sm:text-base text-white/90 drop-shadow-sm">Don't have an Account?</p>
                            <div class="sign-in mb-6">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <button class="btn-17 w-full max-w-[200px] backdrop-blur-sm border border-white/30">
                                            <span class="text-container">
                                                <span class="text tracking-wider text-white drop-shadow-md">Register</span>
                                            </span>
                                        </button>
                                    </a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>

                <!-- New Illustration Container with Frosted Glass Effect -->
                <div class="bg-white/20 backdrop-blur-sm p-4 sm:p-5 rounded-lg border-2 border-white shadow-lg mt-6">
                    <h4 class="text-base sm:text-lg font-bold text-white mb-4">Explore REC Vision and Mission</h4>
                    <iframe 
                        src="https://lottie.host/embed/3a692d09-6655-4b4b-9e86-917137e50b1f/hgzicWwLi8.lottie" 
                        class="w-full h-[200px] sm:h-[195px] border-none rounded-lg scale-x-125"
                    ></iframe>
                </div>
            </div>

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
        <p class="text-xs sm:text-sm">&copy; {{ date('Y') }} Amateur Radio Club. All rights reserved.</p>
    </footer>
</body>
</html>