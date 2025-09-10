<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Event Registrations: {{ $event->title }}
            </h2>
        
            <a href="{{ route('events.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto">
        
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
                        <h3 class="text-lg font-medium">Event Summary</h3>
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
                                <p class="text-sm text-gray-500">Registrations</p>
                                <p>{{ $event->registrations->count() }} @if($event->capacity)/ {{ $event->capacity }}@endif</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Registration Status Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-800">Attended</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $event->registrations->where('status', 'attended')->count() }}
                                </p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-800">Registered</p>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ $event->registrations->where('status', 'registered')->count() }}
                                </p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <p class="text-sm text-red-800">Cancelled</p>
                                <p class="text-2xl font-bold text-red-600">
                                    {{ $event->registrations->where('status', 'cancelled')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">Registrations</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($event->registrations as $registration)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $registration->member->first_name }} {{ $registration->member->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $registration->member->email_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $registration->created_at->format('M d, Y h:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form id="status-form-{{ $registration->id }}" 
                                                      action="{{ route('events.registrations.update', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}" 
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" onchange="document.getElementById('status-form-{{ $registration->id }}').submit()" 
                                                            class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                   @if($registration->status === 'attended') bg-green-100 text-green-800
                                                                   @elseif($registration->status === 'registered') bg-blue-100 text-blue-800
                                                                   @elseif($registration->status === 'cancelled') bg-red-100 text-red-800 @endif">
                                                        <option value="registered" {{ $registration->status === 'registered' ? 'selected' : '' }}>Registered</option>
                                                        <option value="attended" {{ $registration->status === 'attended' ? 'selected' : '' }}>Attended</option>
                                                        <option value="cancelled" {{ $registration->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Notes Button -->
                                                    <button onclick="showNotes('{{ $registration->notes }}')" 
                                                            class="text-yellow-600 hover:text-yellow-900" title="View Notes">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    
                                                    <!-- Delete Button -->
                                                    <form id="delete-form-{{ $registration->id }}" 
                                                          action="{{ route('events.registrations.destroy', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}" 
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                onclick="confirmDelete('{{ $registration->id }}')"
                                                                class="text-red-600 hover:text-red-900" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
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

    <x-slot name="script">
        <script>
            function confirmDelete(registrationId) {
                if (confirm('Are you sure you want to delete this registration?')) {
                    document.getElementById('delete-form-' + registrationId).submit();
                }
            }

            function showNotes(notes) {
                if (notes) {
                    alert('Notes:\n\n' + notes);
                } else {
                    alert('No notes available for this registration.');
                }
            }
        </script>
    </x-slot>
</x-app-layout>