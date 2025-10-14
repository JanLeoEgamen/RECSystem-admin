<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('My Certificates') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($certificates->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Certificates Yet</h3>
                        <p class="text-gray-500 dark:text-gray-400">You haven't been issued any certificates yet.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certificates as $certificate)
                        @php
                            $issuedAt = $certificate->pivot->issued_at;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                            <div class="p-6 flex flex-col h-full">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $certificate->title }}
                                </h3>
                                
                                <!-- Certificate Image Preview -->
                                @php
                                    $imagePath = $certificate->pivot->image_path ?? null;
                                @endphp

                                @if($imagePath && Storage::disk('public')->exists($imagePath))
                                    <div class="mb-4 border border-gray-200 dark:border-gray-600 rounded overflow-hidden bg-gray-50 dark:bg-gray-700">
                                        <img src="{{ Storage::disk('public')->url($imagePath) }}" 
                                            alt="{{ $certificate->title }}" 
                                            class="w-full h-32 object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                            onclick="window.open('{{ route('member.certificates.show', $certificate) }}', '_blank')">
                                    </div>
                                @else
                                    <div class="mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Preview not available</p>
                                    </div>
                                @endif
                                                                
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2 flex-grow">
                                    {{ strip_tags(Str::limit($certificate->content, 120)) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                        <strong>Issued:</strong> {{ \Carbon\Carbon::parse($issuedAt)->format('M d, Y') }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('member.certificates.show', $certificate) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('certificates.download', ['certificate' => $certificate->id, 'member' => Auth::user()->member->id]) }}" 
                                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 p-1 rounded"
                                               title="Download PDF">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('certificates.download-image', ['certificate' => $certificate->id, 'member' => Auth::user()->member->id]) }}" 
                                               class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 p-1 rounded"
                                               title="Download Image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                        </div>
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