<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between"> 
    <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Users / Create
            </h2>
                    <a href="{{ route('users.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Users
                    </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('users.store')    }} " method="post">
                        @csrf
                        <div>
                            <!-- First Name -->
                            <label for="first_name" class="text-sm font-medium">First Name</label>
                            <div class="my-3">    
                                <input value="{{ old('first_name') }}" name="first_name" placeholder="Enter first name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('first_name')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <label for="last_name" class="text-sm font-medium">Last Name</label>
                            <div class="my-3">    
                                <input value="{{ old('last_name') }}" name="last_name" placeholder="Enter last name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('last_name')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <!-- Birthdate -->
                            <label for="birthdate" class="text-sm font-medium">Birthdate</label>
                            <div class="my-3">    
                                <input value="{{ old('birthdate') }}" name="birthdate" type="date" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('birthdate')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="" class="text-sm font-medium"> Email</label>
                            <div class = "my-3">    
                                <input value="{{ old('email') }}" name="email" placeholder="Enter Email" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg  ">
                                @error('email')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="" class="text-sm font-medium"> Password</label>
                            <div class = "my-3">    
                                <input value="{{ old('password') }}" name="password" placeholder="Enter Password" type="password" class="border-gray-300 shadow-sm w-1/2 rounded-lg  ">
                                @error('password')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="" class="text-sm font-medium"> Confirm Password</label>
                            <div class = "my-3">    
                                <input value="{{ old('confirm_password') }}" name="confirm_password" placeholder="Confirm Your Password" type="password" class="border-gray-300 shadow-sm w-1/2 rounded-lg  ">
                                @error('password')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                        <div class="mt-6">
                        <label class="text-sm font-medium">Assign Roles</label>
                            <div class="grid grid-cols-4 mb-3" >
                                    @if ($roles->isNotEmpty())
                                        @foreach($roles as $role)
                                            <div class="mt-3">
                                            <input type="checkbox" id="role-{{ $role->id}}" class="rounded" name="role[]"
                                            value="{{ $role->name }}">
                                            <label for="role-{{ $role->id}}">{{ $role->name }}</label>

                                            </div>
                                        @endforeach
                                    @endif
                            </div>
                        </div>

                            <div class="mt-6">
                                <label class="text-sm font-medium">Assign to Bureaus</label>
                                <div class="grid grid-cols-4 gap-4 mt-2">
                                    @foreach($bureaus as $bureau)
                                        <div>
                                            <input type="checkbox" id="bureau-{{ $bureau->id }}" name="bureaus[]" value="{{ $bureau->id }}" class="rounded">
                                            <label for="bureau-{{ $bureau->id }}">{{ $bureau->bureau_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="text-sm font-medium">Or Assign to Specific Sections</label>
                                <div class="grid grid-cols-4 gap-4 mt-2">
                                    @foreach($sections as $section)
                                        <div>
                                            <input type="checkbox" id="section-{{ $section->id }}" name="sections[]" value="{{ $section->id }}" class="rounded">
                                            <label for="section-{{ $section->id }}">
                                                {{ $section->section_name }} ({{ $section->bureau->bureau_name }})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white border font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
