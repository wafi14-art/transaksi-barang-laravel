@extends('layouts.app-modern')

@section('title', isset($barang) ? 'Edit Barang - InventoryPro' : 'Tambah Barang - InventoryPro')
@section('breadcrumb', isset($barang) ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-2">
        <i class="fas fa-{{ isset($barang) ? 'edit' : 'plus' }} text-blue-600 dark:text-blue-400"></i>
        {{ isset($barang) ? 'Edit Barang' : 'Tambah Barang Baru' }}
    </h1>
    <p class="text-slate-600 dark:text-slate-400">{{ isset($barang) ? 'Ubah informasi barang yang sudah ada' : 'Tambahkan barang baru ke dalam sistem' }}</p>
</div>

<!-- Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ isset($barang) ? route('barang.update', $barang->id) : route('barang.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($barang))
                @method('PUT')
            @endif

            <!-- Basic Information Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i>
                    Informasi Dasar
                </h3>

                <div class="space-y-5">
                    <!-- Nama Barang -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama', $barang->nama ?? '') }}"
                            required
                            placeholder="Contoh: Laptop Dell XPS 13"
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('nama') border-red-500 @enderror"
                        />
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kode/SKU -->
                    <div>
                        <label for="kode" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Kode/SKU <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="kode"
                            name="kode"
                            value="{{ old('kode', $barang->kode ?? '') }}"
                            required
                            placeholder="Contoh: SKU-001"
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kode') border-red-500 @enderror"
                        />
                        @error('kode')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            placeholder="Masukkan deskripsi lengkap barang..."
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('deskripsi') border-red-500 @enderror"
                        >{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Stock and Price Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-dollar-sign text-green-500"></i>
                    Stok & Harga
                </h3>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="stok"
                                name="stok"
                                value="{{ old('stok', $barang->stok ?? '0') }}"
                                required
                                min="0"
                                placeholder="0"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('stok') border-red-500 @enderror"
                            />
                            @error('stok')
                                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga', $barang->harga ?? '0') }}"
                                required
                                min="0"
                                placeholder="0"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('harga') border-red-500 @enderror"
                            />
                            @error('harga')
                                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                    <i class="fas fa-{{ isset($barang) ? 'save' : 'plus' }}"></i>
                    {{ isset($barang) ? 'Perbarui Barang' : 'Tambah Barang' }}
                </button>
                <a href="{{ route('barang.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Tips Card -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h4 class="font-bold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb"></i>
                Tips Input Data
            </h4>
            <ul class="space-y-3 text-sm text-blue-800 dark:text-blue-200">
                <li class="flex gap-2">
                    <span class="text-blue-500 mt-1">→</span>
                    <span>Gunakan kode SKU yang unik dan mudah diingat</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 mt-1">→</span>
                    <span>Masukkan harga jual, bukan harga beli</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 mt-1">→</span>
                    <span>Deskripsi membantu identifikasi barang yang cepat</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 mt-1">→</span>
                    <span>Perbarui stok setiap kali ada transaksi</span>
                </li>
            </ul>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-4">Aksi Cepat</h4>
            <div class="space-y-2">
                <a href="{{ route('barang.index') }}" class="block w-full px-4 py-2 text-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium transition-colors text-sm">
                    ← Kembali ke Daftar
                </a>
                <a href="{{ route('barang.create') }}" class="block w-full px-4 py-2 text-center bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg font-medium transition-colors text-sm">
                    + Tambah Barang Baru
                </a>
            </div>
        </div>

        <!-- Validation Status -->
        <div class="bg-gradient-to-br from-green-50 dark:from-green-900/20 to-emerald-50 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
            <h4 class="font-bold text-green-900 dark:text-green-300 mb-3 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                Validasi Form
            </h4>
            <div id="validationStatus" class="space-y-2 text-sm text-green-800 dark:text-green-200">
                <p class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full border-2 border-green-400 flex items-center justify-center" id="namaStatus">✓</span>
                    Nama barang
                </p>
                <p class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full border-2 border-green-400 flex items-center justify-center" id="kodeStatus">✓</span>
                    Kode/SKU
                </p>
                <p class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full border-2 border-green-400 flex items-center justify-center" id="hargaStatus">✓</span>
                    Harga
                </p>
                <p class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full border-2 border-green-400 flex items-center justify-center" id="stokStatus">✓</span>
                    Stok
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple form validation indicator
    const form = document.querySelector('form');
    const inputs = {
        nama: document.getElementById('nama'),
        kode: document.getElementById('kode'),
        harga: document.getElementById('harga'),
        stok: document.getElementById('stok'),
    };

    Object.entries(inputs).forEach(([key, input]) => {
        input.addEventListener('change', () => {
            const status = document.getElementById(`${key}Status`);
            if (input.value.trim()) {
                status.classList.remove('border-red-400');
                status.classList.add('border-green-400', 'bg-green-400', 'text-white');
                status.textContent = '✓';
            }
        });
    });
</script>
@endsection
