<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - {{ $attempt->quiz->title }}</title>
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

        .correct-answer {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.5);
        }

        .incorrect-answer {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.5);
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
                            <span class="mr-3 px-3 py-1 rounded-full text-sm font-bold bg-white text-[#101966] shadow-md">{{ count($attempt->quiz->questions) }} Questions</span>
                            <h1 class="text-3xl font-bold relative z-10 mt-4">Quiz Results: {{ $attempt->quiz->title }}</h1>
                        </div>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="p-8">
                    <!-- Participant Info Section -->
                    <div class="mb-8 p-6 bg-blue-50 rounded-xl border border-blue-100 transform transition hover:scale-[1.005] relative overflow-hidden">
                        <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full bg-[#5e6ffb] opacity-10"></div>
                        <h2 class="text-xl font-semibold text-[#101966] relative z-10 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Participant Information
                        </h2>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-[#101966] mb-1">Name</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $attempt->member->first_name }} {{ $attempt->member->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#101966] mb-1">Completed On</p>
                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($attempt->completed_at)->format('F j, Y g:i a') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Score Summary -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-[#101966] to-[#5e6ffb] rounded-xl text-white relative overflow-hidden">
                        <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full bg-white opacity-10"></div>
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-xl font-semibold">Your Score</h3>
                                <p class="text-sm opacity-80">Based on {{ count($attempt->quiz->questions) }} questions</p>
                            </div>
                            <div class="text-4xl font-bold">
                                {{ $attempt->score }} / {{ $attempt->quiz->questions->sum('points') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Questions Results -->
                    <div class="space-y-6">
                        @foreach($attempt->quiz->questions as $question)
                        @php
                            $attemptAnswer = $attempt->answers->where('question_id', $question->id)->first();
                            $userAnswer = $attemptAnswer ? (json_decode($attemptAnswer->answer, true) ?? $attemptAnswer->answer) : null;
                            $isCorrect = $attemptAnswer && $attemptAnswer->points_earned == $question->points;
                        @endphp
                        
                        <div class="question p-6 border-2 rounded-xl relative overflow-hidden group transition-all duration-200 {{ $isCorrect ? 'correct-answer border-green-200' : 'incorrect-answer border-red-200' }}" data-index="{{ $loop->index }}">
                            <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full {{ $isCorrect ? 'bg-green-500' : 'bg-red-500' }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-[#101966] flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 {{ $isCorrect ? 'text-green-500' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($isCorrect)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        @endif
                                    </svg>
                                    Question #{{ $loop->iteration }}
                                </h3>
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $isCorrect ? 'bg-green-500' : 'bg-red-500' }} text-white shadow-md">
                                    {{ $attemptAnswer ? $attemptAnswer->points_earned : 0 }} / {{ $question->points }} points
                                </span>
                            </div>
                            <p class="mt-3 text-gray-700 leading-relaxed">{{ $question->question }}</p>
                            
                            <!-- User Answer -->
                            <div class="mt-6 p-4 bg-white rounded-lg border border-gray-200">
                                <h4 class="text-sm font-medium text-[#101966] mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Your Answer
                                </h4>
                                @if(is_array($userAnswer))
                                    <ul class="list-disc pl-5 space-y-1 mt-2">
                                        @foreach($userAnswer as $item)
                                            <li class="text-sm text-gray-700">{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mt-1 text-sm text-gray-700">{{ $userAnswer ?? 'No answer provided' }}</p>
                                @endif
                            </div>
                            
                            <!-- Correct Answer (if incorrect) -->
                            @if(!$isCorrect && $question->type !== 'essay')
                            <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                <h4 class="text-sm font-medium text-[#101966] mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Correct Answer
                                </h4>
                                @if($question->type === 'multiple_choice')
                                    <p class="mt-1 text-sm text-gray-700">{{ $question->correctAnswers->first()->answer }}</p>
                                @elseif($question->type === 'identification')
                                    <p class="mt-1 text-sm text-gray-700">{{ $question->answers->first()->answer }}</p>
                                @elseif($question->type === 'enumeration')
                                    <ul class="list-disc pl-5 space-y-1 mt-2">
                                        @foreach($question->answers as $answer)
                                            <li class="text-sm text-gray-700">{{ $answer->answer }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>