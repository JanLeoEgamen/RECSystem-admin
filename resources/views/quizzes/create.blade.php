<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Quizzes / Create
            </h2>
            <a href="{{ route('quizzes.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('quizzes.store') }}" method="post" id="quizForm">
                        @csrf
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="mb-6">
                            <label for="time_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Time Limit (seconds)</label>
                            <input type="number" name="time_limit" id="time_limit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty for no time limit</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Questions</h3>
                            <div id="questions-container">
                                <!-- Questions will be added here -->
                            </div>
                            <button type="button" id="add-question" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Question
                            </button>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            let questionCount = 0;

            document.getElementById('add-question').addEventListener('click', function() {
                addQuestion();
            });

            function addQuestion() {
                const container = document.getElementById('questions-container');
                const questionId = questionCount++;
                
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question-container mb-6 p-4 border border-gray-200 rounded-lg';
                questionDiv.dataset.questionId = questionId;
                
                questionDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-200">Question #${questionId + 1}</h4>
                        <button type="button" class="remove-question text-red-600 hover:text-red-800" onclick="removeQuestion(${questionId})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Question Text</label>
                        <textarea name="questions[${questionId}][question]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Question Type</label>
                        <select name="questions[${questionId}][type]" class="question-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="updateQuestionFields(${questionId})" required>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="identification">Identification</option>
                            <option value="enumeration">Enumeration</option>
                            <option value="essay">Essay</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Points</label>
                        <input type="number" name="questions[${questionId}][points]" min="1" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="answers-container" id="answers-container-${questionId}">
                        <!-- Answer fields will be added here based on question type -->
                    </div>
                `;
                
                container.appendChild(questionDiv);
                updateQuestionFields(questionId);
            }

            function updateQuestionFields(questionId) {
                const container = document.querySelector(`.question-container[data-question-id="${questionId}"]`);
                const typeSelect = container.querySelector('.question-type');
                const answersContainer = container.querySelector('.answers-container');
                const type = typeSelect.value;
                
                answersContainer.innerHTML = '';
                
                switch(type) {
                    case 'multiple_choice':
                        answersContainer.innerHTML = `
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Answers</label>
                                <div class="multiple-choice-answers space-y-2 mt-2">
                                    <div class="multiple-choice-answer flex items-center space-x-2">
                                        <input type="text" name="questions[${questionId}][answers][0][answer]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <input type="radio" name="questions[${questionId}][correct_answer]" value="0" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                                        <button type="button" class="remove-answer text-red-600 hover:text-red-800" onclick="removeAnswer(${questionId}, this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="addMultipleChoiceAnswer(${questionId})">
                                    Add Answer
                                </button>
                            </div>
                        `;
                        break;
                        
                    case 'identification':
                        answersContainer.innerHTML = `
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correct Answer</label>
                                <input type="text" name="questions[${questionId}][correct_answer]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        `;
                        break;
                        
                    case 'enumeration':
                        answersContainer.innerHTML = `
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Items</label>
                                <div class="enumeration-items space-y-2 mt-2">
                                    <div class="enumeration-item flex items-center space-x-2">
                                        <input type="text" name="questions[${questionId}][enumeration_items][0]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <button type="button" class="remove-enumeration-item text-red-600 hover:text-red-800" onclick="removeEnumerationItem(${questionId}, this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="addEnumerationItem(${questionId})">
                                    Add Item
                                </button>
                            </div>
                        `;
                        break;
                        
                    case 'essay':
                        answersContainer.innerHTML = `
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">No specific answers needed for essay questions.</p>
                            </div>
                        `;
                        break;
                }
            }

            function addMultipleChoiceAnswer(questionId) {
                const container = document.querySelector(`.question-container[data-question-id="${questionId}"] .multiple-choice-answers`);
                const answerCount = container.querySelectorAll('.multiple-choice-answer').length;
                
                const answerDiv = document.createElement('div');
                answerDiv.className = 'multiple-choice-answer flex items-center space-x-2';
                answerDiv.innerHTML = `
                    <input type="text" name="questions[${questionId}][answers][${answerCount}][answer]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <input type="radio" name="questions[${questionId}][correct_answer]" value="${answerCount}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                    <button type="button" class="remove-answer text-red-600 hover:text-red-800" onclick="removeAnswer(${questionId}, this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                
                container.appendChild(answerDiv);
            }

            function addEnumerationItem(questionId) {
                const container = document.querySelector(`.question-container[data-question-id="${questionId}"] .enumeration-items`);
                const itemCount = container.querySelectorAll('.enumeration-item').length;
                
                const itemDiv = document.createElement('div');
                itemDiv.className = 'enumeration-item flex items-center space-x-2';
                itemDiv.innerHTML = `
                    <input type="text" name="questions[${questionId}][enumeration_items][${itemCount}]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <button type="button" class="remove-enumeration-item text-red-600 hover:text-red-800" onclick="removeEnumerationItem(${questionId}, this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                
                container.appendChild(itemDiv);
            }

            function removeAnswer(questionId, button) {
                const answersContainer = document.querySelector(`.question-container[data-question-id="${questionId}"] .multiple-choice-answers`);
                if (answersContainer.querySelectorAll('.multiple-choice-answer').length > 1) {
                    button.closest('.multiple-choice-answer').remove();
                } else {
                    alert('At least one answer is required.');
                }
            }

            function removeEnumerationItem(questionId, button) {
                const itemsContainer = document.querySelector(`.question-container[data-question-id="${questionId}"] .enumeration-items`);
                if (itemsContainer.querySelectorAll('.enumeration-item').length > 1) {
                    button.closest('.enumeration-item').remove();
                } else {
                    alert('At least one item is required.');
                }
            }

            function removeQuestion(questionId) {
                const container = document.getElementById('questions-container');
                const questions = container.querySelectorAll('.question-container');
                
                if (questions.length > 1) {
                    container.querySelector(`.question-container[data-question-id="${questionId}"]`).remove();
                    
                    // Re-number remaining questions
                    const remainingQuestions = container.querySelectorAll('.question-container');
                    remainingQuestions.forEach((question, index) => {
                        question.querySelector('h4').textContent = `Question #${index + 1}`;
                    });
                } else {
                    alert('At least one question is required.');
                }
            }

            // Add first question on page load
            document.addEventListener('DOMContentLoaded', function() {
                addQuestion();
            });
        </script>
    </x-slot>
</x-app-layout>