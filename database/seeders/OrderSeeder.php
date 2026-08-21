<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | KASIR
            |--------------------------------------------------------------------------
            */

            $kasir = User::first();

            if (!$kasir) {

                $this->command->warn(
                    'User belum tersedia. Jalankan UserSeeder terlebih dahulu.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | PRODUK
            |--------------------------------------------------------------------------
            */

            $products = Product::whereIn('name', [

                'Espresso',
                'Cafe Latte',
                'Americano',
                'Chocolate',
                'Matcha Latte',
                'Nasi Goreng Marimoi',
                'Ayam Geprek',
                'French Fries',

            ])
                ->get()
                ->keyBy('name');


            /*
            |--------------------------------------------------------------------------
            | VALIDASI PRODUK
            |--------------------------------------------------------------------------
            */

            $requiredProducts = [

                'Espresso',
                'Cafe Latte',
                'Americano',
                'Chocolate',
                'Matcha Latte',
                'Nasi Goreng Marimoi',
                'Ayam Geprek',
                'French Fries',

            ];


            foreach ($requiredProducts as $productName) {

                if (!$products->has($productName)) {

                    $this->command->warn(
                        "Produk {$productName} tidak ditemukan."
                    );

                    return;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS ORDER SEEDER SEBELUMNYA
            |--------------------------------------------------------------------------
            |
            | Hanya menghapus order yang dibuat oleh seeder.
            |
            */

            $oldOrders = Order::where(
                'customer_name',
                'like',
                'Seeder Customer%'
            )->pluck('id');


            if ($oldOrders->isNotEmpty()) {

                OrderItem::whereIn(
                    'order_id',
                    $oldOrders
                )->delete();


                Order::whereIn(
                    'id',
                    $oldOrders
                )->delete();
            }


            /*
            |--------------------------------------------------------------------------
            | DATA TRANSAKSI
            |--------------------------------------------------------------------------
            */

            $orders = [

                // =========================================================
                // ORDER 01
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 01',

                    'table_number' => 1,

                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->subDays(6)
                        ->setTime(9, 15),

                    'items' => [

                        [
                            'product' => 'Espresso',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'French Fries',
                            'quantity' => 1,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 02
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 02',

                    'table_number' => 3,

                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->subDays(5)
                        ->setTime(10, 30),

                    'items' => [

                        [
                            'product' => 'Cafe Latte',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Chocolate',
                            'quantity' => 1,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 03
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 03',

                    'table_number' => 5,

                    'payment_method' => 'transfer',

                    'date' => Carbon::now()
                        ->subDays(4)
                        ->setTime(12, 10),

                    'items' => [

                        [
                            'product' => 'Nasi Goreng Marimoi',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Americano',
                            'quantity' => 2,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 04
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 04',

                    'table_number' => 2,

                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->subDays(3)
                        ->setTime(13, 45),

                    'items' => [

                        [
                            'product' => 'Ayam Geprek',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Matcha Latte',
                            'quantity' => 2,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 05
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 05',

                    'table_number' => 6,

                    'payment_method' => 'transfer',

                    'date' => Carbon::now()
                        ->subDays(2)
                        ->setTime(15, 20),

                    'items' => [

                        [
                            'product' => 'Cafe Latte',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Nasi Goreng Marimoi',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'French Fries',
                            'quantity' => 1,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 06
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 06',

                    'table_number' => 4,

                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->subDay()
                        ->setTime(17, 30),

                    'items' => [

                        [
                            'product' => 'Espresso',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Ayam Geprek',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'French Fries',
                            'quantity' => 2,
                        ],

                    ],
                ],


                /*
                |--------------------------------------------------------------------------
                | TRANSAKSI HARI INI
                |--------------------------------------------------------------------------
                */

                // =========================================================
                // ORDER 07
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 07',

                    'table_number' => 7,

                    'payment_method' => 'transfer',

                    'date' => Carbon::now()
                        ->setTime(11, 10),

                    'items' => [

                        [
                            'product' => 'Cafe Latte',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Americano',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Nasi Goreng Marimoi',
                            'quantity' => 2,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 08
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 08',

                    'table_number' => 8,

                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->setTime(13, 25),

                    'items' => [

                        [
                            'product' => 'Chocolate',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Ayam Geprek',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'French Fries',
                            'quantity' => 1,
                        ],

                    ],
                ],

            ];


            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER
            |--------------------------------------------------------------------------
            */

            foreach ($orders as $orderData) {

                // =========================================================
                // HITUNG SUBTOTAL
                // =========================================================

                $subTotal = 0;

                $totalItem = 0;


                foreach ($orderData['items'] as $item) {

                    $product =
                        $products[$item['product']];

                    $quantity =
                        $item['quantity'];


                    $subTotal +=
                        $product->price * $quantity;


                    $totalItem +=
                        $quantity;
                }


                // =========================================================
                // DISCOUNT
                // =========================================================

                $discountAmount = 0;


                // =========================================================
                // TAX 10%
                // =========================================================

                $tax = (int) round(
                    $subTotal * 0.10
                );


                // =========================================================
                // SERVICE CHARGE 5%
                // =========================================================

                $serviceCharge = (int) round(
                    $subTotal * 0.05
                );


                // =========================================================
                // TOTAL
                // =========================================================

                $total =
                    $subTotal
                    + $tax
                    + $serviceCharge
                    - $discountAmount;


                // =========================================================
                // PAYMENT
                // =========================================================

                $paymentAmount =
                    $total;


                // =========================================================
                // TRANSACTION TIME
                // =========================================================
                //
                // Controller Anda menggunakan format:
                //
                // Y-m-dTH:i:s
                //
                // =========================================================

                $transactionTime =
                    $orderData['date']
                        ->format('Y-m-d\TH:i:s');


                // =========================================================
                // CLIENT ORDER ID
                // =========================================================
                //
                // Setiap transaksi seeder mendapatkan UUID berbeda.
                //
                // Ini penting karena kolom client_order_id:
                //
                // NOT NULL
                // UNIQUE
                //
                // =========================================================

                $clientOrderId =
                    (string) Str::uuid();


                // =========================================================
                // CREATE ORDER
                // =========================================================

                $order = Order::create([

                    // -----------------------------------------------------
                    // IDEMPOTENCY
                    // -----------------------------------------------------

                    'client_order_id' =>
                        $clientOrderId,

                    // -----------------------------------------------------
                    // MEMBER
                    // -----------------------------------------------------

                    'member_code' =>
                        null,

                    // -----------------------------------------------------
                    // PAYMENT
                    // -----------------------------------------------------

                    'payment_amount' =>
                        $paymentAmount,

                    'sub_total' =>
                        $subTotal,

                    'tax' =>
                        $tax,

                    'discount' =>
                        $discountAmount,

                    'discount_amount' =>
                        $discountAmount,

                    'service_charge' =>
                        $serviceCharge,

                    'total' =>
                        $total,

                    'payment_method' =>
                        strtolower(
                            $orderData['payment_method']
                        ),

                    'total_item' =>
                        $totalItem,

                    // -----------------------------------------------------
                    // TABLE
                    // -----------------------------------------------------

                    'table_number' =>
                        $orderData['table_number'],

                    // -----------------------------------------------------
                    // CUSTOMER
                    // -----------------------------------------------------

                    'customer_name' =>
                        $orderData['customer_name'],

                    // -----------------------------------------------------
                    // STATUS
                    // -----------------------------------------------------

                    'status' =>
                        'completed',

                    // -----------------------------------------------------
                    // CASHIER
                    // -----------------------------------------------------

                    'id_kasir' =>
                        $kasir->id,

                    'nama_kasir' =>
                        $kasir->name,

                    // -----------------------------------------------------
                    // TRANSACTION TIME
                    // -----------------------------------------------------

                    'transaction_time' =>
                        $transactionTime,
                ]);


                // =========================================================
                // CREATE ORDER ITEMS
                // =========================================================

                foreach ($orderData['items'] as $item) {

                    $product =
                        $products[$item['product']];


                    OrderItem::create([

                        'order_id' =>
                            $order->id,

                        'product_id' =>
                            $product->id,

                        'product_name' =>
                            $product->name,

                        'quantity' =>
                            $item['quantity'],

                        'price' =>
                            $product->price,

                    ]);
                }


                // =========================================================
                // LOG
                // =========================================================

                $this->command->info(
                    'Order dibuat: '
                    . $order->id
                    . ' | UUID: '
                    . $clientOrderId
                    . ' | '
                    . $orderData['customer_name']
                );
            }
        });


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'OrderSeeder berhasil dibuat.'
        );
    }
}
