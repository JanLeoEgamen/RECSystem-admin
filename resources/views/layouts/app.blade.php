<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom left-side scrollbar for right sidebar */
        .scrollbar-left {
            scrollbar-width: thin;             
            scrollbar-color: #5E6FFB #101966;  
            direction: rtl;                    
        }
        .scrollbar-left > * {
            direction: ltr;                    
        }
        .scrollbar-left::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .scrollbar-left::-webkit-scrollbar-track {
            background: #101966;
            border-radius: 8px;
        }
        .scrollbar-left::-webkit-scrollbar-thumb {
            background-color: #5E6FFB;
            border-radius: 8px;
        }

        .header-container {
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 2rem;
        }

        .header-content {
            transition: all 0.3s ease;
            margin-left: auto;
            margin-right: auto;
            padding: 1.5rem 1rem;
            max-width: 85%;
            background-color: #1A25A1;
            border-radius: 0.5rem;
        }

        .table-row-hover:hover {
            background-color: #3142CE !important;
            color: white !important;
        }

        .table-row-hover:hover a,
        .table-row-hover:hover button {
            color: white !important;
        }

        .assignments-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .assignments-cell:hover::after {
            content: attr(data-full-text);
            position: absolute;
            left: 0;
            top: 100%;
            z-index: 100;
            background: white;
            color: black;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            white-space: normal;
            width: 300px;
            max-height: 200px;
            overflow: auto;
        }

        .topbar-shadow {
            box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 1);
        }

        .left-sidebar-shadow {
            box-shadow: 5px 0 15px -5px rgba(0, 0, 0, 0.9);
        }
        
        .right-sidebar-shadow {
            box-shadow: -5px 0 15px -5px rgba(0, 0, 0, 0.9);
        }
        
        .footer-shadow {
            box-shadow: 0 -8px 15px -5px rgba(0, 0, 0, 0.8);
        }

        /* ✅ Member Topbar Links Hover */
        .member-nav-link {
            color: white !important;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .member-nav-link:hover {
            background-color: #5e6ffb !important;
            color: white !important;
        }

        /* ✅ Member Mobile Menu Links */
        .member-mobile-link {
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            color: white !important;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .member-mobile-link:hover {
            background-color: #5e6ffb !important;
            color: white !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50"
      x-data="{
        sidebarOpen: window.innerWidth >= 768,  
        rightSidebarOpen: false,               
        headerWidth: 'max-w-7xl px-4 sm:px-6 lg:px-8',
        toggleSidebar(side) {
          if (window.innerWidth < 768) {
            // Mobile: only one sidebar can be open
            if (side === 'left') {
              this.sidebarOpen = !this.sidebarOpen;
              if (this.sidebarOpen) this.rightSidebarOpen = false;
            } else {
              this.rightSidebarOpen = !this.rightSidebarOpen;
              if (this.rightSidebarOpen) this.sidebarOpen = false;
            }
          } else {
            // Desktop: independent toggles
            if (side === 'left') this.sidebarOpen = !this.sidebarOpen;
            if (side === 'right') this.rightSidebarOpen = !this.rightSidebarOpen;
          }
        }
      }"
      x-init="
        const updateSidebars = () => {
          if (window.innerWidth < 768) {
            sidebarOpen = false;
            rightSidebarOpen = false;
          } else {
            sidebarOpen = true;
            rightSidebarOpen = false;
          }
        };
        window.addEventListener('resize', updateSidebars);
      ">


    <div class="min-h-screen flex flex-col">

        <!-- ✅ Topbar Component -->
        <x-topbar />

        <!-- ✅ Left Sidebar -->
        <x-left-sidebar />

        <!-- ✅ Right Sidebar -->
        <x-right-sidebar />

        <!-- Header Spacer -->
        <div class ="h-16 2xl:h-20"></div>

        <div class="flex flex-1">
            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header Section -->
                <div class="header-container pt-16"> 
                    @isset($header)
                        <header class="w-full">
                            <div class="header-content mx-auto transition-all duration-300 ease-in-out" :class="headerWidth">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset
                </div>

                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                    {{ $slot }}
                </main>             
            </div>
        </div>

        <!-- ✅ Footer -->
        <x-footer />
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @isset($script)
        {{ $script }}
    @endisset

</body>
</html>
