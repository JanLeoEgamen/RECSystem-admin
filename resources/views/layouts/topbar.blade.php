<div style="box-shadow: 0 8px 15px -5px rgba(0, 0, 0, 0.7)" class="bg-[#101966] dark:bg-gray-800 shadow-lg fixed top-0 left-0 right-0">
    <div class="flex items-center justify-between h-20 px-6 py-4">
        <div class="flex items-center space-x-4">
            @can('view admin dashboard')
            <button @click="toggleSidebar('left')" 
                    class="text-gray-300 hover:text-white focus:outline-none transition-all duration-300">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            @endcan
            
            <div class="flex items-center space-x-2">
                <x-application-logo class="block h-10 w-auto fill-current text-white md:h-12"/>
                <div class="flex items-baseline space-x-2">
                    <span class="text-lg font-semibold text-white whitespace-nowrap">
                        <span class="md:hidden">REC Inc. MIMS</span>
                        <span class="hidden md:inline">Radio Engineering Circle Inc.</span>
                    </span>
                    <span class="hidden md:inline text-xs font-bold px-2 py-1 rounded bg-[#5e6ffb] text-white">DZ1REC</span>
                </div>
            </div>
        </div>

        @can('view admin dashboard')
        <div class="hidden md:flex items-center justify-center flex-1 px-4">
            <div class="topbar-center-content flex items-center">
                <span class="text-white font-bold text-xl uppercase tracking-wider whitespace-nowrap">
                    MEMBERSHIP INFORMATION MANAGEMENT SYSTEM
                </span>
                <span class="ml-1 text-xs font-bold px-3 py-1 tracking-wider rounded-full bg-[#5e6ffb] text-white">
                    MIMS
                </span>
            </div>
        @endcan
        </div>

        @can('view admin dashboard')
        <div class="flex items-center">
            <img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/user-shield.png" alt="admin" class="mr-1">
            
            <div class="text-sm font-medium text-white hidden md:block ml-1">
                ADMINISTRATOR
            </div>
            
            <button @click="toggleSidebar('right')" 
                    class="ml-4 group text-gray-300 focus:outline-none transition-all duration-300 p-1 rounded-md">
                <img x-show="!rightSidebarOpen" 
                    src="https://img.icons8.com/material-rounded/24/FFFFFF/left-navigation-toolbar.png" 
                    alt="menu" 
                    class="h-6 w-6 group-hover:hidden">
                <img x-show="!rightSidebarOpen" 
                    src="https://img.icons8.com/material-rounded/24/101966/left-navigation-toolbar.png" 
                    alt="menu hover" 
                    class="h-6 w-6 hidden group-hover:block">
                
                <img x-show="rightSidebarOpen" 
                    src="https://img.icons8.com/material-rounded/24/5e6ffb/left-navigation-toolbar.png" 
                    alt="close menu" 
                    class="h-6 w-6">
            </button>
        </div>
        @endcan
    </div>
</div>