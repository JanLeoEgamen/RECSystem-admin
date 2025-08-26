<x-app-layout> 
    <x-slot name="header"> 
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left"> 
                Announcements / Edit 
            </h2>

        <a href="{{ route('announcements.index') }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                w-full md:w-auto text-center">

            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Announcements
        </a>                
    </div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('announcements.update', $announcement->id) }}" method="post" id="updateForm">
                    @csrf
                    <div>
                        <label for="title" class="text-sm font-medium">Title</label>
                        <div class="my-3">    
                            <input id="title" value="{{ old('title', $announcement->title) }}" name="title" placeholder="Enter title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            @error('title')
                            <p class="text-red-400 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>

                        <label for="content" class="text-sm font-medium">Content</label>
                        <div class="my-3">    
                            <textarea id="content" name="content" placeholder="Enter content" class="border-gray-300 shadow-sm w-full rounded-lg" rows="6">{{ old('content', $announcement->content) }}</textarea>
                            @error('content')
                            <p class="text-red-400 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>

                        <div class="my-3">
                            <label class="text-sm font-medium">Recipients</label>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="select-all" class="rounded mr-2">
                                <label for="select-all">Select All Members</label>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="members[]" id="member-{{ $member->id }}" value="{{ $member->id }}" 
                                            class="rounded member-checkbox" {{ in_array($member->id, old('members', $announcement->members->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label for="member-{{ $member->id }}" class="ml-2">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('members')
                            <p class="text-red-400 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>

                        <div class="my-3 flex items-center">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" 
                                {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
                            <label for="is_published" class="ml-2">Published</label>
                        </div>

                        <div class="mt-6">
                            <button type="button" id="updateButton"
                            class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-slot name="script">
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        const checkboxes = document.querySelectorAll('.member-checkbox');
        const selectAll = document.getElementById('select-all');
        
        function checkSelectAll() {
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            selectAll.checked = allChecked;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', checkSelectAll);
        });

        checkSelectAll();

        document.getElementById("updateButton").addEventListener("click", function() {
            Swal.fire({
                title: 'Update Announcement?',
                text: "Are you sure you want to update this announcement?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5e6ffb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                background: '#101966',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            document.getElementById('updateForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Updated!",
                text: "{{ session('success') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
                confirmButtonColor: "#101966",
                background: '#101966',
                color: '#fff'
            });
        @endif
    </script>
</x-slot>
</x-app-layout>