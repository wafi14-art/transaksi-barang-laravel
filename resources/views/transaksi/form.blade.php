<<<<<<< HEAD
BEGIN
NEW CONTENT
END
=======
@extends('layouts.app-modern')

@section('title', 'POS Transaksi - eProduct')
@section('breadcrumb', 'Transaksi POS')

@section('content')
<div x-data="posDashboard(@json($barang), @json($pelanggan))" x-init="init();" class="space-y-6">
    <form x-ref="posForm" method="POST" action="{{ route('transaksi.store') }}" @submit.prevent="submitTransaction()" class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)_420px]">
        <!-- Quick Sidebar -->
        <section class="hidden lg:flex flex-col gap-6">
            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6 overflow-hidden">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.22em] text-slate-500">POS Inventory</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-900">Kasir eProduct</h2>
                    </div>
                    <div class="w-14 h-14 rounded-3xl bg-cyan-600/15 text-cyan-600 flex items-center justify-center shadow-soft">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    </div>
                </div>
                <p class="mt-4 text-slate-500 leading-7">Desain UI modern serupa Shopify POS dan dashboard SaaS untuk transaksi retail, checkout cepat, dan laporan ringkas.</p>
                <div class="mt-6 grid gap-3">
                    <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200 text-slate-800">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Produk Tersedia</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $barang->count() }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200 text-slate-800">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pelanggan Aktif</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $pelanggan->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-cyan-800 to-cyan-700 text-white shadow-soft-xl ring-1 ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-3xl bg-white/10 flex items-center justify-center">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200/75">Smart Checkout</p>
                        <p class="mt-2 text-xl font-semibold">Realtime Ringkasan</p>
                    </div>
                </div>
                <ul class="mt-6 space-y-3 text-sm text-slate-200">
                    <li class="rounded-3xl bg-white/10 p-4">Inventory up to date dengan foto dan stok.</li>
                    <li class="rounded-3xl bg-white/10 p-4">Kalkulasi subtotal, diskon, dan pajak otomatis.</li>
                    <li class="rounded-3xl bg-white/10 p-4">Checkout yang terasa premium dan responsif.</li>
                </ul>
            </div>
        </section>

        <!-- Product Selection -->
        <main class="space-y-6">
            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-cyan-600">Pilih Barang</p>
                        <h2 class="mt-3 text-3xl font-semibold text-slate-900">POS Inventory Modern</h2>
                        <p class="mt-2 text-slate-500 max-w-2xl">Cari, filter, dan tambahkan barang sembako ke keranjang belanja dengan pengalaman dashboard enterprise.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="button" @click="scanBarcode()" class="inline-flex items-center justify-center gap-2 rounded-3xl bg-slate-900 text-white px-5 py-3 text-sm font-semibold shadow-soft hover:bg-slate-800 transition">
                            <i data-lucide="barcode" class="w-4 h-4"></i>
                            Scan Barcode
                        </button>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Stok Segera</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900" x-text="filteredProducts.length + ' produk'">20 produk</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 lg:grid-cols-[1fr_340px]">
                    <div class="relative">
                        <input x-model.debounce.250ms="search" type="text" placeholder="Cari barang, gula, beras, kopi..." class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-cyan-400 focus:ring-4 focus:ring-cyan-100" />
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Filter Kategori</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" @click="activeCategory = 'Semua'" :class="activeCategory === 'Semua' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Semua</button>
                            <button type="button" @click="activeCategory = 'Beras & Tepung'" :class="activeCategory === 'Beras & Tepung' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Beras & Tepung</button>
                            <button type="button" @click="activeCategory = 'Minuman'" :class="activeCategory === 'Minuman' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Minuman</button>
                            <button type="button" @click="activeCategory = 'Makanan'" :class="activeCategory === 'Makanan' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Makanan</button>
                            <button type="button" @click="activeCategory = 'Bumbu & Dapur'" :class="activeCategory === 'Bumbu & Dapur' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Bumbu & Dapur</button>
                            <button type="button" @click="activeCategory = 'Kebersihan'" :class="activeCategory === 'Kebersihan' ? 'bg-cyan-600 text-white shadow-soft-lg' : 'bg-white text-slate-600 hover:bg-slate-100'" class="rounded-full px-4 py-2 text-sm transition">Kebersihan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Grid Produk</p>
                        <h3 class="mt-2 text-xl font-semibold text-slate-900">Tambah barang ke transaksi</h3>
                    </div>
                    <div class="text-sm text-slate-500">Hover dan pilih untuk menambahkan ke keranjang.</div>
                </div>

                <div x-show="loading" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <template x-for="n in 6" :key="n">
                        <div class="rounded-3xl border border-slate-200 bg-slate-100 p-4 animate-pulse"></div>
                    </template>
                </div>

                <div x-show="!loading" class="grid gap-3 sm:gap-4 sm:grid-cols-2 xl:grid-cols-3"> 

                    <template x-for="product in filteredProducts" :key="product.id">
                        <button
                            type="button"
                            @click="addToCart(product); selectedProductId = product.id"
                            :class="selectedProductId === product.id
                                ? 'ring-2 ring-cyan-300/80 border-cyan-300/70 bg-cyan-50/60 shadow-soft-xl'
                                : 'border-slate-200 bg-slate-50 shadow-soft'
                            "
                            class="group w-full text-left rounded-[2rem] border p-4 transition duration-300 hover:-translate-y-2 hover:shadow-soft-xl hover:border-cyan-300/60 active:translate-y-0 focus:outline-none">
                            <div class="relative overflow-hidden rounded-[1.75rem] bg-slate-100 shadow-inner">
                                <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent pointer-events-none"></div>

                                <!-- Cover image (larger) -->
                                <div class="relative aspect-[5/4]">
                                    <img
                                        :src="product.thumbnail"
                                        alt=""
                                        class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
                                        @error="event.target.src = '{{ asset('images/products/fallback.png') }}'" />

                                    <!-- Category badge -->
                                    <div class="absolute left-4 top-4 rounded-full bg-white/90 backdrop-blur px-3 py-1 text-[11px] font-semibold text-slate-700 shadow-sm">
                                        <span class="uppercase tracking-[0.16em] text-slate-500" x-text="product.category"></span>
                                    </div>

                                    <!-- Stock badge -->
                                    <div
                                        class="absolute right-4 top-4 rounded-full px-3 py-1 text-[11px] font-semibold shadow-sm backdrop-blur"
                                        :class="product.stock <= 5 ? 'bg-rose-50 text-rose-700 border border-rose-200/80' : 'bg-white text-slate-700 border border-slate-200/80'">
                                        Stok <span x-text="product.stock"></span>
                                    </div>

                                    <!-- Hover Add CTA (premium, shown on hover; on mobile via selected state) -->
                                    <div class="absolute inset-x-0 bottom-0 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="rounded-full bg-white/85 backdrop-blur px-4 py-2">
                                                <span class="text-sm font-semibold text-slate-900" x-text="product.formattedPrice"></span>
                                            </div>

                                            <span
                                                class="inline-flex items-center gap-2 rounded-full bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-300 shadow-soft-lg"
                                                :class="selectedProductId === product.id ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0'">
                                                Tambah
                                                <i data-lucide="plus" class="w-4 h-4"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="mt-4 space-y-2">
                                <h4 class="text-[15px] sm:text-base font-semibold text-slate-900 leading-6" x-text="product.name"></h4>
                                <p class="text-sm leading-5 text-slate-500 line-clamp-2" x-text="product.description"></p>
                            </div>

                            <!-- Mobile hint / subtle footer -->
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="text-xs uppercase tracking-[0.22em] text-slate-400">Tap untuk pilih</span>
                                <span class="text-xs text-slate-400" :class="product.stock <= 0 ? 'text-rose-600' : 'text-slate-400'" x-text="product.stock <= 0 ? 'Habis' : 'Tersedia'"></span>
                            </div>
                        </button>
                    </template>
                </div>

                <div x-show="!loading && filteredProducts.length === 0" class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center text-slate-500">
                    <i data-lucide="search" class="mx-auto h-10 w-10 text-slate-400"></i>
                    <p class="mt-4 text-lg font-semibold">Tidak ada produk ditemukan</p>
                    <p class="mt-2 text-sm">Ubah kata kunci atau kategori untuk menemukan barang lain.</p>
                </div>
            </div>
        </main>

        <!-- Shopping Cart -->
        <aside class="space-y-6">
            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6 sticky top-4 z-10">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Keranjang Belanja</p>
                        <h3 class="mt-2 text-2xl font-semibold text-slate-900">Checkout Sekarang</h3>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-4 py-2 text-sm font-semibold text-cyan-700">
                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                        <span data-cart-badge :class="cartBadgeBump ? 'animate-bounce' : ''" x-text="cartItems.length + ' item'"></span>
                    </div>
                </div>

                <p class="mt-4 text-slate-500">Ringkasan transaksi otomatis, didukung animasi halus dan status stok real-time.</p>
            </div>

            <!-- micro toast -->
            <div x-show="toastVisible" x-cloak class="fixed right-4 top-20 z-50">
                <div class="bg-slate-950/95 text-white px-4 py-3 rounded-2xl shadow-soft-xl border border-white/10 flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-300"></i>
                    <p class="text-sm font-semibold" x-text="toastMessage"></p>
                </div>
            </div>

            <!-- fly token -->
            <template x-if="flyToken.visible">
                <div
                    class="fixed z-50 pointer-events-none"
                    :style="`left:${flyToken.x}px; top:${flyToken.y}px;`"
                >
                    <div
                        class="w-10 h-10 rounded-full bg-cyan-600/90 shadow-soft-xl flex items-center justify-center text-white font-bold text-sm"
                        :style="`transform: translate(-50%,-50%);`"
                    >
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </div>
                    <div
                        class="absolute inset-0"
                        :style="`transition: transform 550ms ease-out; transform: translate(${flyToken.toX - flyToken.x}px, ${flyToken.toY - flyToken.y}px) scale(0.7);`"
                    ></div>
                </div>
            </template>

            <div class="rounded-[2rem] bg-white shadow-soft-xl ring-1 ring-slate-200/70 p-6">
                <template x-if="cartItems.length === 0">
                    <div class="text-center py-20">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-slate-100 text-cyan-600">
                            <i data-lucide="shopping-bag" class="w-10 h-10"></i>
                        </div>
                        <h4 class="mt-6 text-xl font-semibold text-slate-900">Keranjang kosong</h4>
                        <p class="mt-2 text-sm text-slate-500">Tambahkan produk untuk melihat ringkasan transaksi secara realtime.</p>
                    </div>
                </template>

                <template x-if="cartItems.length > 0">
                    <div class="space-y-4">
                        <div class="space-y-4">
                            <template x-for="item in cartItems" :key="item.id">
                                <div class="rounded-3xl border border-slate-200 p-4 shadow-sm transition hover:border-cyan-300/60">
                                    <div class="flex items-center gap-4">
                                        <img :src="item.thumbnail" alt="" class="h-16 w-16 rounded-3xl object-cover" @error="event.target.src = '{{ asset('images/products/fallback.png') }}'" />
                                        <div class="min-w-0 flex-1">
                                            <h5 class="text-sm font-semibold text-slate-900" x-text="item.name"></h5>
                                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400" x-text="item.category"></p>
                                            <p class="mt-2 text-sm text-slate-500">Rp <span x-text="Intl.NumberFormat('id-ID').format(item.price)"></span></p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 rounded-full bg-slate-100 p-2">
                                            <button type="button" @click="changeQuantity(item, -1)" class="rounded-full bg-white p-2 text-slate-600 hover:bg-slate-200 transition"><i data-lucide="minus" class="w-4 h-4"></i></button>
                                            <span class="w-12 text-center font-semibold text-slate-900" x-text="item.quantity"></span>
                                            <button type="button" @click="changeQuantity(item, 1)" class="rounded-full bg-white p-2 text-slate-600 hover:bg-slate-200 transition"><i data-lucide="plus" class="w-4 h-4"></i></button>
                                        </div>
                                        <button type="button" @click="removeFromCart(item)" class="text-slate-500 hover:text-rose-600 transition"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                            <div class="grid gap-3">
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Subtotal</span>
                                    <strong>Rp <span x-text="Intl.NumberFormat('id-ID').format(subtotal)"></span></strong>
                                </div>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Diskon 3%</span>
                                    <strong>- Rp <span x-text="Intl.NumberFormat('id-ID').format(discount)"></span></strong>
                                </div>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Pajak 11%</span>
                                    <strong>Rp <span x-text="Intl.NumberFormat('id-ID').format(tax)"></span></strong>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-white p-5 border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between text-sm uppercase tracking-[0.24em] text-slate-500">
                                <span>Total Bayar</span>
                                <span class="text-2xl font-semibold text-slate-900">Rp <span x-text="Intl.NumberFormat('id-ID').format(total)"></span></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Pelanggan</label>
                                <select x-model="selectedCustomerId" name="pelanggan_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-cyan-400 focus:ring-4 focus:ring-cyan-100">
                                    <template x-for="customer in customers" :key="customer.id">
                                        <option :value="customer.id" x-text="customer.nama"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Nominal Bayar</label>
                                <input type="number" x-model.number="amountPaid" name="bayar" min="0" step="1000" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-cyan-400 focus:ring-4 focus:ring-cyan-100" placeholder="Masukkan nominal bayar" />
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200 text-slate-700">
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Estimasi Kembalian</span>
                                    <span class="font-semibold text-slate-900">Rp <span x-text="Intl.NumberFormat('id-ID').format(change)"></span></span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Jika bayar kurang, nilai akan otomatis menjadi 0.</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="rounded-3xl bg-slate-950/95 p-4 text-white shadow-soft-lg">
                                <p class="text-xs uppercase tracking-[0.24em] text-cyan-300">Enterprise UX</p>
                                <p class="mt-2 text-sm leading-6 text-slate-100">Desain dashboard modern, responsif, dan siap untuk kasir digital dengan feel premium.</p>
                            </div>
                            <button type="submit" class="w-full rounded-3xl bg-gradient-to-r from-cyan-600 to-slate-900 px-6 py-4 text-sm font-semibold text-white shadow-soft-lg transition hover:from-cyan-700 hover:to-slate-800">Simpan Transaksi</button>
                        </div>
                    </div>
                </template>
            </div>
        </aside>

        <template x-for="item in cartItems" :key="item.id">
            <input type="hidden" name="barang_id[]" :value="item.id">
            <input type="hidden" name="jumlah[]" :value="item.quantity">
        </template>

        @csrf
    </form>
