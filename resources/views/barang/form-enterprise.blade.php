@extends('layouts.app-enterprise')

@section('title', isset($barang) ? 'Edit Barang - InventoryPro Enterprise' : 'Tambah Barang - InventoryPro Enterprise')
@section('breadcrumb', isset($barang) ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-2">
        <i class="fas fa-{{ isset($barang) ? 'edit' : 'plus' }} text-blue-600 dark:text-blue-400"></i>
        {{ isset($barang) ? 'Edit Barang' : 'Tambah Barang Baru' }}
    </h1>
    <p class="text-slate-600 dark:text-slate-400">{{ isset($barang) ? 'Perbarui informasi barang yang sudah ada' : 'Tambahkan barang baru ke dalam sistem inventory' }}</p>
</div>

<!-- Form Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form id="barangForm" action="{{ isset($barang) ? route('barang.update', $barang->id) : route('barang.store') }}" method="POST" class="space-y-6">
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
                    <!-- Floating Label Input - Nama -->
                    <div class="floating-label-group relative">
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama', $barang->nama ?? '') }}"
                            placeholder=" "
                            required
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-950 transition-all peer @error('nama') border-red-500 @enderror"
                            data-field-name="Nama Barang"
                        />
                        <label for="nama" class="absolute top-3 left-4 text-slate-600 dark:text-slate-400 text-sm font-medium pointer-events-none transition-all duration-200 peer-focus:-translate-y-6 peer-focus:text-xs peer-focus:text-blue-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU Input with Live Validation -->
                    <div class="floating-label-group relative">
                        <input
                            type="text"
                            id="kode"
                            name="kode"
                            value="{{ old('kode', $barang->kode ?? '') }}"
                            placeholder=" "
                            required
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-950 transition-all peer @error('kode') border-red-500 @enderror"
                            data-field-name="Kode/SKU"
                        />
                        <label for="kode" class="absolute top-3 left-4 text-slate-600 dark:text-slate-400 text-sm font-medium pointer-events-none transition-all duration-200 peer-focus:-translate-y-6 peer-focus:text-xs peer-focus:text-blue-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base">
                            Kode/SKU <span class="text-red-500">*</span>
                        </label>
                        <div id="skuStatus" class="absolute right-4 top-3 hidden text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        @error('kode')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="floating-label-group relative">
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder=" "
                            rows="3"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-950 transition-all resize-none peer @error('deskripsi') border-red-500 @enderror"
                            data-field-name="Deskripsi"
                        >{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>
                        <label for="deskripsi" class="absolute top-3 left-4 text-slate-600 dark:text-slate-400 text-sm font-medium pointer-events-none transition-all duration-200 peer-focus:-translate-y-6 peer-focus:text-xs peer-focus:text-blue-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base">
                            Deskripsi
                        </label>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Stock & Pricing Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-dollar-sign text-green-500"></i>
                    Stok & Harga
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Stok with Increment/Decrement -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Stok <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <button type="button" class="p-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors" onclick="decrementStok()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input
                                type="number"
                                id="stok"
                                name="stok"
                                value="{{ old('stok', $barang->stok ?? '0') }}"
                                required
                                min="0"
                                class="flex-1 px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-center text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all @error('stok') border-red-500 @enderror"
                            />
                            <button type="button" class="p-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors" onclick="incrementStok()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga with Currency Format -->
                    <div class="floating-label-group relative">
                        <div class="absolute left-4 top-11 text-slate-600 dark:text-slate-400 font-medium">Rp</div>
                        <input
                            type="text"
                            id="harga"
                            name="harga"
                            value="{{ old('harga', $barang->harga ?? '0') }}"
                            placeholder=" "
                            required
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-950 transition-all peer @error('harga') border-red-500 @enderror"
                            data-field-name="Harga"
                        />
                        <label for="harga" class="absolute top-3 left-12 text-slate-600 dark:text-slate-400 text-sm font-medium pointer-events-none transition-all duration-200 peer-focus:-translate-y-6 peer-focus:text-xs peer-focus:text-blue-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
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

    <!-- Sidebar Info & Tips -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Auto-save Status -->
        <div id="autoSaveStatus" class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 border-2 border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Auto-saved</p>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400" id="lastSaved">Baru saja</p>
        </div>

        <!-- Validation Checklist -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h4 class="font-bold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2">
                <i class="fas fa-clipboard-check"></i>
                Validasi Form
            </h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded border-2 border-blue-300 flex items-center justify-center text-xs" id="namaCheck">○</span>
                    <span class="text-blue-800 dark:text-blue-200">Nama barang</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded border-2 border-blue-300 flex items-center justify-center text-xs" id="kodeCheck">○</span>
                    <span class="text-blue-800 dark:text-blue-200">Kode/SKU</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded border-2 border-blue-300 flex items-center justify-center text-xs" id="hargaCheck">○</span>
                    <span class="text-blue-800 dark:text-blue-200">Harga</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded border-2 border-blue-300 flex items-center justify-center text-xs" id="stokCheck">○</span>
                    <span class="text-blue-800 dark:text-blue-200">Stok</span>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6">
            <h4 class="font-bold text-amber-900 dark:text-amber-300 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb"></i>
                Tips & Trik
            </h4>
            <ul class="space-y-3 text-sm text-amber-800 dark:text-amber-200">
                <li class="flex gap-2">
                    <span class="text-amber-500 mt-1">💡</span>
                    <span>Gunakan SKU yang mudah diingat dan konsisten</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-amber-500 mt-1">💡</span>
                    <span>Harga otomatis diformat dengan pemisah ribuan</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-amber-500 mt-1">💡</span>
                    <span>Draft Anda disimpan otomatis setiap 10 detik</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-amber-500 mt-1">💡</span>
                    <span>Tab: pindah field | Shift+Tab: mundur</span>
                </li>
            </ul>
        </div>

        <!-- Keyboard Shortcuts -->
        <div class="bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs text-slate-600 dark:text-slate-400">
            <p class="font-semibold mb-2">Shortcut Keyboard:</p>
            <div class="space-y-1">
                <p><kbd class="px-2 py-1 bg-white dark:bg-slate-900 rounded border">Ctrl+S</kbd> Simpan</p>
                <p><kbd class="px-2 py-1 bg-white dark:bg-slate-900 rounded border">Esc</kbd> Kembali</p>
            </div>
        </div>
    </div>
</div>

<script>
// Currency Formatting
const hargaInput = document.getElementById('harga');
hargaInput?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    updateValidation();
});

