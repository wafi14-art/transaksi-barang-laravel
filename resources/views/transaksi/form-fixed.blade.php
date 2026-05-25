@extends('layouts.app-modern')

@section('title', 'Transaksi POS - eProduct')
@section('breadcrumb', 'Transaksi POS')

@section('content')
<div class="space-y-6">
    <div class="mb-6 rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.24em] text-cyan-600">Transaksi POS</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Kasir eProduct</h1>
                <p class="mt-2 text-slate-500 max-w-2xl">Transaksi cepat untuk toko kelontong dengan ringkasan real-time dan checkout yang mudah.</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Produk Tersedia</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $barang->count() }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Pelanggan Aktif</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $pelanggan->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('transaksi.store') }}" method="POST" class="grid gap-6 lg:grid-cols-[1.5fr_0.9fr]">
        @csrf

        <section class="space-y-6">
            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Informasi Transaksi</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Detail Transaksi</h2>
                    </div>
                    <button type="button" onclick="tambahItem()" class="inline-flex items-center justify-center gap-2 rounded-3xl bg-cyan-600 px-5 py-3 text-sm font-semibold text-white shadow-soft hover:bg-cyan-700 transition">
                        <i class="fas fa-plus"></i>
                        Tambah Item
                    </button>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="tgl_transaksi" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi</label>
                        <input type="datetime-local" id="tgl_transaksi" name="tgl_transaksi" value="{{ old('tgl_transaksi', date('Y-m-d\TH:i')) }}" required class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                        @error('tgl_transaksi')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pelanggan_id" class="block text-sm font-semibold text-slate-700 mb-2">Pelanggan</label>
                        <select id="pelanggan_id" name="pelanggan_id" required class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                            <option value="">Pilih pelanggan</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }} - {{ $p->telepon }}</option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="itemsContainer" class="space-y-4"></div>

            <template id="itemTemplate">
                <div class="item-row rounded-[2rem] bg-slate-50 border border-slate-200 p-5 shadow-sm space-y-4">
                    <div class="grid gap-4 lg:grid-cols-[1.5fr_0.9fr_0.9fr_1fr]">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Barang</label>
                            <select name="barang_id[]" onchange="updateItemRow(this)" required class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                <option value="" data-harga="0">Pilih barang</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->id }}" data-harga="{{ $b->harga_jual }}">{{ $b->nama_barang }} - Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah</label>
                            <input type="number" name="jumlah[]" value="1" min="1" onchange="updateItemRow(this)" required class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga</label>
                            <input type="number" name="harga_satuan[]" value="0" min="0" onchange="updateItemRow(this)" required class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Subtotal</label>
                            <input type="text" readonly class="subtotal w-full rounded-3xl border border-slate-300 bg-slate-100 px-4 py-3 text-slate-900" value="Rp 0" />
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-slate-500">Isi data barang dan jumlah, subtotal akan terhitung otomatis.</div>
                        <button type="button" onclick="hapusItem(this)" class="rounded-full bg-rose-100 px-4 py-2 text-rose-700 transition hover:bg-rose-200">Hapus</button>
                    </div>
                </div>
            </template>
        </section>

        <aside class="space-y-6">
            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6 space-y-6">
                <div>
                    <p class="text-sm uppercase tracking-[0.22em] text-slate-400">Ringkasan Pembayaran</p>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-900">Total Transaksi</h2>
                </div>

                <div class="grid gap-4">
                    <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-sm text-slate-500">Subtotal</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-900" id="displaySubtotal">Rp 0</p>
                    </div>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold text-slate-700">Bayar</label>
                        <input type="number" id="bayar" name="bayar" value="0" min="0" onchange="hitungTotal()" class="w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-950 p-5 text-white">
                    <div class="flex items-center justify-between text-sm text-slate-300">
                        <span>Total Akhir</span>
                        <span class="text-xl font-semibold" id="displayTotal">Rp 0</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
                        <span>Kembalian</span>
                        <span class="text-xl font-semibold" id="displayChange">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="w-full rounded-3xl bg-cyan-600 px-5 py-4 text-white font-semibold shadow-soft hover:bg-cyan-700 transition">Simpan Transaksi</button>
            </div>

            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
                <h3 class="text-lg font-semibold text-slate-900">Catatan</h3>
                <p class="mt-2 text-sm text-slate-500">Anda dapat menambahkan catatan tambahan di formulir transaksi berikut.</p>
                <textarea name="catatan" rows="5" class="mt-4 w-full rounded-3xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" placeholder="Tambahkan catatan...">{{ old('catatan') }}</textarea>
            </div>
        </aside>
    </form>
</div>

<script>
function formatCurrency(value) {
    return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
}

function hitungRow(row) {
    const qty = Number(row.querySelector('input[name="jumlah[]"]').value) || 0;
    const harga = Number(row.querySelector('input[name="harga_satuan[]"]').value) || 0;
    const subtotal = qty * harga;
    row.querySelector('.subtotal').value = formatCurrency(subtotal);
    return subtotal;
}

function updateItemRow(element) {
    const row = element.closest('.item-row');
    const selected = row.querySelector('select[name="barang_id[]"]');
    const hargaInput = row.querySelector('input[name="harga_satuan[]"]');

    if (element.name === 'barang_id[]' && selected.selectedOptions.length) {
        hargaInput.value = selected.selectedOptions[0].dataset.harga || 0;
    }

    hitungRow(row);
    hitungTotal();
}

function tambahItem() {
    const template = document.getElementById('itemTemplate');
    const clone = template.content.cloneNode(true);
    document.getElementById('itemsContainer').appendChild(clone);
    hitungTotal();
}

function hapusItem(button) {
    const row = button.closest('.item-row');
    if (row) {
        row.remove();
        hitungTotal();
    }
}

function hitungTotal() {
    const rows = document.querySelectorAll('.item-row');
    let subtotal = 0;

    rows.forEach(row => {
        subtotal += hitungRow(row);
    });

    const bayar = Number(document.getElementById('bayar').value) || 0;
    const total = subtotal;
    const change = Math.max(bayar - total, 0);

    document.getElementById('displaySubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('displayTotal').textContent = formatCurrency(total);
    document.getElementById('displayChange').textContent = formatCurrency(change);
}

window.addEventListener('load', () => {
    if (document.querySelectorAll('.item-row').length === 0) {
        tambahItem();
    }
});
</script>
@endsection
