@extends('layouts.app-modern')

@section('title', isset($pelanggan) ? 'Edit Pelanggan - InventoryPro' : 'Tambah Pelanggan - InventoryPro')
@section('breadcrumb', isset($pelanggan) ? 'Edit Pelanggan' : 'Tambah Pelanggan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-2">
        <i class="fas fa-{{ isset($pelanggan) ? 'edit' : 'plus' }} text-purple-600 dark:text-purple-400"></i>
        {{ isset($pelanggan) ? 'Edit Pelanggan' : 'Tambah Pelanggan Baru' }}
    </h1>
    <p class="text-slate-600 dark:text-slate-400">{{ isset($pelanggan) ? 'Ubah informasi pelanggan yang sudah ada' : 'Tambahkan pelanggan baru ke dalam sistem' }}</p>
</div>

<!-- Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ isset($pelanggan) ? route('pelanggan.update', $pelanggan->id) : route('pelanggan.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($pelanggan))
                @method('PUT')
            @endif

            <!-- Contact Information -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-user-circle text-purple-500"></i>
                    Informasi Kontak
                </h3>

                <div class="space-y-5">
                    <!-- Nama Pelanggan -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Nama Pelanggan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama', $pelanggan->nama ?? '') }}"
                            required
                            placeholder="Masukkan nama pelanggan"
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('nama') border-red-500 @enderror"
                        />
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $pelanggan->email ?? '') }}"
                                placeholder="nama@example.com"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                            />
                            @error('email')
                                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label for="telepon" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                id="telepon"
                                name="telepon"
                                value="{{ old('telepon', $pelanggan->telepon ?? '') }}"
                                required
                                placeholder="0812-3456-7890"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('telepon') border-red-500 @enderror"
                            />
                            @error('telepon')
                                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Alamat
                        </label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="4"
                            placeholder="Masukkan alamat lengkap pelanggan..."
                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none @error('alamat') border-red-500 @enderror"
                        >{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                    <i class="fas fa-{{ isset($pelanggan) ? 'save' : 'plus' }}"></i>
                    {{ isset($pelanggan) ? 'Perbarui Pelanggan' : 'Tambah Pelanggan' }}
                </button>
                <a href="{{ route('pelanggan.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Tips Card -->
        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-6">
            <h4 class="font-bold text-purple-900 dark:text-purple-300 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb"></i>
                Tips Input Data
            </h4>
            <ul class="space-y-3 text-sm text-purple-800 dark:text-purple-200">
                <li class="flex gap-2">
                    <span class="text-purple-500 mt-1">→</span>
                    <span>Pastikan nama pelanggan dan telepon terisi dengan benar</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-purple-500 mt-1">→</span>
                    <span>Email gunakan format yang valid (contoh: user@domain.com)</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-purple-500 mt-1">→</span>
                    <span>Alamat detail membantu pengiriman barang</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-purple-500 mt-1">→</span>
                    <span>Selalu perbarui data jika ada perubahan</span>
                </li>
            </ul>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-4">Aksi Cepat</h4>
            <div class="space-y-2">
                <a href="{{ route('pelanggan.index') }}" class="block w-full px-4 py-2 text-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium transition-colors text-sm">
                    ← Kembali ke Daftar
                </a>
                <a href="{{ route('pelanggan.create') }}" class="block w-full px-4 py-2 text-center bg-purple-100 dark:bg-purple-900/30 hover:bg-purple-200 dark:hover:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-lg font-medium transition-colors text-sm">
                    + Tambah Pelanggan Baru
                </a>
            </div>
        </div>

        <!-- Contact Methods -->
        <div class="bg-gradient-to-br from-slate-100 dark:from-slate-700 to-slate-50 dark:to-slate-800 rounded-xl p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                <i class="fas fa-phone"></i>
                Cara Kontak
            </h4>
            <div class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                <p class="flex items-center gap-2">
                    <i class="fas fa-envelope text-purple-500"></i>
                    Gunakan email untuk komunikasi formal
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-mobile-alt text-green-500"></i>
                    Gunakan telepon untuk follow-up cepat
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-map-pin text-red-500"></i>
                    Alamat untuk pengiriman barang
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
