<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - Quiz</title>
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
            
            <div class="bg-white shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Quiz Header -->
                <div class="p-8 bg-gradient-to-r from-[#101966] to-[#5e6ffb] text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white opacity-10"></div>
                    <div class="absolute -left-5 -bottom-5 w-20 h-20 rounded-full bg-white opacity-5"></div>
                    <div class="flex items-center">
                        <div>
                            <span class="mr-3 px-3 py-1 rounded-full text-sm font-bold bg-white text-[#101966] shadow-md">{{ count($quiz->questions) }} Questions</span>
                            <h1 class="text-3xl font-bold relative z-10 mt-4">{{ $quiz->title }}</h1>
                        </div>
                    </div>
                    @if($quiz->description)
                        <p class="mt-4 text-blue-100 relative z-10">{{ $quiz->description }}</p>
                    @endif
                </div>
                
                <!-- Content Area -->
                <div class="p-8">
                    <!-- User Information Section -->
                    <div class="mb-8 p-6 bg-blue-50 rounded-xl border border-blue-100 transform transition hover:scale-[1.005] relative overflow-hidden">
                        <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full bg-[#5e6ffb] opacity-10"></div>
                        <h2 class="text-xl font-semibold text-[#101966] relative z-10 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Please enter your information
                        </h2>
                        <form id="memberInfoForm" class="mt-6 space-y-6">
                            <div class="relative">
                                <label for="name" class="block text-sm font-medium text-[#101966] mb-1">Full Name</label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-lg border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 border-2 pl-10" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <label for="email" class="block text-sm font-medium text-[#101966] mb-1">Email</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-lg border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 border-2 pl-10" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Quiz Form -->
                    <form id="quizForm" action="{{ route('quiz.submit', $quiz->link) }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="name" id="formName">
                        <input type="hidden" name="email" id="formEmail">
                        
                        <div class="space-y-8">
                            @foreach($quiz->questions as $index => $question)
                                <div class="question p-6 border-2 border-blue-100 rounded-xl bg-white hover:border-[#5e6ffb] transition-all duration-200 relative overflow-hidden group" data-index="{{ $index }}">
                                    <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full bg-[#5e6ffb] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-[#101966] flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Question #{{ $loop->iteration }}
                                        </h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#5e6ffb] text-white shadow-md">{{ $question->points }} points</span>
                                    </div>
                                    <p class="mt-3 text-gray-700 leading-relaxed">{{ $question->question }}</p>
                                    
                                    <div class="mt-6 answer-container">
                                        @if($question->type === 'multiple_choice')
                                            <div class="space-y-4">
                                                @foreach($question->answers as $answer)
                                                    <div class="flex items-center">
                                                        <div class="flex items-center h-5">
                                                            <input id="answer_{{ $answer->id }}" name="question_{{ $question->id }}" type="radio" value="{{ $answer->id }}" class="h-5 w-5 text-[#5e6ffb] focus:ring-[#5e6ffb] border-blue-300 rounded-full transition-all">
                                                        </div>
                                                        <label for="answer_{{ $answer->id }}" class="ml-3 block text-sm font-medium text-gray-700 hover:text-[#101966] cursor-pointer transition-colors duration-200">
                                                            {{ $answer->answer }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'identification')
                                            <div class="relative mt-3">
                                                <input type="text" name="question_{{ $question->id }}" class="block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 pl-10">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @elseif($question->type === 'enumeration')
                                            <div class="enumeration-items space-y-3 mt-3">
                                                @foreach($question->answers as $index => $answer)
                                                    <div class="relative">
                                                        <input type="text" name="question_{{ $question->id }}[]" class="block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 pl-10" placeholder="Item {{ $index + 1 }}">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-[#5e6ffb] font-bold">{{ $index + 1 }}.</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>                                    
                                        @elseif($question->type === 'essay')
                                            <textarea name="question_{{ $question->id }}" rows="5" class="mt-3 block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3" placeholder="Type your answer here..."></textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Submit Button and Timer -->
                        <div class="mt-10 flex justify-between items-center">
                            @if($quiz->time_limit)
                                <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] text-white px-5 py-3 rounded-xl shadow-lg font-bold text-lg flex items-center" id="timer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Time Remaining: <span id="time" class="font-mono ml-1">{{ gmdate("i:s", $quiz->time_limit) }}</span>
                                </div>
                            @endif
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-lg font-semibold rounded-xl shadow-md text-white bg-gradient-to-r from-[#101966] to-[#5e6ffb] hover:from-[#5e6ffb] hover:to-[#101966] transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e6ffb] group">
                                <span>Submit Quiz</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            document.getElementById('formName').value = document.getElementById('name').value;
            document.getElementById('formEmail').value = document.getElementById('email').value;
        });

        @if($quiz->time_limit)
            // Initialize timer
            let timeLeft = {{ $quiz->time_limit }};
            const timerElement = document.getElementById('timer');
            const timeDisplay = document.getElementById('time');
            
            // Function to update the timer display
            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timeDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // Add pulse animation and change color when time is running low
                if (timeLeft <= 30) {
                    timerElement.classList.add('animate-pulse-fast');
                    timerElement.style.background = 'linear-gradient(to right, #ef4444, #dc2626)';
                }
            }
            
            // Initial display
            updateTimer();
            
            // Start the countdown
            const timerInterval = setInterval(function() {
                timeLeft--;
                updateTimer();
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('quizForm').submit();
                }
            }, 1000);
        @endif
    </script>
</body>
</html>