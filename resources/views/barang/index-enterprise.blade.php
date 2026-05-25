@extends('layouts.app-enterprise')

@section('title', 'Barang Management - InventoryPro Enterprise')
@section('breadcrumb', 'Barang')

@section('content')
<!-- Header with Actions -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
            <i class="fas fa-boxes text-blue-600 dark:text-blue-400"></i>
            Manajemen Barang
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola inventory dengan fitur advanced</p>
    </div>
    <a href="{{ route('barang.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah Barang
    </a>
</div>

<!-- Toolbar -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-4 mb-6 space-y-4">
    <!-- Search & Filters -->
    <div class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" id="searchTable" placeholder="Cari barang, SKU, atau kategori..." class="w-full pl-10 pr-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-sliders-h"></i>
            Filter
        </button>
        <button class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-download"></i>
            Export
        </button>
    </div>

    <!-- Filter Chips -->
    <div class="flex flex-wrap gap-2">
        <button class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors flex items-center gap-2">
            Stok > 0
            <i class="fas fa-times cursor-pointer"></i>
        </button>
        <button class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-full text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Tambah Filter
        </button>
    </div>

    <!-- Bulk Actions Bar (hidden by default) -->
    <div id="bulkActionsBar" class="hidden flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800/30">
        <span id="selectedCount" class="text-sm font-medium text-blue-700 dark:text-blue-300">0 dipilih</span>
        <div class="flex-1"></div>
        <button class="px-3 py-1 text-sm bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/70 rounded transition-colors">
            <i class="fas fa-download mr-1"></i>Export
        </button>
        <button class="px-3 py-1 text-sm bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/70 rounded transition-colors">
            <i class="fas fa-trash mr-1"></i>Hapus
        </button>
    </div>
</div>

<!-- Enhanced Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft overflow-hidden">
    <!-- Desktop Table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" class="select-all w-4 h-4 rounded border-slate-300 dark:border-slate-600 cursor-pointer">
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800">
                        <div class="flex items-center gap-2">
                            Nama Barang
                            <i class="fas fa-arrow-down-up text-xs opacity-50"></i>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800">
                        <div class="flex items-center gap-2">
                            SKU
                            <i class="fas fa-arrow-down-up text-xs opacity-50"></i>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800">
                        <div class="flex items-center gap-2">
                            Stok
                            <i class="fas fa-arrow-down-up text-xs opacity-50"></i>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800">
                        <div class="flex items-center gap-2">
                            Harga
                            <i class="fas fa-arrow-down-up text-xs opacity-50"></i>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($barang as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="row-checkbox w-4 h-4 rounded border-slate-300 dark:border-slate-600 cursor-pointer" value="{{ $item->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->deskripsi ? substr($item->deskripsi, 0, 40) : '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded text-sm font-medium text-slate-700 dark:text-slate-300">{{ $item->kode }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $item->stok }}</span>
                                <span class="text-xs font-semibold {{ $item->stok > 10 ? 'text-green-600 dark:text-green-400' : ($item->stok > 5 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
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
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('barang.edit', $item->id) }}" class="p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="p-2 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" title="Hapus" onclick="confirmDelete({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <!-- Empty State -->
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700/50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-inbox text-3xl text-slate-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Belum Ada Data Barang</h3>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Mulai dengan menambahkan barang pertama Anda</p>
                                </div>
                                <a href="{{ route('barang.create') }}" class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    Tambah Barang
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards View -->
    <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($barang as $item)
            <div class="p-4 space-y-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3 flex-1">
                        <input type="checkbox" class="row-checkbox w-4 h-4 rounded border-slate-300 dark:border-slate-600" value="{{ $item->id }}">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->kode }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $item->stok > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $item->stok > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Stok</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->stok }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Harga</p>
                        <p class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Status</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->stok > 10 ? 'Normal' : ($item->stok > 5 ? 'Rendah' : 'Kritis') }}</p>
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
                <i class="fas fa-inbox text-4xl text-slate-400 mb-2 block"></i>
                <p class="text-slate-500 dark:text-slate-400">Belum ada data barang</p>
                <a href="{{ route('barang.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mt-2 inline-block">Tambah barang sekarang →</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination with Advanced Controls -->
@if($barang->hasPages())
    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="text-sm text-slate-600 dark:text-slate-400">
            Menampilkan <span class="font-semibold">{{ $barang->firstItem() }}</span> hingga <span class="font-semibold">{{ $barang->lastItem() }}</span> dari <span class="font-semibold">{{ $barang->total() }}</span> barang
        </div>
        <div class="flex justify-center">
            {{ $barang->links() }}
        </div>
    </div>
@endif

<script>
// Checkbox Selection
document.querySelector('.select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkActionsBar();
});

document.querySelectorAll('.row-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkActionsBar);
});

function updateBulkActionsBar() {
    const selected = document.querySelectorAll('.row-checkbox:checked').length;
    const bar = document.getElementById('bulkActionsBar');
    const count = document.getElementById('selectedCount');
    
    if (selected > 0) {
        bar.classList.remove('hidden');
        count.textContent = `${selected} dipilih`;
    } else {
        bar.classList.add('hidden');
    }
}

function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus barang ini?')) {
        // Handle delete
    }
}

// Search Filter
document.getElementById('searchTable')?.addEventListener('keyup', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>
@endsection
