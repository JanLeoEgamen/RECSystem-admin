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

        /* Dark Mode Support for scrollbars*/
        @media (prefers-color-scheme: dark) {
            .scrollbar-left {
                scrollbar-color: #374151 #1F2937; 
            }
            .scrollbar-left::-webkit-scrollbar-track {
                background: #1F2937;
            }
            .scrollbar-left::-webkit-scrollbar-thumb {
                background-color: #374151; 
            }
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
            border-radius: 0.5rem;
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

        .bg-\[\#1A25A1\] {
            background-color: #1A25A1 !important;
        }

        @media (prefers-color-scheme: dark) {
            .bg-\[\#1A25A1\] {
                background-color: #1f2937 !important;
            }
        }

        .main-content-transition {
            transition-property: margin;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .header-content-transition {
            transition-property: max-width;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @media (max-width: 767px) {
            .main-content-mobile {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-300 dark:bg-gray-900"
      x-data="{
        sidebarOpen: window.innerWidth >= 768 && !@json(auth()->check() && (auth()->user()->hasRole('Member') || auth()->user()->hasRole('Applicant'))),  
        rightSidebarOpen: false,
        headerWidth: 'max-w-7xl px-4 sm:px-6 lg:px-8',
        toggleSidebar(side) {
          if (window.innerWidth < 768) {
            if (side === 'left') {
              this.sidebarOpen = !this.sidebarOpen;
              if (this.sidebarOpen) this.rightSidebarOpen = false;
            } else {
              this.rightSidebarOpen = !this.rightSidebarOpen;
              if (this.rightSidebarOpen) this.sidebarOpen = false;
            }
          } else {
            if (side === 'left') this.sidebarOpen = !this.sidebarOpen;
            if (side === 'right') this.rightSidebarOpen = !this.rightSidebarOpen;
          }
        },
        getMainContentMargin() {
          if (window.innerWidth >= 768) {
            let marginLeft = this.sidebarOpen ? 'ml-64' : 'ml-0';
            let marginRight = this.rightSidebarOpen ? 'mr-72' : 'mr-0';
            return `${marginLeft} ${marginRight}`;
          }
          return '';
        },
        getHeaderContentWidth() {
          if (window.innerWidth < 768) {
            return 'max-w-full px-4';
          }
          if (this.sidebarOpen && this.rightSidebarOpen) {
            return 'max-w-4xl px-4 sm:px-6 lg:px-8';
          }
          if (this.sidebarOpen || this.rightSidebarOpen) {
            return 'max-w-5xl px-4 sm:px-6 lg:px-8';
          }
          return 'max-w-7xl px-4 sm:px-6 lg:px-8';
        },
        isDesktop() {
          return window.innerWidth >= 768;
        }
      }"
      x-init="
        const updateSidebars = () => {
          if (window.innerWidth < 768) {
            sidebarOpen = false;
            rightSidebarOpen = false;
          } else {
            sidebarOpen = !@json(auth()->check() && (auth()->user()->hasRole('Member') || auth()->user()->hasRole('Applicant')));
          }
        };
        window.addEventListener('resize', updateSidebars);
        updateSidebars();
      ">


    <div class="min-h-screen flex flex-col">

        <!-- ✅ Topbar Component -->
        <x-topbar />

        <!-- ✅ Left Sidebar -->
        @canany(['view admin dashboard', 'view applicant dashboard'])
            <x-left-sidebar />
        @endcanany

        <!-- ✅ Right Sidebar -->
        <x-right-sidebar />

        <!-- Header Spacer -->
        <div class="block 2xl:hidden h-16 xl:h-20"></div>

        <div class="flex flex-1">
        
            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden main-content-transition" 
                 :class="{'main-content-mobile': !isDesktop(), [getMainContentMargin()]: isDesktop()}">

                <!-- Header Section -->
                    <div class="header-container pt-16"> 

                        <!-- Breadcrumbs -->
                         @can('view admin dashboard')
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <x-breadcrumbs />
                        </div>
                        @endcan
                        @isset($header)
                            <header class="w-full">
                                <!-- Gradient Header Box -->
                                <div 
                                    class="header-content mx-auto header-content-transition p-4 sm:p-6 rounded-lg shadow-lg
                                    bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB] 
                                    dark:bg-none dark:bg-gray-700"
                                    :class="getHeaderContentWidth()" >
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset
                    </div>

                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-300 dark:bg-gray-900"> 
                    {{ $slot }}
                </main>             
            </div>
        </div>

        <!-- ✅ Footer -->
        <x-footer />
    </div>

    <!-- CHATBOT INTEGRATION EMBEDDED CODE -->
    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/01/12/14/20250112142449-BTWBU6OV.js"></script>
    <!-- END OF CHATBOT CALLING -->
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @isset($script)
        {{ $script }}
    @endisset

    <!-- TRIGGER ANIMATION FOR THE LEFT SIDE BAR -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('from_menu')) {
            setTimeout(() => {
                const url = new URL(window.location);
                url.searchParams.delete('from_menu');
                window.history.replaceState({}, '', url);
            }, 1000); 
        }
    });
    </script>
</body>
</html>