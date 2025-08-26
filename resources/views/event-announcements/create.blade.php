<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Event Announcements / Create
            </h2>

            <a href="{{ route('event-announcements.index') }}"
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0 text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Event Announcements
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="eventForm" action="{{ route('event-announcements.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="event_name" class="text-sm font-medium">Event Name</label>
                            <div class="my-3">    
                                <input id="event_name" value="{{ old('event_name') }}" name="event_name" placeholder="Enter event name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('event_name')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="event_date" class="text-sm font-medium">Event Date</label>
                            <div class="my-3">    
                                <input id="event_date" value="{{ old('event_date') }}" name="event_date" type="date" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('event_date')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="year" class="text-sm font-medium">Year</label>
                            <div class="my-3">    
                                <input id="year" value="{{ old('year') }}" name="year" placeholder="Enter year" type="number" min="2000" max="2100" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('year')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="caption" class="text-sm font-medium">Caption</label>
                            <div class="my-3">    
                                <textarea id="caption" name="caption" placeholder="Enter caption" class="border-gray-300 shadow-sm w-1/2 rounded-lg">{{ old('caption') }}</textarea>
                                @error('caption')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="image" class="text-sm font-medium">Image</label>
                            <div class="my-3">    
                                <input id="image" name="image" type="file" class="border-gray-300 shadow-sm w-1/2 rounded-lg" required>
                                @error('image')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="status" value="0">
                                <input id="status" type="checkbox" name="status" class="rounded" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                <label for="status" class="ml-2">Active</label>
                            </div>

                            <div class="mt-6">
                                <button type="button" id="createEventBtn"
                                    class="inline-flex items-center px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] 
                                            border border-white hover:border-[#101966] rounded-lg font-medium text-lg transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    Create Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('createEventBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Create Event Announcement?',
                text: "Are you sure you want to create this event announcement?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'Cancel',
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Creating...',
                        text: 'Please wait',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            document.getElementById('eventForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });
    </script>
</x-app-layout>