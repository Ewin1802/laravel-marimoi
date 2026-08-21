<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Konversi transaction_time (String ISO 8601)
     * menjadi DATETIME MySQL.
     */
    private function transactionDate(): string
    {
        return "STR_TO_DATE(transaction_time,'%Y-%m-%dT%H:%i:%s')";
    }

    public function index()
    {
        $transactionDate = $this->transactionDate();

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD HARI INI
        |--------------------------------------------------------------------------
        */

        $todayRevenue = Order::whereRaw("
            DATE($transactionDate)=CURDATE()
        ")->sum('total');

        $todayOrders = Order::whereRaw("
            DATE($transactionDate)=CURDATE()
        ")->count();

        $todayCash = Order::whereRaw("
            DATE($transactionDate)=CURDATE()
        ")
            ->where('payment_method', 'cash')
            ->sum('total');

        $todayTransfer = Order::whereRaw("
            DATE($transactionDate)=CURDATE()
        ")
            ->where('payment_method', 'transfer')
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD BULAN INI
        |--------------------------------------------------------------------------
        */

        $monthRevenue = Order::whereRaw("
            YEAR($transactionDate)=YEAR(CURDATE())
            AND
            MONTH($transactionDate)=MONTH(CURDATE())
        ")->sum('total');

        $monthOrders = Order::whereRaw("
            YEAR($transactionDate)=YEAR(CURDATE())
            AND
            MONTH($transactionDate)=MONTH(CURDATE())
        ")->count();

        $monthCash = Order::whereRaw("
            YEAR($transactionDate)=YEAR(CURDATE())
            AND
            MONTH($transactionDate)=MONTH(CURDATE())
        ")
            ->where('payment_method', 'cash')
            ->sum('total');

        $monthTransfer = Order::whereRaw("
            YEAR($transactionDate)=YEAR(CURDATE())
            AND
            MONTH($transactionDate)=MONTH(CURDATE())
        ")
            ->where('payment_method', 'transfer')
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 1)->count();

        $inactiveProducts = Product::where('status', 0)->count();

        $favoriteProductsCount = Product::where('is_favorite', 1)->count();

        $totalCategories = Category::count();

        $totalUsers = User::count();

        /*
        |--------------------------------------------------------------------------
        | INVENTORY
        |--------------------------------------------------------------------------
        */

        $totalStock = Product::sum('stock');

        $stockValue = Product::selectRaw("
                SUM(stock * price) as total
            ")
            ->value('total') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | STOK MENIPIS
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::with('category')
            ->where('status', 1)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PRODUK FAVORIT
        |--------------------------------------------------------------------------
        */

        $favoriteProducts = Product::with('category')
            ->where('status', 1)
            ->where('is_favorite', 1)
            ->latest()
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PENDAPATAN 30 HARI
        |--------------------------------------------------------------------------
        */

        $chart = Order::selectRaw("
                DATE($transactionDate) as trx_date,
                SUM(total) as total
            ")
            ->whereRaw("
                DATE($transactionDate) >= ?
            ", [
                Carbon::now()
                    ->subDays(29)
                    ->toDateString()
            ])
            ->groupBy('trx_date')
            ->orderBy('trx_date')
            ->get();

        $chartLabels = $chart
            ->pluck('trx_date')
            ->map(function ($date) {

                return Carbon::parse($date)
                    ->format('d M');

            });

        $chartSeries = $chart
            ->pluck('total');
                /*
        |--------------------------------------------------------------------------
        | TOP PRODUK TERLARIS
        |--------------------------------------------------------------------------
        */

        $topProducts = DB::table('order_items')

            ->join(
                'products',
                'products.id',
                '=',
                'order_items.product_id'
            )

            ->select(

                'products.id',

                'products.name',

                'products.image',

                DB::raw('SUM(order_items.quantity) as total_qty'),

                DB::raw('SUM(order_items.quantity * order_items.price) as omzet')

            )

            ->groupBy(

                'products.id',

                'products.name',

                'products.image'

            )

            ->orderByDesc('total_qty')

            ->limit(10)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::orderByRaw("
                $transactionDate DESC
            ")
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | USER TERBARU
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::latest()
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CASH VS TRANSFER
        |--------------------------------------------------------------------------
        */

        $totalPayment = $monthCash + $monthTransfer;

       $cashPercent = $totalPayment > 0
            ? round(($monthCash / $totalPayment) * 100, 1)
            : 0;

        $transferPercent = $totalPayment > 0
            ? round(($monthTransfer / $totalPayment) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $averageOrder = $todayOrders > 0
            ? round(
                $todayRevenue / $todayOrders
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS DASHBOARD
        |--------------------------------------------------------------------------
        */

        $activities = collect();

        foreach ($recentOrders as $order) {

            $activities->push([

                'icon' => 'receipt-text',

                'title' => 'Transaksi Baru',

                'subtitle' => $order->customer_name
                    ?: 'Customer Umum',

                'amount' => $order->payment_amount,

                'payment_method' => ucfirst(
                    $order->payment_method
                ),

                'time' => Carbon::parse(
                    str_replace(
                        'T',
                        ' ',
                        $order->transaction_time
                    )
                )->diffForHumans(),

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | PENJUALAN TERAKHIR 7 HARI
        |--------------------------------------------------------------------------
        */

        $weeklyRevenue = Order::whereRaw("
                DATE($transactionDate)>=?
            ", [
                Carbon::now()
                    ->subDays(6)
                    ->toDateString()
            ])
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | PENJUALAN TERAKHIR 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyRevenue = Order::whereRaw("
                DATE($transactionDate)>=?
            ", [
                Carbon::now()
                    ->subDays(29)
                    ->toDateString()
            ])
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyOrders = Order::whereRaw("
                DATE($transactionDate)>=?
            ", [
                Carbon::now()
                    ->subDays(29)
                    ->toDateString()
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.dashboard.index',
            compact(

                // Hari Ini
                'todayRevenue',
                'todayOrders',
                'todayCash',
                'todayTransfer',

                // Bulan Ini
                'monthRevenue',
                'monthOrders',
                'monthCash',
                'monthTransfer',

                // Master
                'totalProducts',
                'activeProducts',
                'inactiveProducts',
                'favoriteProductsCount',
                'totalCategories',
                'totalUsers',

                // Inventory
                'totalStock',
                'stockValue',

                // Produk
                'favoriteProducts',
                'lowStockProducts',
                'topProducts',

                // Chart
                'chartLabels',
                'chartSeries',

                // Dashboard
                'recentOrders',
                'recentUsers',
                'activities',

                // Statistik
                'cashPercent',
                'transferPercent',
                'averageOrder',
                'weeklyRevenue',
                'monthlyRevenue',
                'monthlyOrders'
            )
        );
    }
}
