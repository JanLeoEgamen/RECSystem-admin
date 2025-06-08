<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Quiz: {{ $quiz->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Quiz
                </a>
                <a href="{{ route('quizzes.send', $quiz->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send Quiz
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Quiz Details</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Description:</strong> {{ $quiz->description ?? 'No description' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Time Limit:</strong> {{ $quiz->time_limit ? $quiz->time_limit . ' seconds' : 'No time limit' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Link:</strong> {{ route('quiz.take', $quiz->link) }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Questions</h3>
                        <div class="mt-4 space-y-6">
                            @foreach($quiz->questions as $question)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-200">Question #{{ $loop->iteration }}</h4>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $question->type)) }} ({{ $question->points }} points)</span>
                                </div>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $question->question }}</p>

                                @if($question->type === 'multiple_choice')
                                    <div class="mt-4 ml-4 space-y-2">
                                        @foreach($question->answers as $answer)
                                            <div class="flex items-center">
                                                <input type="radio" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ $answer->is_correct ? 'checked' : '' }} disabled>
                                                <label class="ml-2 block text-sm text-gray-700 dark:text-gray-300">{{ $answer->answer }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->type === 'identification')
                                    <div class="mt-4 ml-4">
                                        <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Correct Answer:</strong> {{ $question->correctAnswers->first()->answer }}</p>
                                    </div>
                                @elseif($question->type === 'enumeration')
                                    <div class="mt-4 ml-4">
                                        <ul class="list-disc pl-5 text-sm text-gray-700 dark:text-gray-300">
                                            @foreach($question->answers as $answer)
                                                <li>{{ $answer->answer }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif($question->type === 'essay')
                                    <div class="mt-4 ml-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Essay question - no specific answer</p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>