@extends('layouts.app-modern')

@section('title', 'Barang - InventoryPro')
@section('breadcrumb', 'Barang')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
            <i class="fas fa-boxes text-blue-600 dark:text-blue-400"></i>
            Data Barang
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola dan pantau semua barang di gudang</p>
    </div>
    <a href="{{ route('barang.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah Barang
    </a>
</div>

<!-- Filters and Search -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" placeholder="Cari barang..." class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <i class="fas fa-filter"></i>
            Filter
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
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">
                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600" />
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Nama Barang</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">SKU</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Stok</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Harga</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($barang as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600" />
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->deskripsi ? substr($item->deskripsi, 0, 40) . '...' : '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            <span class="bg-slate-100 dark:bg-slate-700/50 px-3 py-1 rounded text-sm font-medium">{{ $item->kode ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $item->stok }}</span>
                                <span class="text-xs {{ $item->stok > 10 ? 'text-green-600 dark:text-green-400' : ($item->stok > 5 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $item->stok > 10 ? 'Normal' : ($item->stok > 5 ? 'Rendah' : 'Kritis') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $item->stok > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                <span class="w-2 h-2 rounded-full {{ $item->stok > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('barang.edit', $item->id) }}" class="p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="p-2 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-slate-400"></i>
                                <p class="text-slate-500 dark:text-slate-400">Belum ada data barang</p>
                                <a href="{{ route('barang.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mt-2">Tambah barang sekarang →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($barang as $item)
            <div class="p-4 space-y-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->kode ?? '-' }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $item->stok > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $item->stok > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Stok</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->stok }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Harga</p>
                        <p class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <a href="{{ route('barang.edit', $item->id) }}" class="flex-1 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors text-center">Edit</a>
                    <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="w-full px-3 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-3xl text-slate-400 mb-2 block"></i>
                <p class="text-slate-500 dark:text-slate-400">Belum ada data barang</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($barang->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $barang->links() }}
    </div>
@endif
@endsection
