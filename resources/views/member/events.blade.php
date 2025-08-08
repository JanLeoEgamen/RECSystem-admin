<x-app-layout>
    <x-slot name="header">
        <div class="p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                My Events
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($events->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        No events available at this time.
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-semibold">{{ $event->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $event->start_date->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                    @php
                                        $registration = $event->registrations->where('member_id', auth()->user()->member->id)->first();
                                    @endphp
                                    @if($registration)
                                        @if($registration->status === 'attended')
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Attended</span>
                                        @elseif($registration->status === 'cancelled')
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Cancelled</span>
                                        @else
                                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Registered</span>
                                        @endif
                                    @else
                                        <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Not Registered</span>
                                    @endif
                                </div>
                                <div class="mt-3 line-clamp-2">
                                    {{ Str::limit($event->description, 150) }}
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-sm text-gray-500">
                                        {{ $event->location }}
                                    </span>
                                    <div class="flex space-x-2">
                                        @if($registration)
                                            @if($registration->status === 'registered')
                                                <form action="{{ route('member.cancel-registration', $event->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ route('member.register-event', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded">
                                                    Register
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('member.view-event', $event->id) }}" class="text-xs bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>