<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->title }} - Survey</title>
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

        /* Survey question styling */
        .survey-question {
            transition: all 0.3s ease;
        }

        .survey-question:hover {
            border-color: #5e6ffb;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
                        <img src="/images/Logo.png" alt="Organization Logo" class="w-16 h-16">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-[#101966]">Radio Engineering Circle Inc</h1>
                        <p class="text-blue-500">Survey Collection Portal</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Survey Header -->
                <div class="p-8 bg-gradient-to-r from-[#101966] to-[#5e6ffb] text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white opacity-10"></div>
                    <div class="absolute -left-5 -bottom-5 w-20 h-20 rounded-full bg-white opacity-5"></div>
                    <div class="flex items-center">
                        <div>
                            <span class="mr-3 px-3 py-1 rounded-full text-sm font-bold bg-white text-[#101966] shadow-md">{{ count($survey->questions) }} Questions</span>
                            <h1 class="text-3xl font-bold relative z-10 mt-4">{{ $survey->title }}</h1>
                        </div>
                    </div>
                    @if($survey->description)
                        <p class="mt-4 text-blue-100 relative z-10">{{ $survey->description }}</p>
                    @endif
                </div>
                
                <!-- Content Area -->
                <div class="p-8">
                    @if($completed)
                        <div class="px-6 py-5 bg-green-50 rounded-xl border-l-4 border-green-400 mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        You have already completed this survey. Thank you for your participation!
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('survey.submit', ['slug' => $survey->slug, 'token' => $invitation->token ?? null]) }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="space-y-6">
                                @foreach($survey->questions as $index => $question)
                                <div class="survey-question p-6 border-2 border-blue-100 rounded-xl bg-white hover:border-[#5e6ffb] transition-all duration-200 relative overflow-hidden group" data-index="{{ $index }}">
                                    <div class="absolute -right-5 -top-5 w-16 h-16 rounded-full bg-[#5e6ffb] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-[#101966] flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Question #{{ $loop->iteration }}
                                            @if($question->is_required)
                                            <span class="ml-2 text-red-500">*</span>
                                            @endif
                                        </h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#5e6ffb] text-white shadow-md">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</span>
                                    </div>
                                    <p class="mt-3 text-gray-700 leading-relaxed">{{ $question->question }}</p>
                                    
                                    <div class="mt-6 answer-container">
                                        @if($question->type === 'short-answer')
                                            <div class="relative">
                                                <input type="text" name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" 
                                                    class="mt-1 block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 pl-10"
                                                    @if($question->is_required) required @endif>
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        
                                        @elseif($question->type === 'long-answer')
                                            <textarea name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" rows="3"
                                                class="mt-1 block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3"
                                                @if($question->is_required) required @endif></textarea>
                                        
                                        @elseif($question->type === 'multiple-choice')
                                            <div class="mt-4 space-y-3">
                                                @foreach($question->options as $option)
                                                <div class="flex items-center">
                                                    <div class="flex items-center h-5">
                                                        <input id="option-{{ $question->id }}-{{ $loop->index }}" name="answers[{{ $question->id }}]" type="radio" 
                                                            value="{{ $option }}" 
                                                            class="h-5 w-5 text-[#5e6ffb] focus:ring-[#5e6ffb] border-blue-300 rounded-full transition-all"
                                                            @if($question->is_required) required @endif>
                                                    </div>
                                                    <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium text-gray-700 hover:text-[#101966] cursor-pointer transition-colors duration-200">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($question->type === 'checkbox')
                                            <div class="mt-4 space-y-3">
                                                @foreach($question->options as $option)
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="option-{{ $question->id }}-{{ $loop->index }}" name="answers[{{ $question->id }}][]" type="checkbox" 
                                                            value="{{ $option }}" 
                                                            class="h-5 w-5 text-[#5e6ffb] focus:ring-[#5e6ffb] border-blue-300 rounded transition-all">
                                                    </div>
                                                    <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium text-gray-700 hover:text-[#101966] cursor-pointer transition-colors duration-200">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($question->type === 'dropdown')
                                            <div class="relative mt-3">
                                                <select name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" 
                                                    class="mt-1 block w-full rounded-lg border-2 border-blue-200 shadow-sm focus:border-[#5e6ffb] focus:ring-[#5e6ffb] p-3 pl-10 appearance-none"
                                                    @if($question->is_required) required @endif>
                                                    <option value="">Select an option</option>
                                                    @foreach($question->options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5e6ffb]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @error("answers.{$question->id}")
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-10 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-lg font-semibold rounded-xl shadow-md text-white bg-gradient-to-r from-[#101966] to-[#5e6ffb] hover:from-[#5e6ffb] hover:to-[#101966] transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e6ffb] group">
                                    <span>Submit Survey</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>