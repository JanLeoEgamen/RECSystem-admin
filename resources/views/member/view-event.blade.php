<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ $event->title }}
            </h2>

            <a href="{{ route('member.events') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Events
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold">{{ $event->title }}</h1>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p>{{ $event->start_date->format('M d, Y h:i A') }} to {{ $event->end_date->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p>{{ $event->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                @php
                                    $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                                @endphp
                                @if($registration)
                                    @if($registration->status === 'attended')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Attended
                                        </span>
                                    @elseif($registration->status === 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Registered
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Not Registered
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="mt-8">
                        @if($registration)
                            @if($registration->status === 'registered')
                                <form action="{{ route('member.cancel-registration', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                                        Cancel Registration
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('member.register-event', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                                    Register for this Event
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>