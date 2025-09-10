@props(['route', 'permission' => null])

@if(!$permission || auth()->user()->can($permission))
<a href="{{ $route }}" 
    class="inline-flex items-center justify-center px-5 py-2 
            text-white bg-[#101966] border border-white font-medium 
            hover:text-[#101966] hover:bg-white hover:border-[#101966] 
            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] 
            rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
            w-full md:w-auto mt-4 md:mt-0

            dark:bg-gray-900 dark:text-white dark:border-gray-100 
            dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">
    
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" 
            viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 4v16m8-8H4" />
    </svg>
    Create
</a>
@endif