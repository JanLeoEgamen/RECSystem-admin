<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'pulse-fast': 'pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'bubble': 'bubble 15s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        bubble: {
                            '0%': { transform: 'translateY(0) translateX(0) scale(0.5)', opacity: '0.1' },
                            '50%': { opacity: '0.3' },
                            '100%': { transform: 'translateY(-1000px) translateX(200px) scale(1.5)', opacity: '0' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
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
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden; }
        
        .wave {
            position: absolute; border: 2px solid rgba(255, 255, 255, 0.2); border-radius: 1000px; animation: waveAnimation 8s infinite ease-out; }
        
        /* Top-left waves */
        .wave:nth-child(1) { 
            width: 300px; height: 300px; left: -150px; top: -150px; animation-delay: 0s; }
        
        .wave:nth-child(2) {
            width: 500px; height: 500px; left: -250px; top: -250px; animation-delay: 1s; }
        
        .wave:nth-child(3) {
            width: 700px; height: 700px; left: -350px; top: -350px; animation-delay: 2s; }
        
        .wave:nth-child(4) {
            width: 900px; height: 900px; left: -450px; top: -450px; animation-delay: 3s; }
        
        /* Bottom-right waves */
        .wave:nth-child(5) {
            width: 300px; height: 300px; right: -150px; bottom: -150px; animation-delay: 0.5s; }
        
        .wave:nth-child(6) {
            width: 500px; height: 500px; right: -250px; bottom: -250px; animation-delay: 1.5s; }
        
        .wave:nth-child(7) {
            width: 700px; height: 700px; right: -350px; bottom: -350px; animation-delay: 2.5s; }
        
        .wave:nth-child(8) {
            width: 900px; height: 900px; right: -450px; bottom: -450px; animation-delay: 3.5s; }
        
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
        
        /* Bubbles */
        .bubbles {
            position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: -1; overflow: hidden;
        }
        
        .bubble {
            position: absolute; bottom: -100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: bubble 15s linear infinite; }
        
        .bubble:nth-child(1) {
            width: 40px; height: 40px; left: 10%; animation-duration: 8s;
        }
        
        .bubble:nth-child(2) {
            width: 20px; height: 20px; left: 20%; animation-duration: 5s; animation-delay: 1s; }
        
        .bubble:nth-child(3) {
            width: 50px; height: 50px; left: 35%; animation-duration: 7s; animation-delay: 2s; }
        
        .bubble:nth-child(4) {
            width: 80px; height: 80px; left: 50%; animation-duration: 11s; animation-delay: 0s; }
        
        .bubble:nth-child(5) {
            width: 35px; height: 35px; left: 55%; animation-duration: 6s; animation-delay: 1s; }
        
        .bubble:nth-child(6) {
            width: 45px; height: 45px; left: 65%; animation-duration: 8s; animation-delay: 3s; }
        
        .bubble:nth-child(7) {
            width: 25px; height: 25px; left: 75%; animation-duration: 7s; animation-delay: 2s; }
        
        .bubble:nth-child(8) {
            width: 80px; height: 80px; left: 80%; animation-duration: 6s; animation-delay: 1s; }
        
        .bubble:nth-child(9) {
            width: 15px; height: 15px; left: 70%; animation-duration: 5s; animation-delay: 0s; }
        
        .bubble:nth-child(10) {
            width: 50px; height: 50px; left: 85%; animation-duration: 9s; animation-delay: 3s;}
        
        /* Organization header */
        .org-header {
            transition: all 0.3s ease;
        }
        
        .org-header:hover {
            transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
        
        .org-logo {
            transition: all 0.3s ease; }
        
        .org-header:hover .org-logo {
            transform: rotate(5deg) scale(1.05); }
            
        /* Banner image container */
        .banner-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .checkmark-circle {
            animation: checkmarkScale 0.5s ease-in-out both;
        }

        @keyframes checkmarkScale {
            0% { transform: scale(0); opacity: 0; }
            80% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gradient-blue flex flex-col min-h-screen">
    <!-- Radio Wave Background Animation -->
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
    
    <!-- Bubbles Background -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>
    
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <!-- Floating decorative elements -->
        <div class="fixed top-20 left-10 w-16 h-16 rounded-full bg-[#5e6ffb] opacity-20 animate-float"></div>
        <div class="fixed bottom-32 right-20 w-24 h-24 rounded-full bg-[#101966] opacity-15 animate-float" style="animation-delay: 0.5s;"></div>
        <div class="fixed top-1/3 right-1/4 w-12 h-12 rounded-full bg-white opacity-10 animate-float" style="animation-delay: 0.8s;"></div>

        <div class="max-w-3xl mx-auto relative">
            <!-- Organization Header with Banner -->
            <div class="org-header mb-8 bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300">
                <!-- Banner Image Container -->
                <div class="banner-container bg-gradient-to-r from-[#101966] to-[#5e6ffb]">
                    <img src="/images/License.png" alt="Banner" class="banner-image">
                </div>
                
                <div class="flex items-center p-6">
                    <div class="org-logo mr-4 p-3 rounded-lg">
                        <img src="/images/Logo.png" alt="Banner" class="banner-image">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-[#101966]">Radio Engineering Circle Inc</h1>
                        <p class="text-blue-500">Knowledge Assessment Portal</p>
                    </div>
                </div>
            </div>
            
            <!-- Thank You Card -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Header -->
                <div class="p-8 bg-gradient-to-r from-[#101966] to-[#5e6ffb] text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white opacity-10"></div>
                    <div class="absolute -left-5 -bottom-5 w-20 h-20 rounded-full bg-white opacity-5"></div>
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold relative z-10">Thank You!</h1>
                            <p class="mt-2 opacity-90">We appreciate your participation</p>
                        </div>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="p-8 text-center relative overflow-hidden">
                    <!-- Animated Checkmark -->
                    <div class="flex justify-center mb-6">
                        <div class="checkmark-circle">
                            <svg class="h-24 w-24 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-semibold text-[#101966] mb-4">Your responses have been recorded</h2>
                    <p class="text-gray-600 mb-8 max-w-lg mx-auto">We sincerely appreciate the time you've taken to provide us with your valuable feedback. Your input helps us improve our services.</p>
                    
                    <div class="bg-blue-50 rounded-lg p-6 border border-blue-100 inline-block max-w-md mx-auto">
                        <h3 class="text-lg font-medium text-[#101966] mb-3 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            What happens next?
                        </h3>
                        <p class="text-sm text-gray-600">Our team will review your feedback carefully. If you provided contact information, we may reach out for follow-up questions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple confetti effect
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#5e6ffb', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = -10 + 'px';
                confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = Math.random() * 10 + 5 + 'px';
                
                document.body.appendChild(confetti);
                
                const animationDuration = Math.random() * 3 + 2;
                
                const keyframes = [
                    { 
                        transform: `translate(${Math.random() * 200 - 100}px, ${window.innerHeight}px) rotate(${Math.random() * 360}deg)`,
                        opacity: 0 
                    },
                    { opacity: 1 },
                    { 
                        transform: `translate(${Math.random() * 200 - 100}px, ${Math.random() * 400 + 100}px) rotate(${Math.random() * 360}deg)`,
                        opacity: 0 
                    }
                ];
                
                const options = {
                    duration: animationDuration * 1000,
                    iterations: 1,
                    delay: Math.random() * 2000
                };
                
                confetti.animate(keyframes, options);
                
                setTimeout(() => {
                    confetti.remove();
                }, animationDuration * 1000);
            }
        });
    </script>
</body>
</html>