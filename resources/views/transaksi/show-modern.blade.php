@extends('layouts.app-modern')

@section('title', 'Detail Transaksi - InventoryPro')
@section('breadcrumb', 'Detail Transaksi')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-2">
            <i class="fas fa-receipt text-green-600 dark:text-green-400"></i>
            Detail Transaksi
        </h1>
        <p class="text-slate-600 dark:text-slate-400">{{ $transaksi->no_transaksi ?? 'N/A' }}</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="px-6 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-print"></i>
            Print
        </button>
        <a href="{{ route('transaksi.index') }}" class="px-6 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-semibold rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<!-- Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Transaction Info -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>
                Informasi Transaksi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Nomor Transaksi</p>
                    <p class="text-lg font-semibold text-slate-900 dark:text-white mt-1">{{ $transaksi->no_transaksi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Tanggal Transaksi</p>
                    <p class="text-lg font-semibold text-slate-900 dark:text-white mt-1">{{ $transaksi->tgl_transaksi ? date('d M Y H:i', strtotime($transaksi->tgl_transaksi)) : '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Pelanggan</p>
                    <p class="text-lg font-semibold text-slate-900 dark:text-white mt-1">{{ $transaksi->pelanggan->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Kontak Pelanggan</p>
                    <p class="text-lg font-semibold text-slate-900 dark:text-white mt-1">{{ $transaksi->pelanggan->telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">User/Kasir</p>
                    <p class="text-lg font-semibold text-slate-900 dark:text-white mt-1">{{ session('user_name') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Status</p>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="font-semibold text-green-600 dark:text-green-400">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-list text-purple-500"></i>
                Detail Barang
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Barang</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600 dark:text-slate-400">Qty</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Harga</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @if($transaksi->detail_transaksi && $transaksi->detail_transaksi->count() > 0)
                            @foreach($transaksi->detail_transaksi as $detail)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-slate-900 dark:text-white font-medium">
                                        {{ $detail->barang->nama ?? '-' }}
                                        <br>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $detail->barang->kode ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-900 dark:text-white text-center">{{ $detail->qty ?? 0 }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-900 dark:text-white text-right">Rp {{ number_format($detail->harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-slate-900 dark:text-white text-right">Rp {{ number_format(($detail->qty ?? 0) * ($detail->harga ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">Tidak ada detail barang</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Summary Card -->
        <div class="bg-gradient-to-br from-blue-50 dark:from-blue-900/20 to-indigo-50 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-300 mb-6">Ringkasan Pembayaran</h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600 dark:text-slate-400">Subtotal</span>
                    <span class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($transaksi->subtotal ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-600 dark:text-slate-400">Diskon</span>
                    <span class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($transaksi->diskon ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-600 dark:text-slate-400">Pajak</span>
                    <span class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($transaksi->pajak ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="border-t border-blue-300 dark:border-blue-700 pt-4 mt-4">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-blue-900 dark:text-blue-300">Total</span>
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-300">Rp {{ number_format($transaksi->grand_total ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        @if($transaksi->pelanggan)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-purple-500"></i>
                    Data Pelanggan
                </h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Nama</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $transaksi->pelanggan->nama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Telepon</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $transaksi->pelanggan->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Email</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $transaksi->pelanggan->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Alamat</p>
                        <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $transaksi->pelanggan->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Aksi</h3>

            <div class="space-y-2">
                <button onclick="window.print()" class="w-full px-4 py-2 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i>
                    Print Transaksi
                </button>
                <a href="{{ route('transaksi.index') }}" class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Print Style -->
<style media="print">
    body * {
        visibility: hidden;
    }
    body,
    .print-container,
    .print-container * {
        visibility: visible;
    }
    .no-print {
        display: none !important;
    }
    .print-container {
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
@endsection
