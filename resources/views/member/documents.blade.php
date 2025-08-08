<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                My Documents
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents as $document)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg cursor-pointer hover:shadow-md transition-shadow duration-200"
                         onclick="window.location.href='{{ route('member.view-document', $document->id) }}'">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold">{{ $document->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $document->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                @if(!$document->pivot->is_viewed)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                @endif
                            </div>
                            <div class="mt-4 flex items-center">
                                @if($document->url)
                                    <i class="fas fa-external-link-alt text-blue-500 mr-2"></i>
                                    <span class="text-sm">External Link</span>
                                @else
                                    <i class="fas {{ $document->file_icon }} text-blue-500 mr-2"></i>
                                    <span class="text-sm">{{ $document->file_type }} ({{ $document->file_size }})</span>
                                @endif
                            </div>
                            @if($document->description)
                            <div class="mt-3 line-clamp-2 text-sm">
                                {{ Str::limit(strip_tags($document->description), 100) }}
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg col-span-full">
                        <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                            No documents found.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>