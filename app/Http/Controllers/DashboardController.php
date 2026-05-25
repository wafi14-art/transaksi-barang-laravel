<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Intelligent enterprise dashboard (DB-driven KPIs & analytics).
     */
    public function index(Request $request)
    {
        $now = Carbon::now();

        // Base counts
        $totalBarang = Barang::count();
        $totalPelanggan = Pelanggan::count();
        $totalTransaksi = Transaksi::count();

        // Inventory critical stock threshold (simple heuristic)
        // If you want a configurable threshold later, add it to settings/env.
        $criticalThreshold = max(5, (int) (Barang::avg('stok') ?? 0));
        $criticalThreshold = min($criticalThreshold, 10);

        // Inventory health
        $inventoryTotal = Barang::count();
        $inventoryCriticalCount = Barang::where('stok', '<=', $criticalThreshold)->count();
        $inventoryAvailableCount = Barang::where('stok', '>', $criticalThreshold)->count();
        $inventoryHealthPercent = $inventoryTotal > 0
            ? (int) round(($inventoryAvailableCount / $inventoryTotal) * 100)
            : 0;

        // Revenue (use total_harga)
        $revenueTotal = (float) (Transaksi::sum(DB::raw('COALESCE(total_harga,0)')) ?? 0);

        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $revenueThisMonth = (float) (Transaksi::whereBetween('tgl_transaksi', [$monthStart, $monthEnd])
            ->sum(DB::raw('COALESCE(total_harga,0)')) ?? 0);

        // Previous month revenue for growth
        $prevMonthStart = $now->copy()->subMonth()->startOfMonth();
        $prevMonthEnd = $now->copy()->subMonth()->endOfMonth();
        $revenuePrevMonth = (float) (Transaksi::whereBetween('tgl_transaksi', [$prevMonthStart, $prevMonthEnd])
            ->sum(DB::raw('COALESCE(total_harga,0)')) ?? 0);

        $revenueGrowthPercent = 0;
        if ($revenuePrevMonth > 0) {
            $revenueGrowthPercent = (int) round((($revenueThisMonth - $revenuePrevMonth) / $revenuePrevMonth) * 100);
        } elseif ($revenueThisMonth > 0) {
            $revenueGrowthPercent = 100;
        }

        // Orders / transactions count growth
        $ordersThisMonth = (int) Transaksi::whereBetween('tgl_transaksi', [$monthStart, $monthEnd])->count();
        $ordersPrevMonth = (int) Transaksi::whereBetween('tgl_transaksi', [$prevMonthStart, $prevMonthEnd])->count();
        $ordersGrowthPercent = 0;
        if ($ordersPrevMonth > 0) {
            $ordersGrowthPercent = (int) round((($ordersThisMonth - $ordersPrevMonth) / $ordersPrevMonth) * 100);
        } elseif ($ordersThisMonth > 0) {
            $ordersGrowthPercent = 100;
        }

        // Monthly comparison (last 6 months including current)
        $months = [];
        $monthlyRevenue = [];
        $monthlyOrders = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt = $now->copy()->subMonths($i);
            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();

            $label = $dt->format('M');
            $rev = (float) (Transaksi::whereBetween('tgl_transaksi', [$start, $end])
                ->sum(DB::raw('COALESCE(total_harga,0)')) ?? 0);
            $ord = (int) Transaksi::whereBetween('tgl_transaksi', [$start, $end])->count();

            $months[] = $label;
            $monthlyRevenue[] = $rev;
            $monthlyOrders[] = $ord;
        }

        // Top selling products from detail_transaksi
        $topProducts = DetailTransaksi::query()
            ->select([
                'barang_id',
                DB::raw('SUM(COALESCE(jumlah,0)) as total_qty'),
                DB::raw('SUM(COALESCE(subtotal,0)) as total_revenue'),
            ])
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->with(['barang:id,nama_barang,kode_barang,harga_jual'])
            ->limit(5)
            ->get();

        // Because we used with() after grouping, Eloquent eager load may not map fields.
        // We'll also fetch product names robustly.
        $topProductIds = $topProducts->pluck('barang_id')->filter()->values();
        $topProductMeta = Barang::whereIn('id', $topProductIds)
            ->get(['id', 'nama_barang', 'kode_barang', 'harga_jual'])
            ->keyBy('id');

        $topProductsForView = $topProducts->map(function ($row) use ($topProductMeta) {
            $meta = $topProductMeta->get($row->barang_id);
            return [
                'barang_id' => $row->barang_id,
                'name' => $meta->nama_barang ?? ($meta->nama_barang ?? '-'),
                'kode' => $meta->kode_barang ?? null,
                'sales' => (int) ($row->total_qty ?? 0),
                'revenue' => (float) ($row->total_revenue ?? 0),
            ];
        });

        // Top customers by total revenue
        $topCustomersRows = Transaksi::query()
            ->select([
                'pelanggan_id',
                DB::raw('SUM(COALESCE(total_harga,0)) as spending'),
                DB::raw('COUNT(*) as orders'),
            ])
            ->groupBy('pelanggan_id')
            ->orderByDesc('spending')
            ->limit(5)
            ->get();

        $topCustomerIds = $topCustomersRows->pluck('pelanggan_id')->filter()->values();
        $topCustomerMeta = Pelanggan::whereIn('id', $topCustomerIds)
            ->get(['id', 'nama'])
            ->keyBy('id');

        $topCustomersForView = $topCustomersRows->map(function ($row) use ($topCustomerMeta) {
            $meta = $topCustomerMeta->get($row->pelanggan_id);
            return [
                'name' => $meta->nama ?? '-',
                'spending' => (float) ($row->spending ?? 0),
                'orders' => (int) ($row->orders ?? 0),
            ];
        });

        // Critical stock list (show up to 5)
        $criticalStocks = Barang::query()
            ->where('stok', '<=', $criticalThreshold)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get(['id', 'nama_barang', 'stok', 'harga_jual'])
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'name' => $b->nama_barang,
                    'stock' => (int) $b->stok,
                    'price' => (float) ($b->harga_jual ?? 0),
                ];
            })
            ->values();

        // Inventory health timeline-ish (recent transactions + low stock products)
        $recentTransactions = Transaksi::with(['pelanggan'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $activityTimeline = $recentTransactions->map(function ($t) {
            $timeLabel = $t->tgl_transaksi ? Carbon::parse($t->tgl_transaksi)->diffForHumans() : '—';
            return [
                'type' => 'transaction',
                'title' => 'Transaksi Baru',
                'subtitle' => $t->pelanggan->nama ?? 'Pelanggan',
                'time' => $timeLabel,
            ];
        })->values();

        // Add some low-stock events at the end
        $lowStockForTimeline = Barang::where('stok', '<=', $criticalThreshold)
            ->orderBy('stok', 'asc')
            ->limit(2)
            ->get(['nama_barang', 'stok']);

        $lowStockEvents = $lowStockForTimeline->map(function ($b) {
            return [
                'type' => 'stock',
                'title' => 'Stok Diperbarui',
                'subtitle' => sprintf('Barang "%s" berada pada level kritis', $b->nama_barang),
                'time' => 'baru-baru ini',
            ];
        });

        $activityTimeline = $activityTimeline->merge($lowStockEvents)->values();

        // Mini charts: based on monthly orders/revenue
        // For simplicity we reuse monthly arrays.
        $miniRevenueSeries = array_values($monthlyRevenue);
        $miniOrdersSeries = array_values($monthlyOrders);
        $miniProductsSeries = array_map(function () {
            return 0;
        }, $monthlyRevenue);
        // Estimate products series as count of items sold per month
        $miniProductsSeries = [];
        for ($i = 0; $i < count($months); $i++) {
            $revIndex = $i;
            $dt = $now->copy()->subMonths((count($months)-1) - $revIndex);
            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();
            $soldProducts = DetailTransaksi::whereHas('transaksi', function ($q) use ($start, $end) {
                $q->whereBetween('tgl_transaksi', [$start, $end]);
            })->distinct('barang_id')->count();
            $miniProductsSeries[] = $soldProducts;
        }

        // Mini customers series: distinct customers per month
        $miniCustomersSeries = [];
        for ($i = 0; $i < count($months); $i++) {
            $revIndex = $i;
            $dt = $now->copy()->subMonths((count($months)-1) - $revIndex);
            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();
            $customersCount = Transaksi::whereBetween('tgl_transaksi', [$start, $end])
                ->distinct('pelanggan_id')
                ->count('pelanggan_id');
            $miniCustomersSeries[] = $customersCount;
        }

        // Recent activity for navbar (reuse recentTransactions)
        $recentActivity = $recentTransactions->map(function ($t) {
            $timeLabel = $t->tgl_transaksi ? Carbon::parse($t->tgl_transaksi)->diffForHumans() : '—';
            return [
                'text' => sprintf('%s - %s', $t->pelanggan->nama ?? 'Pelanggan', $t->no_transaksi ?? 'TRX'),
                'time' => $timeLabel,
            ];
        })->values();

        return view('dashboard-enterprise', [
            // KPI
            'totalRevenue' => $revenueTotal,
            'totalOrders' => $totalTransaksi,
            'totalProducts' => (int) Barang::count(),
            'totalCustomers' => $totalPelanggan,

            // Growth labels
            'revenueGrowthPercent' => $revenueGrowthPercent,
            'ordersGrowthPercent' => $ordersGrowthPercent,

            // Monthly data
            'months' => $months,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrders' => $monthlyOrders,

            // Top products/customers
            'topProducts' => $topProductsForView,
            'topCustomers' => $topCustomersForView,

            // Critical stock
            'criticalStocks' => $criticalStocks,
            'criticalThreshold' => $criticalThreshold,

            // Inventory health
            'inventoryHealthPercent' => $inventoryHealthPercent,

            // Activity timeline
            'activityTimeline' => $activityTimeline,

            // Mini chart series
            'miniRevenueSeries' => $miniRevenueSeries,
            'miniOrdersSeries' => $miniOrdersSeries,
            'miniProductsSeries' => $miniProductsSeries,
            'miniCustomersSeries' => $miniCustomersSeries,

            // Navbar recent activity
            'recentActivity' => $recentActivity,
        ]);
    }
}