// Stok Increment/Decrement
function incrementStok() {
    const input = document.getElementById('stok');
    input.value = parseInt(input.value || 0) + 1;
    updateValidation();
}

function decrementStok() {
    const input = document.getElementById('stok');
    const val = parseInt(input.value || 0);
    input.value = val > 0 ? val - 1 : 0;
    updateValidation();
}

// Real-time Validation
function updateValidation() {
    const fields = ['nama', 'kode', 'harga', 'stok'];
    fields.forEach(field => {
        const input = document.getElementById(field);
        const check = document.getElementById(`${field}Check`);
        if (input?.value?.trim()) {
            check.className = 'w-5 h-5 rounded border-2 border-green-400 bg-green-100 flex items-center justify-center text-xs text-green-600';
            check.innerHTML = '✓';
        } else {
            check.className = 'w-5 h-5 rounded border-2 border-blue-300 flex items-center justify-center text-xs';
            check.innerHTML = '○';
        }
    });
}

// Auto-save Draft
setInterval(() => {
    const data = new FormData(document.getElementById('barangForm'));
    localStorage.setItem('barangDraft', JSON.stringify(Object.fromEntries(data)));
    const now = new Date().toLocaleTimeString('id-ID');
    document.getElementById('lastSaved').textContent = `Disimpan pada ${now}`;
}, 10000);

// Keyboard Shortcuts
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('barangForm').submit();
    }
    if (e.key === 'Escape') {
        window.location.href = '{{ route("barang.index") }}';
    }
});

// Initialize validation
updateValidation();
</script>
@endsection
