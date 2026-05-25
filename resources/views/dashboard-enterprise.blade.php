@extends('layouts.app-enterprise')

@section('title', 'Dashboard Analytics - InventoryPro Enterprise')
@section('breadcrumb', 'Dashboard Analytics')

@section('content')
<!-- KPI Cards with Mini Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Revenue KPI -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover overflow-hidden relative">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Revenue</p>
<p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>



            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 dark:from-blue-900/30 to-blue-50 dark:to-blue-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2">
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> {{ $revenueGrowthPercent ?? 0 }}%
            </span>

            <span class="text-slate-500 dark:text-slate-400 text-sm">dari bulan lalu</span>
        </div>
        <canvas id="revenueSparkline" class="mt-4" height="40"></canvas>
    </div>

    <!-- Orders KPI -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pesanan</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalOrders ?? 0 }}</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 dark:from-purple-900/30 to-purple-50 dark:to-purple-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2">
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> {{ $ordersGrowthPercent ?? 0 }}%
            </span>

            <span class="text-slate-500 dark:text-slate-400 text-sm">dari bulan lalu</span>
        </div>
        <canvas id="ordersSparkline" class="mt-4" height="40"></canvas>
    </div>

    <!-- Products KPI -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Produk</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalProducts ?? 0 }}</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-green-100 dark:from-green-900/30 to-green-50 dark:to-green-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-red-600 dark:text-red-400 text-sm font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-down"></i> 0%
            </span>

            <span class="text-slate-500 dark:text-slate-400 text-sm">dari bulan lalu</span>
        </div>
        <canvas id="productsSparkline" class="mt-4" height="40"></canvas>
    </div>

    <!-- Customers KPI -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pelanggan</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalCustomers ?? 0 }}</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 dark:from-orange-900/30 to-orange-50 dark:to-orange-900/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-2xl text-orange-600 dark:text-orange-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-green-600 dark:text-green-400 text-sm font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> 0%
            </span>

            <span class="text-slate-500 dark:text-slate-400 text-sm">dari bulan lalu</span>
        </div>
        <canvas id="customersSparkline" class="mt-4" height="40"></canvas>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Revenue Growth Chart -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-600 dark:text-blue-400"></i>
                Pertumbuhan Revenue
            </h3>
            <select class="text-sm px-3 py-1 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                <option>6 Bulan Terakhir</option>
                <option>1 Tahun</option>
                <option>3 Tahun</option>
            </select>
        </div>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    <!-- Stock Status -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
            Stok Kritis
        </h3>

        <div class="space-y-3">
            @foreach(($criticalStocks ?? []) as $item)

                <div class="p-3 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $item['name'] }}</p>
                        <span class="text-xs font-bold text-red-600 dark:text-red-400">{{ $item['stock'] }}/{{ $criticalThreshold ?? 0 }}</span>

                    </div>
                    <div class="w-full bg-red-200 dark:bg-red-900/30 rounded-full h-2">
                        <div class="bg-red-600 dark:bg-red-500 h-2 rounded-full" style="width: {{ ($criticalThreshold ? ($item['stock'] / $criticalThreshold) * 100 : 0) }}%"></div>

                    </div>
                </div>
            @endforeach
        </div>

        <button class="w-full mt-4 px-4 py-2 bg-red-100 dark:bg-red-900/20 hover:bg-red-200 dark:hover:bg-red-900/40 text-red-700 dark:text-red-300 rounded-lg font-medium transition-colors text-sm">
            <i class="fas fa-plus mr-2"></i>
            Restock Sekarang
        </button>
    </div>
</div>

<!-- Monthly Comparison & Top Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Comparison -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-chart-bar text-purple-600 dark:text-purple-400"></i>
            Perbandingan Bulanan
        </h3>
        <canvas id="monthlyComparisonChart" height="60"></canvas>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-star text-yellow-600 dark:text-yellow-400"></i>
            Produk Terlaris
        </h3>

        <div class="space-y-3">
            @foreach(($topProducts ?? []) as $index => $product)

                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-sm font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-slate-900 dark:text-white truncate">{{ $product['name'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $product['sales'] }} terjual</p>
                        </div>
                    </div>
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Rp {{ number_format($product['revenue'], 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Activity Timeline & Top Customers -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Activity Timeline -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-history text-green-600 dark:text-green-400"></i>
            Timeline Aktivitas
        </h3>

        <div class="space-y-4">
            @forelse(($activityTimeline ?? []) as $event)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        @php
                            $dotClass = match(($event['type'] ?? 'transaction')) {
                                'stock' => 'bg-red-600 dark:bg-red-400',
                                'transaction' => 'bg-blue-600 dark:bg-blue-400',
                                default => 'bg-orange-600 dark:bg-orange-400',
                            };
                        @endphp
                        <div class="w-3 h-3 rounded-full {{ $dotClass }}"></div>
                        <div class="w-0.5 h-12 bg-slate-200 dark:bg-slate-700"></div>
                    </div>
                    <div class="pb-4">
                        <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $event['title'] ?? 'Event' }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $event['subtitle'] ?? '-' }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">{{ $event['time'] ?? '' }}</p>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-500 dark:text-slate-400">
                    <i class="fas fa-history text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada aktivitas.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Top Customers -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-crown text-amber-600 dark:text-amber-400"></i>
            Pelanggan Terbaik
        </h3>

        <div class="space-y-3">
            @foreach(($topCustomers ?? []) as $customer)

                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $customer['name'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $customer['orders'] }} transaksi</p>
                    </div>
                    <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($customer['spending'], 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
const revenueLabels = @json($months ?? []);
const revenueSeries = @json($monthlyRevenue ?? []);

const ctx = document.getElementById('revenueChart')?.getContext('2d');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueSeries,
                borderColor: '#0284c7',
                backgroundColor: 'rgba(2, 132, 199, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#0284c7',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } } }
        }
    });
}


// Monthly Comparison (Revenue)
const monthlyLabels = @json($months ?? []);
const monthlyRevenue = @json($monthlyRevenue ?? []);
const monthlyOrders = @json($monthlyOrders ?? []);

const monthlyCtx = document.getElementById('monthlyComparisonChart')?.getContext('2d');
if (monthlyCtx) {
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: monthlyRevenue,
                    backgroundColor: 'rgba(148, 163, 184, 0.5)',
                },
                {
                    label: 'Pesanan',
                    data: monthlyOrders,
                    backgroundColor: '#0284c7',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

// Sparklines
const miniRevenueSeries = @json($miniRevenueSeries ?? []);
const miniOrdersSeries = @json($miniOrdersSeries ?? []);
const miniProductsSeries = @json($miniProductsSeries ?? []);
const miniCustomersSeries = @json($miniCustomersSeries ?? []);

['revenue', 'orders', 'products', 'customers'].forEach(name => {
    const map = {
        revenue: miniRevenueSeries,
        orders: miniOrdersSeries,
        products: miniProductsSeries,
        customers: miniCustomersSeries,
    };

    const series = map[name] || [];
    const sparkCtx = document.getElementById(`${name}Sparkline`)?.getContext('2d');

    if (sparkCtx) {
        new Chart(sparkCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: series.length }, (_, i) => i),
                datasets: [{
                    data: series,
                    borderColor: '#0284c7',
                    backgroundColor: 'rgba(2, 132, 199, 0.1)',
                    borderWidth: 1,
                    fill: true,
                    pointRadius: 0,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }
});
</script>
@endsection
