<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - InventoryPro Enterprise')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc',
                            400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1',
                            800: '#075985', 900: '#0c3d66',
                        },
                    },
                    boxShadow: {
                        'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'soft-lg': '0 4px 16px rgba(0, 0, 0, 0.1)',
                        'soft-xl': '0 8px 24px rgba(0, 0, 0, 0.12)',
                        'inner-soft': 'inset 0 1px 3px rgba(0, 0, 0, 0.05)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'slide-in-left': 'slideInLeft 0.3s ease-out',
                        'pulse-soft': 'pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-subtle': 'bounceSubtle 0.5s ease-in-out',
                        'shimmer': 'shimmer 2s infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(10px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                        slideInLeft: { '0%': { transform: 'translateX(-10px)', opacity: '0' }, '100%': { transform: 'translateX(0)', opacity: '1' } },
                        pulseSoft: { '0%, 100%': { opacity: '1' }, '50%': { opacity: '.8' } },
                        bounceSubtle: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-2px)' } },
                        shimmer: { '0%': { backgroundPosition: '1000px 0' }, '100%': { backgroundPosition: '-1000px 0' } },
                    },
                }
            }
        }
    </script>
    <style>
        * { scroll-behavior: smooth; }
        .sidebar-enter { animation: slideInLeft 0.3s ease-out; }
        .card-hover { @apply transition-all duration-300 hover:shadow-soft-lg hover:-translate-y-1; }
        .btn-transition { @apply transition-all duration-200; }
        .text-gradient { @apply bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent; }
        .input-focus { @apply focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900; }

        /* Sidebar Enhanced */
        .sidebar { @apply transition-all duration-300; }
        .nav-item-active { @apply bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1 before:bg-gradient-to-b before:from-primary-600 before:to-primary-400; }
        .submenu-enter { animation: slideUp 0.2s ease-out; }

        /* Table Enhanced */
        .table-skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 1000px 100%; animation: shimmer 2s infinite; }
        
        /* Command Palette */
        .command-palette { @apply fixed inset-0 z-50 flex items-start justify-center pt-20; }
        .command-dialog { @apply bg-white dark:bg-slate-900 rounded-xl shadow-soft-xl max-w-2xl w-full mx-4; }

        /* Toast Notification */
        .toast-enter { animation: slideUp 0.3s ease-out; }
        .toast-exit { animation: slideUp 0.3s ease-out reverse; }

        /* Floating Labels */
        .floating-label-group input:focus ~ label,
        .floating-label-group input:not(:placeholder-shown) ~ label { @apply -translate-y-6 text-sm text-primary-600 dark:text-primary-400; }

        @media (max-width: 768px) {
            .sidebar-mobile { @apply fixed left-0 top-0 bottom-0 w-64 bg-white dark:bg-slate-900 transform -translate-x-full transition-transform duration-300 z-40; }
            .sidebar-mobile.active { @apply translate-x-0; }
            .overlay-mobile { @apply fixed inset-0 bg-black bg-opacity-50 hidden z-30; }
            .overlay-mobile.active { @apply block; }
        }

        .tooltip { @apply absolute bottom-full left-1/2 -translate-x-1/2 -translate-y-2 px-2 py-1 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-xs rounded opacity-0 pointer-events-none transition-opacity duration-200; }
        .tooltip.show { @apply opacity-100; }

        .pulse-dot { @apply inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse; }

        /* Sidebar collapse */
        #enterpriseSidebar.collapsed { width: 5rem; }
        #enterpriseSidebar.collapsed .sidebar-label { display: none; }
        #enterpriseSidebar.collapsed #sidebarCollapseBtn i { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-50 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        <!-- Enhanced Sidebar (collapsible) -->
        <aside id="enterpriseSidebar" class="hidden md:flex md:w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex-col shadow-soft sidebar-enter transition-[width] duration-300 relative" aria-label="Sidebar">
            <!-- Sidebar collapse control -->
            <button type="button" id="sidebarCollapseBtn" class="absolute hidden md:flex md:top-4 md:right-2 w-8 h-8 items-center justify-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-soft hover:shadow-soft-lg transition-colors" title="Collapse sidebar">
                <i class="fas fa-chevron-left text-slate-600 dark:text-slate-400"></i>
            </button>
            <!-- Workspace Header -->
            <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-bold text-lg text-slate-900 dark:text-white">InventoryPro</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Enterprise Edition</p>
                    </div>
                </div>
                <div class="h-px bg-gradient-to-r from-primary-500/20 to-transparent"></div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <!-- Main Section -->
                <div class="mb-6">
                    <p class="px-4 py-2 text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-wider">Utama</p>
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-item flex items-center gap-3 px-4 py-3 rounded-lg relative {{ request()->routeIs('dashboard') ? 'nav-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors duration-200" data-tooltip="Dashboard">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="sidebar-label font-medium">Dashboard</span>

                        @if(request()->routeIs('dashboard'))
                            <span class="ml-auto w-2 h-2 bg-primary-600 rounded-full"></span>
                        @endif
                    </a>
                </div>

                <!-- Data Section -->
                <div class="mb-6">
                    <p class="px-4 py-2 text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-wider">Data</p>
                    
                    <!-- Barang with Submenu -->
                    <div class="space-y-1">
                        <button onclick="toggleSubmenu(event, 'barangSubmenu')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200 group">
                            <i class="fas fa-boxes w-5"></i>
                            <span class="sidebar-label font-medium">Barang</span>
                            <i class="fas fa-chevron-right w-4 ml-auto transition-transform duration-300 group-hover:rotate-90"></i>
                        </button>
                        <div id="barangSubmenu" class="ml-4 space-y-1 hidden submenu-enter">
                            <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fas fa-list-ul w-4"></i>
                                <span>Daftar Barang</span>
                            </a>
                            <a href="{{ route('barang.create') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fas fa-plus w-4"></i>
                                <span>Tambah Barang</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('pelanggan.index') }}" class="sidebar-nav-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('pelanggan.*') ? 'nav-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors duration-200 relative" data-tooltip="Pelanggan">
                        <i class="fas fa-users w-5"></i>
                        <span class="sidebar-label font-medium">Pelanggan</span>

                        @if(request()->routeIs('pelanggan.*'))
                            <span class="ml-auto w-2 h-2 bg-primary-600 rounded-full"></span>
                        @endif
                    </a>
                </div>

                <!-- Transactions Section -->
                <div class="mb-6">
                    <p class="px-4 py-2 text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-wider sidebar-label">Transaksi</p>
                    <a href="{{ route('transaksi.index') }}" class="sidebar-nav-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('transaksi.*') ? 'nav-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors duration-200 relative" data-tooltip="Transaksi">
                        <i class="fas fa-receipt w-5"></i>
                        <span class="sidebar-label font-medium">Transaksi</span>

                        @if(request()->routeIs('transaksi.*'))
                            <span class="ml-auto w-2 h-2 bg-primary-600 rounded-full"></span>
                        @endif
                    </a>
                </div>

                <!-- Analytics Section -->
                <div class="mb-6">
                    <p class="px-4 py-2 text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-wider">Analytics</p>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span class="font-medium">Reports</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile Section -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 space-y-3">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center flex-shrink-0 relative">
                            <i class="fas fa-user text-white text-sm"></i>
                            <span class="pulse-dot absolute -bottom-0.5 -right-0.5"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-slate-900 dark:text-white truncate">{{ session('user_name') ?? 'User' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ session('user_role') ?? 'user' }}</p>
                        </div>
                    </div>
                    <button class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors">
                        <i class="fas fa-ellipsis-v text-slate-600 dark:text-slate-400"></i>
                    </button>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <div class="overlay-mobile" id="sidebarOverlay"></div>
        <aside class="sidebar-mobile md:hidden" id="mobileSidebar">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <h1 class="font-bold text-lg">InventoryPro</h1>
                </div>
                <button id="closeSidebar">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fas fa-boxes"></i>
                    <span>Barang</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Smart Navbar -->
            <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-soft sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 md:px-8 py-4 gap-4">
                    <!-- Mobile Menu Button -->
                    <button id="menuToggle" class="md:hidden text-slate-600 dark:text-slate-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="hidden md:block flex-1">
                        <nav class="flex items-center gap-2 text-sm">
                            <a href="{{ route('dashboard') }}" class="text-slate-500 dark:text-slate-400 hover:text-primary-600">Dashboard</a>
                            <span class="text-slate-400">/</span>
                            <span class="text-slate-900 dark:text-slate-50 font-medium">@yield('breadcrumb', 'Page')</span>
                        </nav>
                    </div>

                    <!-- Search & Actions -->
                    <div class="flex items-center gap-2 md:gap-4">
                        <!-- Command Palette Trigger -->
                        <button id="commandPaletteTrigger" class="hidden md:flex items-center gap-2 px-3 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg text-sm text-slate-600 dark:text-slate-400 transition-colors">
                            <i class="fas fa-search"></i>
                            <span class="text-xs">Ctrl+K</span>
                        </button>

                        <!-- Dark Mode Toggle -->
                        <button id="darkModeToggle" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <i class="fas fa-moon text-slate-600 dark:text-slate-400"></i>
                        </button>

                        <!-- Notifications -->
                        <div class="relative group">
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative transition-colors">
                                <i class="fas fa-bell text-slate-600 dark:text-slate-400"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-soft-xl hidden group-hover:block py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-200 dark:border-slate-700">
                                    <p class="font-semibold text-sm text-slate-900 dark:text-white">Notifikasi</p>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors border-b border-slate-100 dark:border-slate-800">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white">Stok Barang Kritis</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">3 barang mencapai minimum stock</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">2 menit lalu</p>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative group">
                            <button class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center hover:shadow-soft-lg transition-shadow">
                                <i class="fas fa-user text-white text-sm"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-soft-xl hidden group-hover:block py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-200 dark:border-slate-700">
                                    <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ session('user_name') ?? 'User' }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Command Palette Modal -->
            <div id="commandPalette" class="command-palette hidden backdrop-blur-sm">
                <div class="command-dialog animate-fade-in">
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                        <input type="text" id="commandInput" placeholder="Cari atau ketik command..." class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div id="commandResults" class="max-h-96 overflow-y-auto p-2 space-y-1"></div>
                </div>
            </div>

            <!-- Toast Container -->
            <div id="toastContainer" class="fixed bottom-4 right-4 space-y-2 z-40"></div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8 space-y-6">
                    <!-- System Alerts -->
                    @if(session('success'))
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg flex items-center gap-3 animate-fade-in" role="alert">
                            <i class="fas fa-check-circle flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-auto">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg flex items-center gap-3 animate-fade-in" role="alert">
                            <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                            <span>{{ session('error') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-auto">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-circle flex-shrink-0 mt-0.5"></i>
                                <ul class="space-y-1 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark Mode
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') html.classList.add('dark');

        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile Sidebar
        const menuToggle = document.getElementById('menuToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        menuToggle?.addEventListener('click', () => {
            mobileSidebar.classList.add('active');
            overlay.classList.add('active');
        });

        closeSidebar?.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay?.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        const sidebarLinks = mobileSidebar?.querySelectorAll('a');
        sidebarLinks?.forEach(link => {
            link.addEventListener('click', () => {
                mobileSidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });

        // Submenu Toggle
        function toggleSubmenu(e, id) {
            e.preventDefault();
            const submenu = document.getElementById(id);
            submenu.classList.toggle('hidden');
            e.target.closest('button').querySelector('i:last-child')?.classList.toggle('rotate-90');
        }

        // Command Palette (Ctrl+K)
        const commandPalette = document.getElementById('commandPalette');
        const commandPaletteTrigger = document.getElementById('commandPaletteTrigger');
        const commandInput = document.getElementById('commandInput');

        commandPaletteTrigger?.addEventListener('click', () => {
            commandPalette.classList.remove('hidden');
            commandInput.focus();
        });

        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                commandPalette.classList.remove('hidden');
                commandInput.focus();
            }
            if (e.key === 'Escape') {
                commandPalette.classList.add('hidden');
            }
        });

        // Toast Notification System
        function showToast(message, type = 'info', duration = 4000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-100 dark:bg-green-900/20' : 
                           type === 'error' ? 'bg-red-100 dark:bg-red-900/20' : 
                           'bg-blue-100 dark:bg-blue-900/20';
            const textColor = type === 'success' ? 'text-green-800 dark:text-green-300' : 
                             type === 'error' ? 'text-red-800 dark:text-red-300' : 
                             'text-blue-800 dark:text-blue-300';
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-circle' : 
                        'fa-info-circle';

            toast.innerHTML = `
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg ${bgColor} ${textColor} border border-current border-opacity-20 toast-enter">
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                    <button onclick="this.closest('div').remove()" class="ml-auto text-xl opacity-50 hover:opacity-100">×</button>
                </div>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, duration);
        }

        // Expose globally
        window.showToast = showToast;

        // Sidebar collapse + tooltips (enterprise)
        (function () {
            const sidebar = document.getElementById('enterpriseSidebar');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            if (!sidebar || !collapseBtn) return;

            const storageKey = 'enterpriseSidebarCollapsed';
            const applyState = (collapsed) => {
                if (collapsed) sidebar.classList.add('collapsed');
                else sidebar.classList.remove('collapsed');

                // If collapsed, show only tooltips
                document.querySelectorAll('[data-tooltip]').forEach(el => {
                    if (collapsed) {
                        el.setAttribute('data-tooltip-enabled', '1');
                    } else {
                        el.removeAttribute('data-tooltip-enabled');
                    }
                });
            };

            const saved = localStorage.getItem(storageKey);
            applyState(saved === '1');

            collapseBtn.addEventListener('click', () => {
                const nowCollapsed = !sidebar.classList.contains('collapsed');
                applyState(nowCollapsed);
                localStorage.setItem(storageKey, nowCollapsed ? '1' : '0');

                const i = collapseBtn.querySelector('i');
                if (i) i.style.transform = nowCollapsed ? 'rotate(180deg)' : '';
            });

            // Tooltip render (simple, on hover only when sidebar collapsed)
            let tooltipEl = null;
            const showTip = (target) => {
                if (!sidebar.classList.contains('collapsed')) return;
                const tip = target.getAttribute('data-tooltip');
                if (!tip) return;

                // Avoid duplicates
                if (tooltipEl) tooltipEl.remove();
                tooltipEl = document.createElement('div');
                tooltipEl.className = 'tooltip show';
                tooltipEl.textContent = tip;
                document.body.appendChild(tooltipEl);

                // Position near left side
                const rect = target.getBoundingClientRect();
                tooltipEl.style.left = `${rect.right + 10}px`;
                tooltipEl.style.top = `${rect.top + rect.height / 2}px`;
                tooltipEl.style.transform = 'translateY(-50%) translateX(0)';
            };

            const hideTip = () => {
                if (tooltipEl) {
                    tooltipEl.remove();
                    tooltipEl = null;
                }
            };

            document.querySelectorAll('[data-tooltip]').forEach(el => {
                el.addEventListener('mouseenter', () => showTip(el));
                el.addEventListener('mouseleave', hideTip);
            });

            // Close tooltip on scroll
            window.addEventListener('scroll', hideTip);
        })();
    </script>
</body>
</html>
