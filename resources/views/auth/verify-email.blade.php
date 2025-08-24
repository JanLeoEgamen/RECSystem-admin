<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a"}
                    }
                }
            }
        }
    </script>
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }
        .countdown-digit {
            background: linear-gradient(145deg, #f0f0f0, #e0e0e0);
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: bold;
            box-shadow: 3px 3px 6px #d1d1d1, -3px -3px 6px #ffffff;
        }
        .dark .countdown-digit {
            background: linear-gradient(145deg, #2d3748, #1a202c);
            box-shadow: 3px 3px 6px #1a202c, -3px -3px 6px #2d3748;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .progress-ring {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white p-3 rounded-full">
                        <i class="fas fa-envelope text-blue-500 text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white">Verify Your Email</h1>
                <p class="text-blue-100 mt-2">Secure access to your account</p>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <div class="mb-6 text-sm text-gray-600 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <p class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>
                </div>

                <div id="statusMessage" class="hidden mb-6 font-medium text-sm p-4 rounded-lg">
                    <i class="fas mr-2" id="statusIcon"></i>
                    <span id="statusText"></span>
                </div>

                <div class="mt-6 flex flex-col space-y-4">
                    <!-- Resend Button with Countdown -->
                    <div class="text-center">
                        <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                            @csrf
                            <button type="submit" id="resendButton" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 pulse flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Resend Verification Email
                            </button>
                        </form>
                        
                        <div id="countdownContainer" class="hidden mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-gray-600 dark:text-gray-300 mb-3 flex items-center justify-center">
                                <i class="fas fa-clock mr-2 text-blue-500"></i>
                                Please wait before requesting another email
                            </p>
                            
                            <div class="flex justify-center items-center space-x-4 mb-4">
                                <div class="text-center">
                                    <div class="countdown-digit text-xl text-gray-800 dark:text-white" id="minutes">02</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minutes</div>
                                </div>
                                <div class="text-xl text-gray-500 dark:text-gray-300">:</div>
                                <div class="text-center">
                                    <div class="countdown-digit text-xl text-gray-800 dark:text-white" id="seconds">00</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Seconds</div>
                                </div>
                            </div>
                            
                            <div class="relative w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                                <div id="progressBar" class="absolute h-2 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Log Out Button -->
                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-300 flex items-center justify-center mx-auto">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 text-center text-xs text-gray-500 dark:text-gray-400">
                <p>© 2023 REC-ON. All rights reserved.</p>
            </div>
        </div>
        
        <!-- Dark Mode Toggle -->
        <div class="mt-6 text-center">
            <button id="themeToggle" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-300">
                <i class="fas fa-moon"></i> Toggle Dark Mode
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendForm = document.getElementById('resendForm');
            const resendButton = document.getElementById('resendButton');
            const countdownContainer = document.getElementById('countdownContainer');
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');
            const progressBar = document.getElementById('progressBar');
            const statusMessage = document.getElementById('statusMessage');
            const statusText = document.getElementById('statusText');
            const statusIcon = document.getElementById('statusIcon');
            const themeToggle = document.getElementById('themeToggle');
            
            let countdownInterval;
            const COUNTDOWN_TIME = 120; // 120 seconds = 2 minutes
            
            // Check if we need to start the countdown (if the button was recently clicked)
            checkExistingCountdown();
            
            // Set up event listeners
            resendForm.addEventListener('submit', handleResendSubmit);
            themeToggle.addEventListener('click', toggleTheme);
            
            async function handleResendSubmit(e) {
                e.preventDefault();
                
                // Show loading state
                resendButton.disabled = true;
                resendButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
                
                try {
                    // Make an AJAX request to your backend endpoint
                    const response = await fetch('{{ route("verification.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({}),
                        credentials: 'same-origin'
                    });
                    
                    if (response.ok) {
                        // Show success message
                        showStatus('A new verification link has been sent to the email address you provided during registration.', 'success');
                        
                        // Disable the button and show countdown
                        resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
                        resendButton.disabled = true;
                        resendButton.classList.remove('pulse');
                        resendButton.classList.add('opacity-75', 'cursor-not-allowed');
                        countdownContainer.classList.remove('hidden');
                        
                        // Store the timestamp in localStorage to persist across page refreshes
                        const now = new Date().getTime();
                        localStorage.setItem('resendCooldown', now);
                        
                        // Start the countdown
                        startCountdown();
                        
                        // Reload the page to show the server-side status message
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        // Show error message
                        showStatus('Failed to send verification email. Please try again.', 'error');
                        resendButton.disabled = false;
                        resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showStatus('An error occurred. Please try again.', 'error');
                    resendButton.disabled = false;
                    resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
                }
            }
            
            function showStatus(message, type) {
                statusText.textContent = message;
                statusMessage.classList.remove('hidden');
                
                if (type === 'success') {
                    statusMessage.classList.remove('bg-red-50', 'text-red-600', 'dark:bg-red-900/20', 'dark:text-red-400');
                    statusMessage.classList.add('bg-green-50', 'text-green-600', 'dark:bg-green-900/20', 'dark:text-green-400');
                    statusIcon.classList.remove('fa-exclamation-circle');
                    statusIcon.classList.add('fa-check-circle');
                } else {
                    statusMessage.classList.remove('bg-green-50', 'text-green-600', 'dark:bg-green-900/20', 'dark:text-green-400');
                    statusMessage.classList.add('bg-red-50', 'text-red-600', 'dark:bg-red-900/20', 'dark:text-red-400');
                    statusIcon.classList.remove('fa-check-circle');
                    statusIcon.classList.add('fa-exclamation-circle');
                }
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    statusMessage.classList.add('hidden');
                }, 5000);
            }
            
            function startCountdown() {
                let timeLeft = COUNTDOWN_TIME;
                const totalTime = COUNTDOWN_TIME;
                
                updateCountdownDisplay(timeLeft);
                
                // Update the countdown every second
                countdownInterval = setInterval(function() {
                    timeLeft--;
                    updateCountdownDisplay(timeLeft);
                    
                    // Update progress bar
                    const progressPercent = (timeLeft / totalTime) * 100;
                    progressBar.style.width = `${progressPercent}%`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        resendButton.disabled = false;
                        resendButton.classList.remove('opacity-75', 'cursor-not-allowed');
                        resendButton.classList.add('pulse');
                        countdownContainer.classList.add('hidden');
                        localStorage.removeItem('resendCooldown');
                    }
                }, 1000);
            }
            
            function updateCountdownDisplay(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                
                minutesElement.textContent = minutes.toString().padStart(2, '0');
                secondsElement.textContent = remainingSeconds.toString().padStart(2, '0');
            }
            
            function checkExistingCountdown() {
                const storedTime = localStorage.getItem('resendCooldown');
                if (storedTime) {
                    const now = new Date().getTime();
                    const elapsedTime = Math.floor((now - parseInt(storedTime)) / 1000);
                    const timeLeft = COUNTDOWN_TIME - elapsedTime;
                    
                    if (timeLeft > 0) {
                        // Continue the countdown from where it left off
                        resendButton.disabled = true;
                        resendButton.classList.remove('pulse');
                        resendButton.classList.add('opacity-75', 'cursor-not-allowed');
                        countdownContainer.classList.remove('hidden');
                        
                        // Calculate progress
                        const progressPercent = (timeLeft / COUNTDOWN_TIME) * 100;
                        progressBar.style.width = `${progressPercent}%`;
                        
                        updateCountdownDisplay(timeLeft);
                        startCountdown();
                    } else {
                        // Clear the stored time if it's expired
                        localStorage.removeItem('resendCooldown');
                    }
                }
            }
            
            function toggleTheme() {
                const html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i> Toggle Dark Mode';
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i> Toggle Light Mode';
                    localStorage.setItem('theme', 'dark');
                }
            }
            
            // Check for saved theme preference
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i> Toggle Light Mode';
            }
        });
    </script>
</body>
</html>