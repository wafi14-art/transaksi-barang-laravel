@extends('layouts.app-enterprise')

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
        <p class="text-slate-600 dark:text-slate-400 mt-1">Enterprise inventory table dengan search, sort, bulk actions, dan inline styling premium</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('barang.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Tambah Barang
        </a>
    </div>
</div>

<!-- Toolbar -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari barang..."
                    class="w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                >
            </div>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Tip: cari berdasarkan nama, kode/SKU, atau kategori.</p>
        </div>

        <!-- Filter chips (visual only - request-based search already handled in controller) -->
        <div class="flex flex-wrap gap-2">
            @php
                $chips = [
                    ['key' => 'stok_kritis', 'label' => 'Stok Kritis', 'active' => request('chip') === 'stok_kritis'],
                    ['key' => 'tersedia', 'label' => 'Tersedia', 'active' => request('chip') === 'tersedia'],
                ];
            @endphp
            @foreach($chips as $chip)
                <a
                    href="?search={{ urlencode(request('search')) }}&chip={{ $chip['key'] }}"
                    class="px-3 py-1 rounded-full text-xs font-semibold border transition-colors {{ $chip['active'] ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-50 dark:bg-slate-900/20 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
                >{{ $chip['label'] }}</a>
            @endforeach
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2">
            <button type="button" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2" onclick="showToast('Filter premium (UI) — gunakan search untuk hasil nyata.','info')">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <button type="button" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2" onclick="showToast('Export demo UI — belum diimplementasi.','info')">
                <i class="fas fa-download"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Bulk actions bar -->
    <div class="mt-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Bulk</span>
            <button type="button" class="px-3 py-2 rounded-lg text-sm bg-slate-100 dark:bg-slate-700/40 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" onclick="showToast('Bulk actions UI — perlu endpoint untuk update massal.','info')">
                <i class="fas fa-trash mr-2"></i>Hapus terpilih
            </button>
            <button type="button" class="px-3 py-2 rounded-lg text-sm bg-slate-100 dark:bg-slate-700/40 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" onclick="showToast('Bulk actions UI — perlu endpoint untuk update massal.','info')">
                <i class="fas fa-tag mr-2"></i>Mark status
            </button>
        </div>
        <div class="text-xs text-slate-500 dark:text-slate-400">
            Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $barang->count() }}</span> dari halaman ini
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft overflow-hidden">
    <!-- Desktop View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400 w-12">
                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600" aria-label="Select all" onclick="toggleAllCheckboxes(this)">
                    </th>
                    @php
                        $sort = request('sort');
                        $dir = request('dir', 'desc');
                        $toggleDir = function($col) use ($sort,$dir){
                            return ($sort === $col && $dir === 'asc') ? 'desc' : 'asc';
                        };
                        $urlFor = function($col) use ($toggleDir){
                            return '?search=' . urlencode(request('search')) . '&sort=' . urlencode($col) . '&dir=' . urlencode($toggleDir($col));
                        };
                    @endphp
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">
                        <a class="inline-flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400" href="{{ $urlFor('nama_barang') }}">
                            Nama Barang
                            @if($sort === 'nama_barang')
                                <i class="fas fa-arrow-{{ $dir === 'asc' ? 'up' : 'down' }} text-slate-400"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">
                        <a class="inline-flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400" href="{{ $urlFor('kode_barang') }}">
                            SKU
                            @if($sort === 'kode_barang')
                                <i class="fas fa-arrow-{{ $dir === 'asc' ? 'up' : 'down' }} text-slate-400"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">
                        <a class="inline-flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400" href="{{ $urlFor('stok') }}">
                            Stok
                            @if($sort === 'stok')
                                <i class="fas fa-arrow-{{ $dir === 'asc' ? 'up' : 'down' }} text-slate-400"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Harga</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600 dark:text-slate-400 w-36">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($barang as $item)
                    @php
                        $stok = (int) ($item->stok ?? 0);
                        $status = $stok > 10 ? 'Normal' : ($stok > 5 ? 'Rendah' : 'Kritis');
                        $badge = $stok > 10 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : ($stok > 5 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300');
                        $dot = $stok > 10 ? 'bg-green-500' : ($stok > 5 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp

                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 row-checkbox" aria-label="Select row" data-id="{{ $item->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $item->nama_barang }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->deskripsi ? (mb_strlen($item->deskripsi) > 46 ? mb_substr($item->deskripsi, 0, 46).'…' : $item->deskripsi) : '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 dark:bg-slate-700/50 px-3 py-1 rounded text-sm font-medium text-slate-700 dark:text-slate-200">{{ $item->kode_barang ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $stok }}</span>
                                <span class="inline-flex items-center gap-2 px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                                    {{ $status }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                                {{ $stok > 0 ? 'Tersedia' : 'Habis' }}
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
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                                    <i class="fas fa-inbox text-3xl text-slate-400"></i>
                                </div>
                                <p class="text-slate-700 dark:text-slate-200 font-semibold">Belum ada data barang</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Mulai dengan menambahkan barang pertama Anda.</p>
                                <a href="{{ route('barang.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
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

    <!-- Mobile View -->
    <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-700">
        @forelse($barang as $item)
            @php
                $stok = (int) ($item->stok ?? 0);
                $status = $stok > 10 ? 'Normal' : ($stok > 5 ? 'Rendah' : 'Kritis');
                $badge = $stok > 10 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : ($stok > 5 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300');
                $dot = $stok > 10 ? 'bg-green-500' : ($stok > 5 ? 'bg-yellow-500' : 'bg-red-500');
            @endphp
            <div class="p-4 space-y-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 row-checkbox" aria-label="Select row" data-id="{{ $item->id }}">
                            <p class="font-semibold text-slate-900 dark:text-white truncate">{{ $item->nama_barang }}</p>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $item->kode_barang ?? '-' }} • {{ $item->kategori ?? '-' }}</p>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                        <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                        {{ $status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Stok</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $stok }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-slate-400">Harga</p>
                        <p class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <a href="{{ route('barang.edit', $item->id) }}" class="flex-1 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors text-center">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="w-full px-3 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors text-center">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-3xl text-slate-400 mb-2 block"></i>
                <p class="text-slate-500 dark:text-slate-400 font-semibold">Belum ada data barang</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tambah barang pertama Anda untuk mulai.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($barang->hasPages())
    <div class="mt-6 flex justify-center">
        <div class="flex items-center gap-2 bg-slate-50 dark:bg-slate-900/30 p-2 rounded-xl border border-slate-200 dark:border-slate-800">
            {{ $barang->links() }}
        </div>
    </div>
@endif

<script>
    function toggleAllCheckboxes(master) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    // Toast helper fallback
    if (!window.showToast) {
        window.showToast = function (msg) { alert(msg); };
    }
</script>
@endsection

