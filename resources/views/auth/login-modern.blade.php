<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InventoryPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus {
            @apply focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideInUp 0.6s ease-out;
        }

        .form-input-group {
            @apply space-y-1;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl flex rounded-2xl overflow-hidden shadow-2xl">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 gradient-bg flex-col justify-between p-12 text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full -ml-36 -mb-36"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center border border-white/30">
                            <i class="fas fa-boxes text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">InventoryPro</h1>
                            <p class="text-blue-100 text-sm">Inventory Management System</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h2 class="text-4xl font-bold mb-4 leading-tight">Kelola Inventori dengan Mudah</h2>
                            <p class="text-blue-100 text-lg leading-relaxed">Sistem manajemen transaksi barang yang modern, intuitif, dan powerful untuk bisnis Anda.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>Dashboard Analytics Real-time</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>Manajemen Data Lengkap</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>User Experience Premium</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-blue-100 text-sm">
                    <p>&copy; 2026 InventoryPro. Semua hak dilindungi.</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 bg-white dark:bg-slate-900 p-8 md:p-12 flex flex-col justify-center animate-slide-in">
                <div class="w-full max-w-sm mx-auto">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex items-center justify-center gap-2 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-white"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">InventoryPro</h1>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Masuk ke Akun</h2>
                        <p class="text-slate-600 dark:text-slate-400">Kelola inventori Anda dengan mudah</p>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg flex items-center gap-3">
                            <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg">
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

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-input-group">
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="admin@example.com"
                                    class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 input-focus transition-colors"
                                />
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="form-input-group">
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 input-focus transition-colors"
                                />
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-2 focus:ring-blue-500"
                            />
                            <label for="remember" class="ml-2 text-sm text-slate-600 dark:text-slate-400">Ingat saya</label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full mt-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-sign-in-alt"></i>
                            Masuk Sekarang
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-300 dark:border-slate-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400">atau</span>
                            </div>
                        </div>

                        <!-- Demo Info -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-sm text-blue-900 dark:text-blue-300 font-semibold mb-2">Demo Credentials:</p>
                            <div class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <p><span class="font-medium">Email:</span> admin@example.com</p>
                                <p><span class="font-medium">Password:</span> password123</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dark Mode Support -->
    <script>
        // Check for saved theme preference or default to 'light'
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
