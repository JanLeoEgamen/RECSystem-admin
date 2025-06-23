<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Quiz Responses: {{ $quiz->title }}
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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Responses</p>
                                <p class="text-2xl font-bold">{{ $quiz->responses->count() }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Average Score</p>
                                <p class="text-2xl font-bold">
                                    {{ number_format($quiz->responses->avg('total_score') ?? 0, 2) }} / 
                                    {{ number_format($quiz->questions->sum('points'), 2) }}
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pass Rate</p>
                                <p class="text-2xl font-bold">
                                    @php
                                        $totalPossible = $quiz->questions->sum('points');
                                        $passingScore = $totalPossible * 0.7; // Assuming 70% is passing
                                        $passCount = $quiz->responses->where('total_score', '>=', $passingScore)->count();
                                        $passRate = $quiz->responses->count() > 0 ? ($passCount / $quiz->responses->count()) * 100 : 0;
                                    @endphp
                                    {{ number_format($passRate, 1) }}%
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('quizzes.responses.summary', $quiz) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                View Detailed Question Statistics
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">Individual Responses</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($quiz->responses as $response)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $response->member->first_name }} {{ $response->member->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $response->member->email_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $response->created_at->format('M d, Y h:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{ $response->total_score }} / {{ $quiz->questions->sum('points') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('quizzes.responses.individual', ['quiz' => $quiz, 'response' => $response]) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
