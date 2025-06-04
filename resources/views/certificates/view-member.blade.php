<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Certificate for {{ $member->first_name }} {{ $member->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">{{ $certificate->title }}</h1>
                    
                    <div class="certificate-content mb-6">
                        {!! $certificate->content !!}
                    </div>
                    
                    <div class="signatures mt-8">
                        @foreach($certificate->signatories as $signatory)
                            <div class="signature mb-4">
                                <div class="signature-line border-t-2 border-gray-400 w-32"></div>
                                <p class="font-bold">{{ $signatory->name }}</p>
                                <p>{{ $signatory->position }}</p>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="issued-date mt-8">
                        <p>Issued on: {{ \Carbon\Carbon::parse($issuedAt)->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>