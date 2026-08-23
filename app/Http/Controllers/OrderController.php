<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Menampilkan laporan transaksi.
    |
    | Default:
    | - range = 30 hari
    | - end_date = hari ini
    | - start_date = 29 hari sebelum hari ini
    |
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | RANGE
        |--------------------------------------------------------------------------
        */

        $range = (int) $request->input('range', 30);

        if ($range < 1) {
            $range = 30;
        }


        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */

        $end_date = $request->input(
            'end_date',
            now()->toDateString()
        );

        $start_date = $request->input(
            'start_date',
            now()
                ->subDays($range - 1)
                ->toDateString()
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TANGGAL
        |--------------------------------------------------------------------------
        */

        try {

            $startCarbon = Carbon::parse($start_date);
            $endCarbon = Carbon::parse($end_date);

        } catch (\Throwable $e) {

            return redirect()
                ->route('orders.index')
                ->with(
                    'error',
                    'Format tanggal tidak valid.'
                );
        }


        if ($startCarbon->greaterThan($endCarbon)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT TRANSACTION TIME
        |--------------------------------------------------------------------------
        */

        $start = $startCarbon
            ->startOfDay()
            ->format('Y-m-d\TH:i:s');

        $end = $endCarbon
            ->endOfDay()
            ->format('Y-m-d\TH:i:s');


        /*
        |--------------------------------------------------------------------------
        | BASE ORDER QUERY
        |--------------------------------------------------------------------------
        */

        $query = Order::query()
            ->whereRaw(
                "STR_TO_DATE(
                    transaction_time,
                    '%Y-%m-%dT%H:%i:%s'
                ) BETWEEN ? AND ?",
                [
                    $start,
                    $end,
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | ORDER LIST
        |--------------------------------------------------------------------------
        */

        $orders = (clone $query)
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | ORDER SUMMARY
        |--------------------------------------------------------------------------
        */

        $summary = [

            'total_revenue' => (clone $query)
                ->sum('payment_amount'),

            'total_discount' => (clone $query)
                ->sum('discount_amount'),

            'total_tax' => (clone $query)
                ->sum('tax'),

            'total_service_charge' => (clone $query)
                ->sum('service_charge'),

            'total_cash' => (clone $query)
                ->whereRaw(
                    'LOWER(payment_method) = ?',
                    ['cash']
                )
                ->sum('total'),

            'total_transfer' => (clone $query)
                ->whereRaw(
                    'LOWER(payment_method) = ?',
                    ['transfer']
                )
                ->sum('total'),

            'total_order' => (clone $query)
                ->count(),

            'total_item' => (clone $query)
                ->sum('total_item'),

            'average_order' => (clone $query)
                ->avg('payment_amount') ?? 0,
        ];


        /*
        |--------------------------------------------------------------------------
        | EXPENSE QUERY
        |--------------------------------------------------------------------------
        */

        $expenseQuery = Expense::query()
            ->whereBetween(
                'expense_date',
                [
                    $startCarbon->toDateString(),
                    $endCarbon->toDateString(),
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | TOTAL EXPENSE
        |--------------------------------------------------------------------------
        */

        $totalExpense = (clone $expenseQuery)
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | EXPENSE BY CATEGORY
        |--------------------------------------------------------------------------
        */

        $expenseByCategory = (clone $expenseQuery)
            ->selectRaw(
                'category, SUM(amount) as total'
            )
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NET INCOME
        |--------------------------------------------------------------------------
        */

        $netIncome =
            ($summary['total_revenue'] ?? 0)
            -
            ($totalExpense ?? 0);


        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $chartData = (clone $query)
            ->selectRaw("
                DATE(
                    STR_TO_DATE(
                        transaction_time,
                        '%Y-%m-%dT%H:%i:%s'
                    )
                ) AS trx_date,

                SUM(total) AS total
            ")
            ->groupBy('trx_date')
            ->orderBy('trx_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.order_reports.index',
            compact(
                'orders',
                'summary',
                'chartData',
                'start_date',
                'end_date',
                'range',
                'totalExpense',
                'expenseByCategory',
                'netIncome'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY API
    |--------------------------------------------------------------------------
    |
    | Digunakan jika halaman atau JavaScript membutuhkan
    | ringkasan transaksi dalam format JSON.
    |
    */

    public function summary(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Order::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        |
        | Jika tanggal diberikan, kita gunakan created_at.
        |
        */

        if ($startDate && $endDate) {

            try {

                $start = Carbon::parse($startDate)
                    ->startOfDay();

                $end = Carbon::parse($endDate)
                    ->endOfDay();

                $query->whereBetween(
                    'created_at',
                    [
                        $start,
                        $end,
                    ]
                );

            } catch (\Throwable $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Format tanggal tidak valid.',
                ], 422);

            }
        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATION
        |--------------------------------------------------------------------------
        */

        $totalRevenue = (clone $query)
            ->sum('total');

        $totalDiscount = (clone $query)
            ->sum('discount_amount');

        $totalTax = (clone $query)
            ->sum('tax');

        $totalServiceCharge = (clone $query)
            ->sum('service_charge');

        $totalSubtotal = (clone $query)
            ->sum('sub_total');


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        |
        | Sesuai struktur perhitungan yang kamu gunakan sebelumnya.
        |
        */

        $total =
            $totalSubtotal
            - $totalDiscount
            - $totalTax
            + $totalServiceCharge;


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => 'success',

            'data' => [

                'total_revenue' =>
                    $totalRevenue,

                'total_discount' =>
                    $totalDiscount,

                'total_tax' =>
                    $totalTax,

                'total_subtotal' =>
                    $totalSubtotal,

                'total_service_charge' =>
                    $totalServiceCharge,

                'total' =>
                    $total,

            ],

        ], 200);
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    |
    | Mengambil detail satu transaksi.
    |
    | Endpoint:
    |
    | GET /orders/{id}
    |
    | Digunakan oleh modal detail transaksi.
    |
    */

    public function show(int $id)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD ORDER
        |--------------------------------------------------------------------------
        |
        | Sekaligus mengambil order_items dan product.
        |
        */

        $order = Order::with([
            'orderItems.product'
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ORDER DATA
        |--------------------------------------------------------------------------
        */

        $orderData = [

            'id' =>
                $order->id,

            'payment_amount' =>
                $order->payment_amount,

            'sub_total' =>
                $order->sub_total,

            'tax' =>
                $order->tax,

            'discount' =>
                $order->discount,

            'discount_amount' =>
                $order->discount_amount,

            'service_charge' =>
                $order->service_charge,

            'total' =>
                $order->total,

            'payment_method' =>
                $order->payment_method,

            'total_item' =>
                $order->total_item,

            'table_number' =>
                $order->table_number,

            'customer_name' =>
                $order->customer_name,

            'status' =>
                $order->status,

            'id_kasir' =>
                $order->id_kasir,

            'nama_kasir' =>
                $order->nama_kasir,

            'transaction_time' =>
                $order->transaction_time,

            'created_at' =>
                $order->created_at,

        ];


        /*
        |--------------------------------------------------------------------------
        | ORDER ITEMS
        |--------------------------------------------------------------------------
        */

        $items = $order->orderItems
            ->map(function ($item) {

                /*
                | Ambil nama produk dari snapshot
                | product_name terlebih dahulu.
                |
                | Jika kosong, ambil dari tabel products.
                */

                $productName =
                    $item->product_name
                    ?? optional($item->product)->name
                    ?? 'Produk';


                return [

                    'id' =>
                        $item->id,

                    'product_id' =>
                        $item->product_id,

                    'product_name' =>
                        $productName,

                    'quantity' =>
                        $item->quantity,

                    'price' =>
                        (float) $item->price,

                    'total' =>
                        (float) $item->quantity
                        * (float) $item->price,

                ];

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | JSON RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' =>
                'success',

            'order' =>
                $orderData,

            'items' =>
                $items,

        ]);
    }
}
