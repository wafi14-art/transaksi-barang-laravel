<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Transaksi Barang')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c3d66',
                        },
                    },
                    boxShadow: {
                        'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'soft-lg': '0 4px 16px rgba(0, 0, 0, 0.1)',
                        'soft-xl': '0 8px 24px rgba(0, 0, 0, 0.12)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-soft': 'pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '.8' },
                        },
                    },
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.437.0/dist/lucide.min.js"></script>
    <style>
        :root {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        * {
            scroll-behavior: smooth;
        }

        .sidebar-enter {
            animation: slideUp 0.32s ease-out;
        }

        .card-hover {
            @apply transition-all duration-300 hover:shadow-soft-lg hover:-translate-y-1;
        }

        .btn-transition {
            @apply transition-all duration-200;
        }

        .text-gradient {
            @apply bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent;
        }

        .sidebar-link {
            @apply flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-200;
        }

        .sidebar-link:hover {
            @apply bg-slate-900/10 text-slate-50;
        }

        .sidebar-link-active {
            @apply bg-gradient-to-r from-cyan-600/20 to-slate-900/30 text-cyan-400 shadow-soft-lg ring-1 ring-cyan-500/15;
        }

        @media (max-width: 768px) {
            .sidebar-mobile {
                @apply fixed left-0 top-0 bottom-0 w-72 bg-slate-950 transform -translate-x-full transition-transform duration-300 z-40;
            }

            .sidebar-mobile.active {
                @apply translate-x-0;
            }

            .overlay-mobile {
                @apply fixed inset-0 bg-black bg-opacity-50 hidden z-30;
            }

            .overlay-mobile.active {
                @apply block;
            }
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-50 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:w-72 bg-slate-950 text-slate-100 border-r border-slate-900/70 flex-col shadow-soft sidebar-enter">
            <div class="p-6 bg-gradient-to-br from-slate-900 via-cyan-700 to-cyan-500 text-white shadow-soft-lg">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-3xl bg-white/10 ring-1 ring-white/10 flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-cyan-100/80">Premium SaaS</p>
                        <h1 class="text-xl font-bold">eProduct</h1>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-200/80 leading-6">Modern POS inventory untuk kasir enterprise dengan pengalaman checkout cepat dan dashboard bisnis yang premium.</p>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="sidebar-link {{ request()->routeIs('transaksi.*') ? 'sidebar-link-active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="sidebar-link {{ request()->routeIs('pelanggan.*') ? 'sidebar-link-active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Pembeli</span>
                </a>
                <a href="{{ route('barang.index') }}" class="sidebar-link {{ request()->routeIs('barang.*') ? 'sidebar-link-active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Barang</span>
                </a>
                <a href="#" class="sidebar-link text-slate-300 hover:bg-slate-800 hover:text-white">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    <span>Laporan</span>
                </a>
                <a href="#" class="sidebar-link text-slate-300 hover:bg-slate-800 hover:text-white">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-800 bg-slate-950">
                <div class="rounded-3xl bg-slate-900/80 p-4 ring-1 ring-white/10 shadow-soft-lg">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-3xl bg-cyan-600 flex items-center justify-center text-white">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 ring-2 ring-slate-950"></span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ session('user_name') ?? 'Kasir eProduct' }}</p>
                            <p class="text-xs text-slate-400 capitalize">Online • Aktif</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Kelola penjualan, stok, dan pelanggan dengan kontrol POS cepat yang terintegrasi.</p>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div class="overlay-mobile" id="sidebarOverlay"></div>

        <!-- Mobile Sidebar -->
        <aside class="sidebar-mobile md:hidden" id="mobileSidebar">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-white text-lg"></i>
                        </div>
                        <h1 class="font-bold text-lg">InventoryPro</h1>
                    </div>
                    <button id="closeSidebar" class="md:hidden">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-100 hover:bg-slate-900/80">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-100 hover:bg-slate-900/80">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-100 hover:bg-slate-900/80">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Pembeli</span>
                </a>
                <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-100 hover:bg-slate-900/80">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Barang</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-soft sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 md:px-8 py-4">
                    <!-- Mobile Menu Button -->
                    <button id="menuToggle" class="md:hidden text-slate-600 dark:text-slate-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 md:flex md:items-center md:justify-between">
                        <!-- Breadcrumb -->
                        <div class="hidden md:block">
                            <nav class="flex items-center gap-2 text-sm">
                                <a href="{{ route('dashboard') }}" class="text-slate-500 dark:text-slate-400 hover:text-primary-600">Dashboard</a>
                                <span class="text-slate-400">/</span>
                                <span class="text-slate-900 dark:text-slate-50 font-medium">@yield('breadcrumb', 'Page')</span>
                            </nav>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-4">
                            <!-- Dark Mode Toggle -->
                            <button id="darkModeToggle" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                <i class="fas fa-moon text-slate-600 dark:text-slate-400"></i>
                            </button>

                            <!-- Notifications -->
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative transition-colors">
                                <i class="fas fa-bell text-slate-600 dark:text-slate-400"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- User Menu -->
                            <div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800">
                                <div class="hidden sm:block text-right">
                                    <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ session('user_name') ?? 'User' }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ session('user_role') ?? 'user' }}</p>
                                </div>
                                <div class="relative group">
                                    <button class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center hover:shadow-soft-lg transition-shadow">
                                        <i class="fas fa-user text-white"></i>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-soft-xl hidden group-hover:block py-2 z-50">
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
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8 space-y-6">
                    <!-- Alerts -->
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
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        // Check for saved theme preference or default to 'light'
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile Sidebar Toggle
        const menuToggle = document.getElementById('menuToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        menuToggle.addEventListener('click', () => {
            mobileSidebar.classList.add('active');
            overlay.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Close sidebar on link click
        const sidebarLinks = mobileSidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileSidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
