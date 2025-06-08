<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Send Quiz: {{ $quiz->title }}
            </h2>
            <a href="{{ route('quizzes.view', $quiz->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quiz
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Send to Members</h3>
                    <form action="{{ route('quizzes.send-quiz', $quiz->id) }}" method="post">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Available Members</label>
                            @if($members->count() > 0)
                                <div class="relative mt-1">
                                    <input 
                                        type="text" 
                                        id="member-search" 
                                        placeholder="Search members..." 
                                        class="w-full border-gray-300 rounded-lg shadow-sm"
                                    >
                                    <div class="mt-2 border border-gray-300 rounded-lg shadow-sm max-h-60 overflow-y-auto bg-white dark:bg-gray-800">
                                        <div class="p-2">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input 
                                                    type="checkbox" 
                                                    id="select-all-members" 
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                >
                                                <span class="ml-2 select-none">Select All Members</span>
                                            </label>
                                        </div>
                                        <div id="member-checkboxes" class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($members as $member)
                                                <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                                    <label class="inline-flex items-center w-full cursor-pointer">
                                                        <input 
                                                            type="checkbox" 
                                                            name="members[]" 
                                                            value="{{ $member->id }}" 
                                                            class="member-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                        >
                                                        <span class="ml-2 select-none">{{ $member->first_name }} {{ $member->last_name }} ({{ $member->email_address }})</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">All members have already received this quiz.</p>
                            @endif
                        </div>
                        
                        @if($members->count() > 0)
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Send Quiz
                        </button>
                        @endif
                    </form>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Sent Quizzes</h3>
                    @if($sentMembers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sent At</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Taken At</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sentMembers as $attempt)
                                    <tr data-quiz-id="{{ $quiz->id }}" data-member-id="{{ $attempt->member_id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $attempt->member->first_name }} {{ $attempt->member->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $attempt->member->email_address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">
                                            {{ $attempt->completed_at ? \Carbon\Carbon::parse($attempt->completed_at)->format('M d, Y H:i') : 'Not taken yet' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">
                                            {{ $attempt->completed_at ? ($attempt->score !== null ? $attempt->score . '/' . $quiz->questions->sum('points') : 'Pending') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center space-x-2">
                                                @if($attempt->completed_at)
                                                    <!-- View Attempt Button -->
                                                    <a href="{{ route('quizzes.view-attempt', ['quiz' => $quiz->id, 'member' => $attempt->member_id]) }}" 
                                                    class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" 
                                                    title="View Attempt">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                                                -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>

                                                    <!-- Resend Results Button -->
                                                    <a href="{{ route('quizzes.resend-results', ['quiz' => $quiz->id, 'member' => $attempt->member_id]) }}" 
                                                    class="p-2 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-full transition-colors duration-200" 
                                                    title="Resend Results">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7
                                                                a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                <!-- Resend Quiz Button -->
                                                <a href="{{ route('quizzes.resend-quiz', ['quiz' => $quiz->id, 'member' => $attempt->member_id]) }}" 
                                                class="p-2 text-green-600 hover:text-white hover:bg-green-600 rounded-full transition-colors duration-200" 
                                                title="Resend Quiz">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7
                                                            a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No quizzes have been sent yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
        <script>
            // Select/Deselect all members when "Select All" is toggled
            $('#select-all-members').on('change', function() {
                let checked = $(this).prop('checked');
                $('.member-checkbox').prop('checked', checked);
            });

            // If any individual member checkbox is toggled, update "Select All" accordingly
            $('#member-checkboxes').on('change', '.member-checkbox', function() {
                let allChecked = $('.member-checkbox').length === $('.member-checkbox:checked').length;
                $('#select-all-members').prop('checked', allChecked);
            });

            $('#member-search').on('keyup', function() {
                let searchTerm = $(this).val().toLowerCase();

                $('#member-checkboxes > div').each(function() {
                    let memberText = $(this).text().toLowerCase();
                    if (memberText.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>