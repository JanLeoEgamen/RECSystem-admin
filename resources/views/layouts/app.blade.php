<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            height: 4rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .topbar-center-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }

        .sidebar {
            width: 16rem;
            transition: all 0.3s ease;
            box-shadow: 8px 0 15px -5px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 4rem;
            bottom: 0;
            z-index: 30;
        }

        .sidebar-collapsed {
            width: 5rem;
            overflow: hidden;
        }

        .right-sidebar {
            width: 16rem;
            transition: all 0.3s ease;
            box-shadow: -8px 0 15px -5px rgba(0, 0, 0, 0.2);
            position: fixed;
            right: 0;
            top: 4rem;
            bottom: 0;
            z-index: 30;
        }

        .right-sidebar-collapsed {
            width: 5rem;
        }

        .header-container {
            z-index: 25;
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
            background-color: #5e6ffb;
            border-radius: 0.5rem;
        }

        .main-content {
            margin-left: 16rem;
            margin-right: 0;
            transition: all 0.3s ease;
            padding-top: 6rem;
            width: calc(100% - 16rem);
        }

        .main-content-collapsed {
            margin-left: 5rem;
            width: calc(100% - 5rem);
        }

        .main-content-right-expanded {
            margin-right: 16rem;
            width: calc(100% - 16rem);
        }

        .main-content-right-collapsed {
            margin-right: 5rem;
            width: calc(100% - 5rem);
        }

        .main-content-both-expanded {
            margin-left: 16rem;
            margin-right: 16rem;
            width: calc(100% - 32rem);
        }

        .main-content-left-collapsed-right-expanded {
            margin-left: 5rem;
            margin-right: 16rem;
            width: calc(100% - 21rem);
        }

        .main-content-left-expanded-right-collapsed {
            margin-left: 16rem;
            margin-right: 5rem;
            width: calc(100% - 21rem);
        }

        .main-content-both-collapsed {
            margin-left: 5rem;
            margin-right: 5rem;
            width: calc(100% - 10rem);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background-color: #5e6ffb;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar-open {
                transform: translateX(0);
            }
            
            .main-content-collapsed {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 35;
                display: none;
            }
            
            .sidebar-overlay-active {
                display: block;
            }

            .main-content {
                min-height: calc(100vh - 80px - 150px);
            }
            
            footer {
                padding: 1.5rem 1rem;
            }
            
            footer .flex-col {
                align-items: flex-start;
            }
            
            footer .flex-wrap {
                justify-content: flex-start;
                gap: 1rem;
            }

            footer {
                position: relative;
            }

            .main-content {
                min-height: calc(100vh - 80px - 120px); 
            }
        }

        @media (max-width: 768px) {
            .sidebar-collapsed {
                width: 0;
                transform: translateX(-100%);
            }
            
            .main-content,
            .main-content-collapsed,
            .main-content-right-expanded,
            .main-content-right-collapsed,
            .main-content-both-expanded,
            .main-content-left-collapsed-right-expanded,
            .main-content-left-expanded-right-collapsed,
            .main-content-both-collapsed {
                margin-left: 0;
                margin-right: 0;
                width: 100%;
                padding-top: 6rem;
            }
            
            .header-content {
                max-width: 95%;
                padding: 1rem;
            }
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
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased bg-white">

    <div x-data="{ 
        sidebarOpen: window.innerWidth > 768,
        rightSidebarOpen: false,
        currentRouteName: '{{ request()->route()->getName() }}',
        get mainContentClass() {
            if (window.innerWidth <= 768) {
                return this.sidebarOpen ? 'main-content-collapsed' : '';
            }
            if (!this.sidebarOpen && !this.rightSidebarOpen) return 'main-content-both-collapsed';
            if (!this.sidebarOpen && this.rightSidebarOpen) return 'main-content-left-collapsed-right-expanded';
            if (this.sidebarOpen && !this.rightSidebarOpen) return 'main-content-left-expanded-right-collapsed';
            return 'main-content-both-expanded';
        },
        get headerWidth() {
            if (window.innerWidth <= 768) return 'w-full px-4';
            return 'max-w-[85%] px-6';
        },
        toggleSidebar(sidebar) {
            if (sidebar === 'left') {
                this.sidebarOpen = !this.sidebarOpen;
                if (this.sidebarOpen && window.innerWidth <= 768) {
                    this.rightSidebarOpen = false;
                }
            } else {
                this.rightSidebarOpen = !this.rightSidebarOpen;
                if (this.rightSidebarOpen && window.innerWidth <= 768) {
                    this.sidebarOpen = false;
                }
            }
        },
        checkScreenSize() {
            if (window.innerWidth > 768) {
                this.sidebarOpen = true;
            } else {
                this.sidebarOpen = false;
            }
        }
    }" 
    x-init="() => {
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
    }" 
class="flex flex-col flex-grow">
        @include('layouts.topbar')
        @include('layouts.navigation')
        @include('layouts.right-sidebar')

        <main class="flex-grow transition-all duration-300 ease-in-out main-content" :class="mainContentClass">
    <div class="header-container">
        @isset($header)
            <header class="w-full">
                <div class="header-content mx-auto transition-all duration-300 ease-in-out" :class="headerWidth">
                    {{ $header }}
                </div>
            </header>
        @endisset
    </div>

    <div class="p-6">
        {{ $slot }}
    </div>
</main>


        @include('layouts.footer')
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @isset($script)
        {{ $script }}
    @endisset
</body>
</html>