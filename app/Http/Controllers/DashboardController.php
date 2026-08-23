<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * =========================================================
     * TRANSACTION DATE
     * =========================================================
     *
     * transaction_time disimpan sebagai string:
     *
     * 2026-08-17T13:25:00
     *
     * sehingga perlu dikonversi menjadi DATETIME MySQL.
     */
    private function transactionDate(): string
    {
        return "STR_TO_DATE(transaction_time,'%Y-%m-%dT%H:%i:%s')";
    }


    /**
     * =========================================================
     * DASHBOARD
     * =========================================================
     */
    public function index()
    {
        $transactionDate = $this->transactionDate();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD HARI INI
        |--------------------------------------------------------------------------
        */

        $todayRevenue = Order::whereRaw("
            DATE($transactionDate) = CURDATE()
        ")
            ->sum('total');


        $todayOrders = Order::whereRaw("
            DATE($transactionDate) = CURDATE()
        ")
            ->count();


        $todayCash = Order::whereRaw("
            DATE($transactionDate) = CURDATE()
        ")
            ->whereRaw(
                'LOWER(payment_method) = ?',
                ['cash']
            )
            ->sum('total');


        $todayTransfer = Order::whereRaw("
            DATE($transactionDate) = CURDATE()
        ")
            ->whereRaw(
                'LOWER(payment_method) = ?',
                ['transfer']
            )
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN HARI INI
        |--------------------------------------------------------------------------
        */

        $todayExpense = Expense::whereDate(
            'expense_date',
            Carbon::today()
        )
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH HARI INI
        |--------------------------------------------------------------------------
        */

        $todayNetIncome =
            $todayRevenue - $todayExpense;


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD BULAN INI
        |--------------------------------------------------------------------------
        */

        $monthRevenue = Order::whereRaw("
            YEAR($transactionDate) = YEAR(CURDATE())
            AND
            MONTH($transactionDate) = MONTH(CURDATE())
        ")
            ->sum('total');


        $monthOrders = Order::whereRaw("
            YEAR($transactionDate) = YEAR(CURDATE())
            AND
            MONTH($transactionDate) = MONTH(CURDATE())
        ")
            ->count();


        $monthCash = Order::whereRaw("
            YEAR($transactionDate) = YEAR(CURDATE())
            AND
            MONTH($transactionDate) = MONTH(CURDATE())
        ")
            ->whereRaw(
                'LOWER(payment_method) = ?',
                ['cash']
            )
            ->sum('total');


        $monthTransfer = Order::whereRaw("
            YEAR($transactionDate) = YEAR(CURDATE())
            AND
            MONTH($transactionDate) = MONTH(CURDATE())
        ")
            ->whereRaw(
                'LOWER(payment_method) = ?',
                ['transfer']
            )
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN BULAN INI
        |--------------------------------------------------------------------------
        */

        $monthExpense = Expense::whereYear(
            'expense_date',
            Carbon::now()->year
        )
            ->whereMonth(
                'expense_date',
                Carbon::now()->month
            )
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH BULAN INI
        |--------------------------------------------------------------------------
        */

        $monthNetIncome =
            $monthRevenue - $monthExpense;


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN BERDASARKAN KATEGORI
        |--------------------------------------------------------------------------
        */

        $expenseGaji = Expense::whereYear(
            'expense_date',
            Carbon::now()->year
        )
            ->whereMonth(
                'expense_date',
                Carbon::now()->month
            )
            ->where('category', 'Gaji')
            ->sum('amount');


        $expenseDapur = Expense::whereYear(
            'expense_date',
            Carbon::now()->year
        )
            ->whereMonth(
                'expense_date',
                Carbon::now()->month
            )
            ->where('category', 'Pengeluaran Dapur')
            ->sum('amount');


        $expenseListrik = Expense::whereYear(
            'expense_date',
            Carbon::now()->year
        )
            ->whereMonth(
                'expense_date',
                Carbon::now()->month
            )
            ->where('category', 'Listrik')
            ->sum('amount');


        $expenseTakTerduga = Expense::whereYear(
            'expense_date',
            Carbon::now()->year
        )
            ->whereMonth(
                'expense_date',
                Carbon::now()->month
            )
            ->where('category', 'Tak Terduga')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $totalExpense = $monthExpense;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $expensePercent = $monthRevenue > 0
            ? round(
                ($monthExpense / $monthRevenue) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | MARGIN BERSIH
        |--------------------------------------------------------------------------
        */

        $netIncomePercent = $monthRevenue > 0
            ? round(
                ($monthNetIncome / $monthRevenue) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'status',
            1
        )->count();

        $inactiveProducts = Product::where(
            'status',
            0
        )->count();

        $favoriteProductsCount = Product::where(
            'is_favorite',
            1
        )->count();

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
        | GRAFIK PENDAPATAN VS PENGELUARAN 30 HARI
        |--------------------------------------------------------------------------
        */

        $expenseChart = Expense::selectRaw("
            expense_date,
            SUM(amount) as total
        ")
            ->whereDate(
                'expense_date',
                '>=',
                Carbon::now()
                    ->subDays(29)
                    ->toDateString()
            )
            ->groupBy('expense_date')
            ->orderBy('expense_date')
            ->get();


        $expenseChartLabels = $expenseChart
            ->pluck('expense_date')
            ->map(function ($date) {

                return Carbon::parse($date)
                    ->format('d M');

            });


        $expenseChartSeries = $expenseChart
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

                DB::raw(
                    'SUM(order_items.quantity) as total_qty'
                ),

                DB::raw(
                    'SUM(order_items.quantity * order_items.price) as omzet'
                )

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
        | PENGELUARAN TERBARU
        |--------------------------------------------------------------------------
        */

        $recentExpenses = Expense::with('user')
            ->latest('expense_date')
            ->latest('id')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CASH VS TRANSFER
        |--------------------------------------------------------------------------
        */

        $totalPayment =
            $monthCash +
            $monthTransfer;


        $cashPercent = $totalPayment > 0
            ? round(
                ($monthCash / $totalPayment) * 100,
                1
            )
            : 0;


        $transferPercent = $totalPayment > 0
            ? round(
                ($monthTransfer / $totalPayment) * 100,
                1
            )
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

                'type' => 'order',

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
        | AKTIVITAS PENGELUARAN
        |--------------------------------------------------------------------------
        */

        foreach ($recentExpenses as $expense) {

            $activities->push([

                'type' => 'expense',

                'icon' => 'wallet',

                'title' => 'Pengeluaran',

                'subtitle' => $expense->description,

                'category' => $expense->category,

                'amount' => $expense->amount,

                'time' => Carbon::parse(
                    $expense->expense_date
                )->diffForHumans(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $activities = $activities
            ->sortByDesc(function ($activity) {

                return $activity['time'];

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN TERAKHIR 7 HARI
        |--------------------------------------------------------------------------
        */

        $weeklyRevenue = Order::whereRaw("
            DATE($transactionDate) >= ?
        ", [
            Carbon::now()
                ->subDays(6)
                ->toDateString()
        ])
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN 7 HARI
        |--------------------------------------------------------------------------
        */

        $weeklyExpense = Expense::whereDate(
            'expense_date',
            '>=',
            Carbon::now()
                ->subDays(6)
                ->toDateString()
        )
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH 7 HARI
        |--------------------------------------------------------------------------
        */

        $weeklyNetIncome =
            $weeklyRevenue -
            $weeklyExpense;


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN TERAKHIR 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyRevenue = Order::whereRaw("
            DATE($transactionDate) >= ?
        ", [
            Carbon::now()
                ->subDays(29)
                ->toDateString()
        ])
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN TERAKHIR 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyExpense = Expense::whereDate(
            'expense_date',
            '>=',
            Carbon::now()
                ->subDays(29)
                ->toDateString()
        )
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyNetIncome =
            $monthlyRevenue -
            $monthlyExpense;


        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER 30 HARI
        |--------------------------------------------------------------------------
        */

        $monthlyOrders = Order::whereRaw("
            DATE($transactionDate) >= ?
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
                'todayExpense',
                'todayNetIncome',

                // Bulan Ini
                'monthRevenue',
                'monthOrders',
                'monthCash',
                'monthTransfer',
                'monthExpense',
                'monthNetIncome',

                // Pengeluaran
                'totalExpense',
                'expenseGaji',
                'expenseDapur',
                'expenseListrik',
                'expenseTakTerduga',
                'expensePercent',
                'netIncomePercent',

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
                'expenseChartLabels',
                'expenseChartSeries',

                // Dashboard
                'recentOrders',
                'recentUsers',
                'recentExpenses',
                'activities',

                // Statistik
                'cashPercent',
                'transferPercent',
                'averageOrder',
                'weeklyRevenue',
                'weeklyExpense',
                'weeklyNetIncome',
                'monthlyRevenue',
                'monthlyExpense',
                'monthlyNetIncome',
                'monthlyOrders'
            )
        );
    }
}
