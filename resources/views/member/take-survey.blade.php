<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ $survey->title }}
            </h2>

            <a href="{{ route('member.surveys') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Surveys
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($survey->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-medium mb-2">You've already completed this survey</h3>
                            <p class="text-gray-600 dark:text-gray-400">Thank you for your participation!</p>
                        </div>
                    @else
                        <form action="{{ route('member.submit-survey', $survey->id) }}" method="post">
                            @csrf
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-medium">{{ $survey->title }}</h3>
                                @if($survey->description)
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $survey->description }}</p>
                                @endif
                            </div>
                            
                            <div class="space-y-6">
                                @foreach($survey->questions as $question)
                                    <div class="p-4 border rounded-lg">
                                        <label class="block text-sm font-medium mb-2">
                                            {{ $question->question }}
                                            @if(in_array($question->type, ['short-answer', 'long-answer']))
                                                <span class="text-xs text-gray-500">({{ ucfirst(str_replace('-', ' ', $question->type)) }})</span>
                                            @endif
                                        </label>
                                        
                                        @if($question->type === 'short-answer')
                                            <input type="text" name="answers[{{ $question->id }}]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        @elseif($question->type === 'long-answer')
                                            <textarea name="answers[{{ $question->id }}]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" rows="3" required></textarea>
                                        @elseif($question->type === 'multiple-choice')
                                            <div class="mt-2 space-y-2">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center">
                                                        <input type="radio" id="option-{{ $question->id }}-{{ $loop->index }}" 
                                                            name="answers[{{ $question->id }}]" 
                                                            value="{{ $option }}" 
                                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                                                        <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">
                                                            {{ $option }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <div class="mt-2 space-y-2">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center">
                                                        <input type="checkbox" id="option-{{ $question->id }}-{{ $loop->index }}" 
                                                            name="answers[{{ $question->id }}][]" 
                                                            value="{{ $option }}" 
                                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                        <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">
                                                            {{ $option }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors duration-200 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Submit Survey
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>