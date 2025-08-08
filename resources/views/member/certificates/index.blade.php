<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('My Certificates') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($certificates->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>You don't have any certificates yet.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certificates as $certificate)
                        @php
                            $issuedAt = $certificate->pivot->issued_at;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6 flex flex-col h-full">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $certificate->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ strip_tags(Str::limit($certificate->content, 150)) }}
                                </p>
                                <div class="mt-auto">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        Issued: {{ \Carbon\Carbon::parse($issuedAt)->format('M d, Y') }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('member.certificates.show', $certificate) }}" 
                                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-600">
                                            View Certificate
                                        </a>
                                        <a href="{{ route('certificates.download', ['certificate' => $certificate->id, 'member' => Auth::user()->member->id]) }}" 
                                           class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                           title="Download">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>