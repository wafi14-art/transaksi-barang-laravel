@extends('layouts.app-modern')

@section('title', 'Pelanggan - InventoryPro')
@section('breadcrumb', 'Pelanggan')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
            <i class="fas fa-users text-purple-600 dark:text-purple-400"></i>
            Data Pelanggan
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola semua data pelanggan Anda</p>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah Pelanggan
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pelanggan</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ count($pelanggan) }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pelanggan Aktif</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $pelanggan->count() }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 card-hover">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Rata-rata Transaksi</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ count($pelanggan) > 0 ? round(($totalTransaksi ?? 0) / count($pelanggan)) : 0 }}</p>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" placeholder="Cari pelanggan..." class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
        </div>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <i class="fas fa-filter"></i>
            Filter
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
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Nama Pelanggan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Telepon</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Alamat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Bergabung</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($pelanggan as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $item->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $item->telepon ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $item->alamat ? substr($item->alamat, 0, 30) . '...' : '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('pelanggan.edit', $item->id) }}" class="p-2 hover:bg-purple-100 dark:hover:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" class="inline-block">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-slate-400"></i>
                                <p class="text-slate-500 dark:text-slate-400">Belum ada data pelanggan</p>
                                <a href="{{ route('pelanggan.create') }}" class="text-purple-600 dark:text-purple-400 hover:underline text-sm mt-2">Tambah pelanggan sekarang →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($pelanggan as $item)
            <div class="p-4 space-y-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Telepon</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Bergabung</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <a href="{{ route('pelanggan.edit', $item->id) }}" class="flex-1 px-3 py-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg text-sm font-medium hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors text-center">Edit</a>
                    <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="w-full px-3 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-3xl text-slate-400 mb-2 block"></i>
                <p class="text-slate-500 dark:text-slate-400">Belum ada data pelanggan</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($pelanggan->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $pelanggan->links() }}
    </div>
@endif
@endsection
