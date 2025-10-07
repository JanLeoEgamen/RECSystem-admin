<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ $certificate->title }}
            </h2>

            <a href="{{ route('member.certificates.index') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to My Certificates
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $certificate->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Issued on: {{ \Carbon\Carbon::parse($issuedAt)->format('F j, Y') }}
                        </p>
                    </div>
                    <div class="flex space-x-4">     
                        <a href="{{ route('certificates.download-image', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Download Image
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Certificate Image Display -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        // Get image path from the pivot relationship passed from controller
                        $imagePath = $imagePath ?? $certificate->pivot->image_path ?? null;
                    @endphp
                    
                    @if($imagePath && Storage::disk('public')->exists($imagePath))
                        <div class="text-center">
                            <img src="{{ Storage::disk('public')->url($imagePath) }}" 
                                alt="{{ $certificate->title }}"
                                class="mx-auto max-w-full h-auto border border-gray-200 rounded-lg shadow-lg"
                                style="max-height: 80vh;">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                                This is your official certificate. You can download it as PDF or high-quality image.
                            </p>
                        </div>
                    @else
                        <!-- Fallback: Show HTML version if image doesn't exist -->
                        <div class="alert alert-warning mb-4">
                            <p class="text-yellow-600 dark:text-yellow-400">
                                @if($imagePath)
                                    Certificate image is being generated. Showing preview version...
                                @else
                                    Certificate image is not available yet. Showing preview version...
                                @endif
                            </p>
                        </div>
                        <div class="certificate-container">
                            @include('certificates.jcertificate', [
                                'certificate' => $certificate,
                                'member' => $member,
                                'issueDate' => $issuedAt,
                                'embedded' => true
                            ])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .certificate-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
        }
    </style>
</x-app-layout>