</div>

<script>
    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function posDashboard(products, customers) {
        return {
            products: products.map(product => ({
                ...product,
                price: Number(product.harga_jual),
                stock: Number(product.stok),
                formattedPrice: 'Rp ' + formatCurrency(Number(product.harga_jual)),
                description: product.deskripsi || 'Barang sembako berkualitas tinggi untuk kebutuhan toko modern.',
                category: product.kategori,
                image: product.image || @json(asset('images/products/fallback.png')),
                thumbnail: product.thumbnail || product.image || @json(asset('images/products/fallback.png')),
            })),
            customers: customers,
            search: '',
            activeCategory: 'Semua',
            selectedCustomerId: customers.length ? customers[0].id : null,
            amountPaid: 0,
            loading: true,
            selectedProductId: null,
            cartItems: [],

            init() {
                setTimeout(() => this.loading = false, 420);
            },

            get filteredProducts() {
                return this.products.filter(product => {
                    const matchCategory = this.activeCategory === 'Semua' || product.kategori === this.activeCategory;
                    const searchTerm = this.search.toLowerCase();
                    const matchSearch = !searchTerm || product.nama_barang.toLowerCase().includes(searchTerm) || product.kategori.toLowerCase().includes(searchTerm);
                    return matchCategory && matchSearch;
                });
            },

            get subtotal() {
                return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
            },

            get discount() {
                return Math.round(this.subtotal * 0.03);
            },

            get tax() {
                return Math.round((this.subtotal - this.discount) * 0.11);
            },

            get total() {
                return this.subtotal - this.discount + this.tax;
            },

            get change() {
                return this.amountPaid > this.total ? this.amountPaid - this.total : 0;
            },

            addToCart(product) {
                const existing = this.cartItems.find(item => item.id === product.id);

                this.selectedProductId = product.id;
                if (product.stock <= 0) return;

                if (existing) {
                    // microinteraction untuk qty bertambah
                    this.triggerCartMicroInteraction(product, true);

                    if (existing.quantity < product.stock) {
                        existing.quantity += 1;
                    }
                    return;
                }

                // microinteraction untuk item baru
                this.triggerCartMicroInteraction(product, false);

                this.cartItems.push({
                    id: product.id,
                    name: product.nama_barang,
                    category: product.kategori,
                    price: product.price,
                    quantity: 1,
                    stock: product.stock,
                    thumbnail: product.thumbnail,
                });
            },

            removeFromCart(item) {
                this.cartItems = this.cartItems.filter(product => product.id !== item.id);
            },

            changeQuantity(item, delta) {
                const target = this.cartItems.find(product => product.id === item.id);
                if (!target) return;
                const next = target.quantity + delta;
                target.quantity = Math.max(1, Math.min(target.stock, next));
            },

            scanBarcode() {
                const code = prompt('Masukkan kode produk atau nama singkat untuk scan:');
                if (!code) return;
                const lower = code.toLowerCase();
                const found = this.products.find(product => product.kode_barang?.toLowerCase() === lower || product.nama_barang.toLowerCase().includes(lower));
                if (found) {
                    this.activeCategory = 'Semua';
                    this.search = '';
                    this.addToCart(found);
                } else {
                    alert('Produk tidak ditemukan.');
                }
            },

            // Microinteraction ringan ala Shopify POS
            triggerCartMicroInteraction(product, isQtyUpdate) {
                // 1) pulse/scale pada card terpilih (ring sudah ada, pulse via class)
                this.cardPulseKey = product.id;

                // 2) fly-to-cart illusion sederhana: animasi dot menuju area cart badge
                this.flyToken = {
                    id: Date.now(),
                    x: 0,
                    y: 0,
                    toX: 0,
                    toY: 0,
                    visible: true,
                };

                // Ambil posisi elemen card & cart badge
                this.$nextTick(() => {
                    try {
                        const cardEl = document.querySelector(`[data-product-card="${product.id}"]`);
                        const cartBadgeEl = document.querySelector('[data-cart-badge]');
                        if (cardEl && cartBadgeEl) {
                            const a = cardEl.getBoundingClientRect();
                            const b = cartBadgeEl.getBoundingClientRect();
                            this.flyToken = {
                                id: this.flyToken.id,
                                x: a.left + a.width / 2,
                                y: a.top + a.height / 2,
                                toX: b.left + b.width / 2,
                                toY: b.top + b.height / 2,
                                visible: true,
                            };
                        }
                    } catch (e) {}
                });

                // 3) cart badge animate/bounce
                this.cartBadgeBump = true;
                setTimeout(() => (this.cartBadgeBump = false), 420);

                // 4) toast sukses kecil
                this.toastMessage = `${product.nama_barang} ${isQtyUpdate ? 'ditambah lagi' : 'masuk'}`;
                this.toastVisible = true;
                setTimeout(() => (this.toastVisible = false), 1800);

                // 5) kecil delay untuk reset fly token agar ringan
                setTimeout(() => {
                    this.flyToken.visible = false;
                }, 650);
            },

            submitTransaction() {
                if (this.cartItems.length === 0) {
                    alert('Tambahkan minimal 1 barang ke keranjang sebelum menyimpan transaksi.');
                    return;
                }
                this.$refs.posForm.submit();
            },
        }
    }
</script>
@endsection
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
