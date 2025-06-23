<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            My Announcements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @forelse($announcements as $announcement)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg cursor-pointer hover:shadow-md transition-shadow duration-200"
                         onclick="window.location.href='{{ route('member.view-announcement', $announcement->id) }}'">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold">{{ $announcement->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $announcement->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                @if(!$announcement->pivot->is_read)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                @endif
                            </div>
                            <div class="mt-3 line-clamp-2">
                                {{ Str::limit(strip_tags($announcement->content), 200) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                            No announcements found.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>