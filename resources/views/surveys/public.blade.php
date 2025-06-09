<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="mb-8 text-center">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $survey->title }}</h1>
                        @if($survey->description)
                            <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $survey->description }}</p>
                        @endif
                    </div>

                    <form action="{{ isset($invitation) ? route('survey.submit', ['slug' => $survey->slug, 'token' => $invitation->token]) : route('survey.submit', $survey->slug) }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            @foreach($survey->questions as $question)
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $question->question }}
                                        @if($question->is_required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    
                                    @if($question->type === 'short-answer')
                                        <input type="text" name="question_{{ $question->id }}" 
                                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm" 
                                            @if($question->is_required) required @endif>
                                    
                                    @elseif($question->type === 'long-answer')
                                        <textarea name="question_{{ $question->id }}" rows="3" 
                                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm" 
                                            @if($question->is_required) required @endif></textarea>
                                    
                                    @elseif($question->type === 'multiple-choice')
                                        <div class="space-y-2">
                                            @foreach($question->options as $option)
                                                <div class="flex items-center">
                                                    <input type="radio" id="question_{{ $question->id }}_{{ $loop->index }}" 
                                                        name="question_{{ $question->id }}" value="{{ $option }}" 
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700" 
                                                        @if($question->is_required) required @endif>
                                                    <label for="question_{{ $question->id }}_{{ $loop->index }}" class="ml-2 block text-gray-700 dark:text-gray-300">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                    @elseif($question->type === 'checkbox')
                                        <div class="space-y-2">
                                            @foreach($question->options as $option)
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="question_{{ $question->id }}_{{ $loop->index }}" 
                                                        name="question_{{ $question->id }}[]" value="{{ $option }}" 
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                                    <label for="question_{{ $question->id }}_{{ $loop->index }}" class="ml-2 block text-gray-700 dark:text-gray-300">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                    @elseif($question->type === 'dropdown')
                                        <select name="question_{{ $question->id }}" 
                                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm" 
                                            @if($question->is_required) required @endif>
                                            <option value="">Select an option</option>
                                            @foreach($question->options as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-center">
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm">
                                Submit Survey
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>