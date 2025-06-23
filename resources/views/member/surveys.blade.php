<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            Available Surveys
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($surveys->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        No surveys available at this time.
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($surveys as $survey)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg cursor-pointer hover:shadow-md transition-shadow duration-200"
                             onclick="window.location.href='{{ route('member.take-survey', $survey->id) }}'">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-semibold">{{ $survey->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $survey->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    @if($survey->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Completed</span>
                                    @else
                                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                    @endif
                                </div>
                                <div class="mt-3 line-clamp-2">
                                    {{ Str::limit($survey->description, 150) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>