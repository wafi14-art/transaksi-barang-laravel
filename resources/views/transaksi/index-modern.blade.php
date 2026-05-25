@extends('layouts.app-modern')

@section('title', 'Transaksi - InventoryPro')
@section('breadcrumb', 'Transaksi')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
            <i class="fas fa-receipt text-green-600 dark:text-green-400"></i>
            Daftar Transaksi
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola semua transaksi penjualan dan pembelian</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Transaksi Baru
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Transaksi</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ count($transaksi) }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Nilai</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">Rp {{ number_format($totalNilai ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Bulan Ini</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $transaksiIni ?? 0 }}</p>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" placeholder="Cari transaksi..." class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
        </div>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <i class="fas fa-calendar"></i>
            Filter Tanggal
        </button>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <i class="fas fa-download"></i>
            Export
        </button>
    </div>
</div>

<!-- Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft overflow-hidden">
    <!-- Desktop View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">No. Transaksi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Items</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Total</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($transaksi as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $item->no_transaksi ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $item->pelanggan->nama ?? '-' }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->pelanggan->telepon ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->tgl_transaksi ? date('d M Y', strtotime($item->tgl_transaksi)) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->detail_transaksi?->count() ?? 0 }} item
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white text-right">
                            Rp {{ number_format($item->grand_total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('transaksi.show', $item->id) }}" class="p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg transition-colors" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('transaksi.show', $item->id) }}" class="p-2 hover:bg-green-100 dark:hover:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg transition-colors" title="Print">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-slate-400"></i>
                                <p class="text-slate-500 dark:text-slate-400">Belum ada transaksi</p>
                                <a href="{{ route('transaksi.create') }}" class="text-green-600 dark:text-green-400 hover:underline text-sm mt-2">Buat transaksi baru →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($transaksi as $item)
            <div class="p-4 space-y-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->no_transaksi ?? '-' }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->pelanggan->nama ?? '-' }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Selesai
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Tanggal</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->tgl_transaksi ? date('d M Y', strtotime($item->tgl_transaksi)) : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Total</p>
                        <p class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($item->grand_total ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <a href="{{ route('transaksi.show', $item->id) }}" class="flex-1 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors text-center">Lihat</a>
                    <a href="{{ route('transaksi.show', $item->id) }}" class="flex-1 px-3 py-2 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-lg text-sm font-medium hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors text-center">Print</a>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-3xl text-slate-400 mb-2 block"></i>
                <p class="text-slate-500 dark:text-slate-400">Belum ada transaksi</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($transaksi->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $transaksi->links() }}
    </div>
@endif
@endsection
