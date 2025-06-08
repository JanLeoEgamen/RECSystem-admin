<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 bg-indigo-700 text-white">
                    <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
                    @if($quiz->description)
                        <p class="mt-2">{{ $quiz->description }}</p>
                    @endif
                </div>
                
                <div class="p-6">
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h2 class="text-lg font-medium text-gray-900">Please enter your information</h2>
                            <form id="memberInfoForm" class="mt-4 space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                            </form>
                        </div>
                    
                    <form id="quizForm" action="{{ route('quiz.submit', $quiz->link) }}" method="POST">
                        @csrf
                        
                            <input type="hidden" name="name" id="formName">
                            <input type="hidden" name="email" id="formEmail">
                        
                        <div class="space-y-8">
                            @foreach($quiz->questions as $question)
                            <div class="question p-4 border border-gray-200 rounded-lg" data-question-type="{{ $question->type }}">
                                <div class="flex justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Question #{{ $loop->iteration }}</h3>
                                    <span class="text-sm font-medium text-gray-500">{{ $question->points }} points</span>
                                </div>
                                <p class="mt-2 text-gray-700">{{ $question->question }}</p>
                                
                                <div class="mt-4 answer-container">
                                    @if($question->type === 'multiple_choice')
                                        <div class="space-y-2">
                                            @foreach($question->answers as $answer)
                                            <div class="flex items-center">
                                                <input id="answer_{{ $answer->id }}" name="question_{{ $question->id }}" type="radio" value="{{ $answer->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="answer_{{ $answer->id }}" class="ml-3 block text-sm font-medium text-gray-700">{{ $answer->answer }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'identification')
                                        <input type="text" name="question_{{ $question->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @elseif($question->type === 'enumeration')
                                        <div class="enumeration-items space-y-2 mt-2">
                                            @foreach($question->answers as $index => $answer)
                                            <input type="text" name="question_{{ $question->id }}[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Item {{ $index + 1 }}">
                                            @endforeach
                                        </div>                                    
                                    @elseif($question->type === 'essay')
                                        <textarea name="question_{{ $question->id }}" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if($quiz->time_limit)
    <div class="fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-md shadow-lg" id="timer">
        Time Remaining: <span id="time">{{ gmdate("i:s", $quiz->time_limit) }}</span>
    </div>
    @endif
    
    <script>
            document.getElementById('quizForm').addEventListener('submit', function(e) {
                document.getElementById('formName').value = document.getElementById('name').value;
                document.getElementById('formEmail').value = document.getElementById('email').value;
            });
        
        @if($quiz->time_limit)
            let timeLeft = {{ $quiz->time_limit }};
            const timer = setInterval(function() {
                timeLeft--;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    document.getElementById('quizForm').submit();
                }
                
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('time').textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        @endif
    </script>
</x-guest-layout>
