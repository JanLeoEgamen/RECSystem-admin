<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Member Files / Edit
            </h2>
            <a href="{{ route('memberfiles.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Files
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="editMemberFileForm" action="{{ route('memberfiles.update', $file->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title" class="text-sm font-medium">Title *</label>
                            <div class="my-3">    
                                <input value="{{ old('title', $file->title) }}" name="title" id="title" placeholder="Enter title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea name="description" id="description" placeholder="Enter description" class="border-gray-300 shadow-sm w-full rounded-lg" rows="3">{{ old('description', $file->description) }}</textarea>
                                @error('description')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="member_id" class="text-sm font-medium">Assign to Member *</label>
                            <div class="my-3">    
                                <select name="member_id" id="member_id" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                    <option value="">Select Member</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ (old('member_id', $file->member_id) == $member->id) ? 'selected' : '' }}>
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="due_date" class="text-sm font-medium">Due Date</label>
                                    <div class="my-3">    
                                        <input value="{{ old('due_date', $file->due_date ? $file->due_date->format('Y-m-d') : '') }}" name="due_date" id="due_date" type="date" class="border-gray-300 shadow-sm w-full rounded-lg">
                                        @error('due_date')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="is_required" class="text-sm font-medium">Required</label>
                                    <div class="my-3 flex items-center">    
                                        <input type="hidden" name="is_required" value="0">
                                        <input type="checkbox" name="is_required" id="is_required" class="rounded" value="1" {{ old('is_required', $file->is_required) ? 'checked' : '' }}>
                                        <label for="is_required" class="ml-2">Mark as required</label>
                                        @error('is_required')
                                        <p class="text-red-400 font-medium"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                        
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update File Assignment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('editMemberFileForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this file assignment?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "Cancel",
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
                                    e.target.submit();
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
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ session('error') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>