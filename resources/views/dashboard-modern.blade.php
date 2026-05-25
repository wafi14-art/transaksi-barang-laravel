@extends('layouts.app-modern')

@section('title', 'Dashboard - InventoryPro')
@section('breadcrumb', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Barang -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Barang</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalBarang ?? 0 }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    <span class="text-green-600 dark:text-green-400">+12%</span> dari bulan lalu
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 dark:from-blue-900/30 to-blue-50 dark:to-blue-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pelanggan</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalPelanggan ?? 0 }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    <span class="text-green-600 dark:text-green-400">+5%</span> dari bulan lalu
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 dark:from-purple-900/30 to-purple-50 dark:to-purple-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-2xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Transaksi</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalTransaksi ?? 0 }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    <span class="text-green-600 dark:text-green-400">+8%</span> dari bulan lalu
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-green-100 dark:from-green-900/30 to-green-50 dark:to-green-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <!-- Status Hari Ini -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Status Hari Ini</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $transaksiHariIni ?? 0 }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    <i class="fas fa-clock text-orange-500 mr-1"></i>
                    <span class="text-orange-600 dark:text-orange-400">Berlangsung</span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 dark:from-orange-900/30 to-orange-50 dark:to-orange-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-2xl text-orange-600 dark:text-orange-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Transactions -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-history text-blue-600 dark:text-blue-400"></i>
                Transaksi Terbaru
            </h3>
            <a href="{{ route('transaksi.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">Lihat semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">No. Transaksi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Tanggal</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @if(isset($transaksiTerbaru) && count($transaksiTerbaru) > 0)
                        @foreach($transaksiTerbaru as $transaksi)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $transaksi->no_transaksi ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $transaksi->tgl_transaksi ? date('d M Y', strtotime($transaksi->tgl_transaksi)) : '-' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-900 dark:text-white text-right">Rp {{ number_format($transaksi->grand_total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">Tidak ada transaksi</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-lightning-bolt text-yellow-600 dark:text-yellow-400"></i>
            Aksi Cepat
        </h3>

        <div class="space-y-3">
            <a href="{{ route('transaksi.create') }}" class="flex items-center gap-3 w-full p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-lg transition-colors text-left">
                <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Transaksi Baru</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400">Buat transaksi baru</p>
                </div>
            </a>

            <a href="{{ route('barang.create') }}" class="flex items-center gap-3 w-full p-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 border border-green-200 dark:border-green-800 rounded-lg transition-colors text-left">
                <div class="w-10 h-10 bg-green-600 dark:bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Barang Baru</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400">Tambah barang ke gudang</p>
                </div>
            </a>

            <a href="{{ route('pelanggan.create') }}" class="flex items-center gap-3 w-full p-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 border border-purple-200 dark:border-purple-800 rounded-lg transition-colors text-left">
                <div class="w-10 h-10 bg-purple-600 dark:bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Pelanggan Baru</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400">Daftarkan pelanggan baru</p>
                </div>
            </a>
        </div>

        <!-- Info Box -->
        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
            <div class="bg-gradient-to-br from-blue-50 dark:from-blue-900/20 to-purple-50 dark:to-purple-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                <p class="text-sm font-semibold text-slate-900 dark:text-white mb-2">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>
                    Tips & Trik
                </p>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Gunakan sidebar untuk navigasi cepat ke semua fitur. Aktifkan dark mode untuk kenyamanan mata di malam hari.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Updates -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Top Barang -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-star text-yellow-500"></i>
            Barang Terpopuler
        </h3>
        <div class="space-y-3">
            @if(isset($barangTerpopuler) && count($barangTerpopuler) > 0)
                @foreach($barangTerpopuler->slice(0, 5) as $barang)
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $barang->nama ?? '-' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Stok: {{ $barang->stok ?? 0 }} unit</p>
                        </div>
                        <span class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-medium">
                            Rp {{ number_format($barang->harga ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            @else
                <p class="text-slate-500 dark:text-slate-400 text-sm text-center py-4">Belum ada data barang</p>
            @endif
        </div>
    </div>

    <!-- System Stats -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-server text-cyan-500"></i>
            Statistik Sistem
        </h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-database text-blue-500"></i>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">Database</span>
                </div>
                <span class="text-sm font-semibold text-green-600 dark:text-green-400">Connected</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-check text-purple-500"></i>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">Session</span>
                </div>
                <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Active</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-leaf text-green-500"></i>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">Performance</span>
                </div>
                <span class="text-sm font-semibold text-green-600 dark:text-green-400">Optimal</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-orange-500"></i>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">Security</span>
                </div>
                <span class="text-sm font-semibold text-green-600 dark:text-green-400">Secure</span>
            </div>
        </div>
    </div>
</div>
@endsection
