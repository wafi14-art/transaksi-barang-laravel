@extends('layouts.app-modern')

@section('title', 'Transaksi Baru - InventoryPro')
@section('breadcrumb', 'Buat Transaksi')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-2">
        <i class="fas fa-plus text-green-600 dark:text-green-400"></i>
        Buat Transaksi Baru
    </h1>
    <p class="text-slate-600 dark:text-slate-400">Catat penjualan atau pembelian barang</p>
</div>

<!-- Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Info -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-receipt text-green-500"></i>
                    Informasi Transaksi
                </h3>

                <div class="space-y-5">
                    <!-- Tanggal -->
                    <div>
                        <label for="tgl_transaksi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Tanggal Transaksi <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="datetime-local"
                            id="tgl_transaksi"
                            name="tgl_transaksi"
                            value="{{ old('tgl_transaksi', date('Y-m-d\TH:i')) }}"
                            required
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('tgl_transaksi') border-red-500 @enderror"
                        />
                        @error('tgl_transaksi')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pelanggan -->
                    <div>
                        <label for="pelanggan_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Pelanggan <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="pelanggan_id"
                            name="pelanggan_id"
                            required
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('pelanggan_id') border-red-500 @enderror"
                        >
                            <option value="">Pilih Pelanggan</option>
                            @if(isset($pelanggan))
                                @foreach($pelanggan as $p)
                                    <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }} - {{ $p->telepon }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('pelanggan_id')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-list text-blue-500"></i>
                    Item Transaksi
                </h3>

                <div class="space-y-4">
                    <div id="itemsContainer">
                        <!-- Items akan ditambahkan di sini -->
                    </div>

                    <button type="button" onclick="tambahItem()" class="w-full px-4 py-3 border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-green-500 dark:hover:border-green-500 rounded-lg text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Item
                    </button>
                </div>
            </div>

            <!-- Calculation -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-calculator text-yellow-500"></i>
                    Perhitungan
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label for="subtotal" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Subtotal</label>
                        <span class="text-lg font-bold text-slate-900 dark:text-white">Rp <input type="text" id="subtotal" name="subtotal" readonly class="bg-transparent w-32 text-right" value="0"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="diskon" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Diskon</label>
                        <input type="number" id="diskon" name="diskon" value="0" min="0" class="w-32 px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-right focus:outline-none focus:ring-2 focus:ring-green-500" onchange="hitungTotal()">
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="pajak" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Pajak</label>
                        <input type="number" id="pajak" name="pajak" value="0" min="0" class="w-32 px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-right focus:outline-none focus:ring-2 focus:ring-green-500" onchange="hitungTotal()">
                    </div>
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-4 flex items-center justify-between">
                        <span class="text-lg font-bold text-slate-900 dark:text-white">Total</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">Rp <input type="text" id="grand_total" name="grand_total" readonly class="bg-transparent w-40 text-right text-2xl font-bold text-green-600 dark:text-green-400" value="0"></span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                    <i class="fas fa-check"></i>
                    Simpan Transaksi
                </button>
                <a href="{{ route('transaksi.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Tips -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
            <h4 class="font-bold text-green-900 dark:text-green-300 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb"></i>
                Tips Input
            </h4>
            <ul class="space-y-3 text-sm text-green-800 dark:text-green-200">
                <li class="flex gap-2">
                    <span class="text-green-500 mt-1">→</span>
                    <span>Pilih pelanggan terlebih dahulu</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-green-500 mt-1">→</span>
                    <span>Tambahkan barang yang dijual</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-green-500 mt-1">→</span>
                    <span>Atur diskon dan pajak jika diperlukan</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-green-500 mt-1">→</span>
                    <span>Total otomatis dihitung</span>
                </li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-4">Akses Cepat</h4>
            <div class="space-y-2">
                <a href="{{ route('pelanggan.create') }}" class="block w-full px-4 py-2 text-center bg-purple-100 dark:bg-purple-900/30 hover:bg-purple-200 dark:hover:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-lg font-medium transition-colors text-sm">
                    + Pelanggan Baru
                </a>
                <a href="{{ route('barang.create') }}" class="block w-full px-4 py-2 text-center bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg font-medium transition-colors text-sm">
                    + Barang Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Template Item Row (hidden) -->
<template id="itemTemplate">
    <div class="item-row bg-slate-50 dark:bg-slate-900/50 p-4 rounded-lg border border-slate-200 dark:border-slate-700 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Barang</label>
                <select name="barang_id[]" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500" onchange="hitungTotal()" required>
                    <option value="">Pilih Barang</option>
                    @if(isset($barang))
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" data-harga="{{ $b->harga }}">
                                {{ $b->nama }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Qty</label>
                <input type="number" name="qty[]" min="1" value="1" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500" onchange="hitungTotal()" required>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Harga</label>
                <input type="number" name="harga[]" min="0" value="0" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500" onchange="hitungTotal()" required>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Subtotal</label>
                <input type="text" class="subtotal w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm" readonly>
            </div>
        </div>
        <button type="button" onclick="hapusItem(this)" class="w-full px-3 py-2 bg-red-100 dark:bg-red-900/20 hover:bg-red-200 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg font-medium text-sm transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-trash"></i>
            Hapus Item
        </button>
    </div>
</template>

<script>
function tambahItem() {
    const template = document.getElementById('itemTemplate');
    const clone = template.content.cloneNode(true);
    document.getElementById('itemsContainer').appendChild(clone);
    hitungTotal();
}

function hapusItem(btn) {
    btn.closest('.item-row').remove();
    hitungTotal();
}

function hitungTotal() {
    let subtotal = 0;
    const itemRows = document.querySelectorAll('.item-row');
    
    itemRows.forEach(row => {
        const qty = parseInt(row.querySelector('input[name="qty[]"]').value) || 0;
        const harga = parseInt(row.querySelector('input[name="harga[]"]').value) || 0;
        const rowTotal = qty * harga;
        row.querySelector('.subtotal').value = 'Rp ' + rowTotal.toLocaleString('id-ID');
        subtotal += rowTotal;
    });
    
    document.getElementById('subtotal').value = subtotal.toLocaleString('id-ID');
    
    const diskon = parseInt(document.getElementById('diskon').value) || 0;
    const pajak = parseInt(document.getElementById('pajak').value) || 0;
    const grandTotal = subtotal - diskon + pajak;
    
    document.getElementById('grand_total').value = grandTotal.toLocaleString('id-ID');
}

// Tambah 1 item saat halaman load
window.addEventListener('load', () => {
    if (document.getElementById('itemsContainer').children.length === 0) {
        tambahItem();
    }
});
</script>
@endsection
