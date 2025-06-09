<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $survey->title }}</h1>
                    @if($survey->description)
                    <p class="mt-1 text-sm text-gray-500">{{ $survey->description }}</p>
                    @endif
                </div>
                
                @if($completed)
                    <div class="px-4 py-5 sm:p-6">
                        <div class="bg-green-50 border-l-4 border-green-400 p-4">
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
                    </div>
                @else
                    <form action="{{ route('survey.submit', ['slug' => $survey->slug, 'token' => $invitation->token ?? null]) }}" method="POST" class="px-4 py-5 sm:p-6">
                        @csrf
                        
                        <div class="space-y-6">
                            @foreach($survey->questions as $index => $question)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="mb-3">
                                    <label for="question-{{ $question->id }}" class="block text-sm font-medium text-gray-700">
                                        {{ $question->question }}
                                        @if($question->is_required)
                                        <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</p>
                                </div>
                                
                                @if($question->type === 'short-answer')
                                    <input type="text" name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($question->is_required) required @endif>
                                
                                @elseif($question->type === 'long-answer')
                                    <textarea name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" rows="3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($question->is_required) required @endif></textarea>
                                
                                @elseif($question->type === 'multiple-choice')
                                    <div class="mt-2 space-y-2">
                                        @foreach($question->options as $option)
                                        <div class="flex items-center">
                                            <input id="option-{{ $question->id }}-{{ $loop->index }}" name="answers[{{ $question->id }}]" type="radio" 
                                                value="{{ $option }}" 
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                @if($question->is_required) required @endif>
                                            <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                
                                @elseif($question->type === 'checkbox')
                                    <div class="mt-2 space-y-2">
                                        @foreach($question->options as $option)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="option-{{ $question->id }}-{{ $loop->index }}" name="answers[{{ $question->id }}][]" type="checkbox" 
                                                    value="{{ $option }}" 
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <label for="option-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                
                                @elseif($question->type === 'dropdown')
                                    <select name="answers[{{ $question->id }}]" id="question-{{ $question->id }}" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($question->is_required) required @endif>
                                        <option value="">Select an option</option>
                                        @foreach($question->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                
                                @error("answers.{$question->id}")
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Survey
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>