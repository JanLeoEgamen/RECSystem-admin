<div 
    class="fixed shadow-lg shadow-black/70 top-16 right-0 w-64 bg-[#101966] h-[calc(100vh-4rem)] 
           transform transition-transform duration-200 ease-in-out
           shadow-[ -4px_0_12px_-2px_rgba(0,0,0,0.3)] overflow-y-auto"
    :class="rightSidebarOpen ? 'translate-x-0' : 'translate-x-full'"
>
    {{ $slot }}
</div>
