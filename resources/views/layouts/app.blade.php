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
    :root {
        --topbar-height: 4rem;
        --sidebar-width: 16rem;
        --sidebar-collapsed-width: 5rem;
        --right-sidebar-width: 16rem;
        --right-sidebar-collapsed-width: 5rem;
    }

    body {
        overflow-x: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 40;
        height: var(--topbar-height);
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
        width: var(--sidebar-width);
        transition: all 0.3s ease;
        box-shadow: 8px 0 15px -5px rgba(0, 0, 0, 0.2);
        position: fixed;
        top: var(--topbar-height);
        bottom: 0;
        z-index: 30;
        background-color: #132080;
        height: calc(100vh - var(--topbar-height));
    }

    .sidebar-collapsed {
        width: var(--sidebar-collapsed-width);
        overflow: hidden;
    }

    .right-sidebar {
        width: var(--right-sidebar-width);
        transition: all 0.3s ease;
        box-shadow: -8px 0 15px -5px rgba(0, 0, 0, 0.2);
        position: fixed;
        right: 0;
        top: var(--topbar-height);
        bottom: 0;
        z-index: 30;
    }

    .right-sidebar-collapsed {
        width: var(--right-sidebar-collapsed-width);
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

    /* Main Content Styles */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-right: 0;
        transition: all 0.3s ease;
        padding-top: 6rem;
        width: calc(100% - var(--sidebar-width));
        min-height: calc(100vh - var(--topbar-height));
        position: relative;
    }

    .main-content-collapsed {
        margin-left: var(--sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-collapsed-width));
    }

    .main-content-right-expanded {
        margin-right: var(--right-sidebar-width);
        width: calc(100% - var(--sidebar-width) - var(--right-sidebar-width));
    }

    .main-content-right-collapsed {
        margin-right: var(--right-sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-width) - var(--right-sidebar-collapsed-width));
    }

    .main-content-both-expanded {
        margin-left: var(--sidebar-width);
        margin-right: var(--right-sidebar-width);
        width: calc(100% - var(--sidebar-width) - var(--right-sidebar-width));
    }

    .main-content-left-collapsed-right-expanded {
        margin-left: var(--sidebar-collapsed-width);
        margin-right: var(--right-sidebar-width);
        width: calc(100% - var(--sidebar-collapsed-width) - var(--right-sidebar-width));
    }

    .main-content-left-expanded-right-collapsed {
        margin-left: var(--sidebar-width);
        margin-right: var(--right-sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-width) - var(--right-sidebar-collapsed-width));
    }

    .main-content-both-collapsed {
        margin-left: var(--sidebar-collapsed-width);
        margin-right: var(--right-sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-collapsed-width) - var(--right-sidebar-collapsed-width));
    }

    /* Navigation Links */
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

    /* Footer Styles */
    footer {
        margin-top: auto;
        position: relative;
        width: 100%;
        padding: 1.5rem;
        background: white;
        z-index: 20;
    }

    /* Table Styles */
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

    /* Responsive Breakpoints */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .sidebar-open {
            transform: translateX(0);
        }
        
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
            min-height: calc(100vh - var(--topbar-height) - 6rem);
        }
        
        .header-content {
            max-width: 95%;
            padding: 1rem;
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
    }

    /* Intermediate Breakpoint for 1440px and similar screens */
    @media (min-width: 769px) and (max-width: 1440px) {
        .main-content {
            min-height: calc(100vh - var(--topbar-height) - 6rem);
        }
        
        .main-content-both-expanded {
            min-height: calc(100vh - var(--topbar-height) - 6rem);
        }
        
        .main-content-left-expanded-right-collapsed,
        .main-content-left-collapsed-right-expanded {
            min-height: calc(100vh - var(--topbar-height) - 6rem);
        }
        
        .main-content-both-collapsed {
            min-height: calc(100vh - var(--topbar-height) - 6rem);
        }
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

    <div class="p-6 min-h-[calc(100vh-4rem-6rem)] pb-20"> <!-- Added pb-20 for footer space -->
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