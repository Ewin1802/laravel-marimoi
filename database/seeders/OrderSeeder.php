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
            | Semua nama produk di sini harus sama persis dengan ProductSeeder.
            |--------------------------------------------------------------------------
            */

            $productNames = [

                // Es Kopi Series
                'Kopi Aren (Hot)',
                'Kopi Aren (Ice)',
                'Kopi Pandan (Hot)',
                'Kopi Pandan (Ice)',
                'Kopi Butterscotch (Hot)',
                'Kopi Butterscotch (Ice)',
                'Kopi Hazelnut (Hot)',
                'Kopi Hazelnut (Ice)',
                'Kopi Onde-Onde',
                'Kopi Vanilla (Hot)',
                'Kopi Vanilla (Ice)',
                'Kopi Caramel (Hot)',
                'Kopi Caramel (Ice)',

                // Non Kopi Series
                'Cokelat (Hot)',
                'Cokelat (Ice)',
                'Matcha (Hot)',
                'Matcha (Ice)',
                'Taro (Hot)',
                'Taro (Ice)',
                'Red Velvet (Hot)',
                'Red Velvet (Ice)',
                'Matcha Coconut',

                // Kopi Klasik
                'Spanish Latte (Hot)',
                'Spanish Latte (Ice)',
                'White (Cappucino/Latte/Magic) - Hot',
                'White (Cappucino/Latte/Magic) - Ice',
                'Americano (Hot)',
                'Americano (Ice)',
                'Americano Peach',

                // Signature
                'Pineapple',

                // Makanan
                'Nasi Ayam Lalapan',
                'Nasi Ayam Kampung Lalapan',
                'Nasi Iga Bakar',
                'Nasi Ikan Mujair Goreng Tepung',
                'Nasi Udang Goreng Tepung',
                'Nasi Ayam Geprek',
                'Nasi Goreng Kampung',
                'Tinutuan',
                'Mie Cakalang',
                'Mie Ayam + Bakso',
                'Mie Goreng Spesial',

                // Snack
                'Pisang Goreng',
                'Pisang Goroho',
                'Marimoi Platter',
                'Kentang Goreng',
                'Roti Kampung Marimoi',
                'Roti Kampung Nutella Keju',
                'Marimoi Mix Platter',
                'Tahu Garing',
            ];

            $products = Product::whereIn('name', $productNames)
                ->get()
                ->keyBy('name');


            /*
            |--------------------------------------------------------------------------
            | VALIDASI PRODUK
            |--------------------------------------------------------------------------
            */

            $missingProducts = collect($productNames)
                ->filter(fn ($name) => !$products->has($name));

            if ($missingProducts->isNotEmpty()) {

                foreach ($missingProducts as $productName) {
                    $this->command->warn(
                        "Produk {$productName} tidak ditemukan."
                    );
                }

                $this->command->warn(
                    'OrderSeeder dihentikan karena terdapat produk yang belum tersedia.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS ORDER SEEDER SEBELUMNYA
            |--------------------------------------------------------------------------
            |
            | Hanya order dengan customer_name "Seeder Customer%"
            | yang akan dihapus.
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
                            'product' => 'Kopi Aren (Hot)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Pisang Goreng',
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
                            'product' => 'Kopi Vanilla (Ice)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Cokelat (Hot)',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Kentang Goreng',
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
                            'product' => 'Nasi Ayam Lalapan',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Americano (Ice)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Tahu Garing',
                            'quantity' => 1,
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
                            'product' => 'Nasi Ayam Geprek',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Matcha (Ice)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Pisang Goroho',
                            'quantity' => 1,
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
                            'product' => 'Spanish Latte (Ice)',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Nasi Goreng Kampung',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Kentang Goreng',
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
                            'product' => 'Kopi Caramel (Ice)',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Nasi Iga Bakar',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Marimoi Platter',
                            'quantity' => 1,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 07 - HARI INI
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 07',
                    'table_number' => 7,
                    'payment_method' => 'transfer',

                    'date' => Carbon::now()
                        ->setTime(11, 10),

                    'items' => [

                        [
                            'product' => 'Kopi Aren (Ice)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Americano Peach',
                            'quantity' => 1,
                        ],

                        [
                            'product' => 'Nasi Ayam Kampung Lalapan',
                            'quantity' => 2,
                        ],

                    ],
                ],


                // =========================================================
                // ORDER 08 - HARI INI
                // =========================================================

                [
                    'customer_name' => 'Seeder Customer 08',
                    'table_number' => 8,
                    'payment_method' => 'cash',

                    'date' => Carbon::now()
                        ->setTime(13, 25),

                    'items' => [

                        [
                            'product' => 'Cokelat (Ice)',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Nasi Ayam Geprek',
                            'quantity' => 2,
                        ],

                        [
                            'product' => 'Roti Kampung Nutella Keju',
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

                /*
                |--------------------------------------------------------------------------
                | HITUNG SUBTOTAL
                |--------------------------------------------------------------------------
                */

                $subTotal = 0;
                $totalItem = 0;

                foreach ($orderData['items'] as $item) {

                    $product = $products[$item['product']];

                    $quantity = $item['quantity'];

                    $subTotal += $product->price * $quantity;

                    $totalItem += $quantity;
                }


                /*
                |--------------------------------------------------------------------------
                | DISCOUNT
                |--------------------------------------------------------------------------
                */

                $discountAmount = 0;


                /*
                |--------------------------------------------------------------------------
                | TAX 10%
                |--------------------------------------------------------------------------
                */

                $tax = (int) round(
                    $subTotal * 0.10
                );


                /*
                |--------------------------------------------------------------------------
                | SERVICE CHARGE 5%
                |--------------------------------------------------------------------------
                */

                $serviceCharge = (int) round(
                    $subTotal * 0.05
                );


                /*
                |--------------------------------------------------------------------------
                | TOTAL
                |--------------------------------------------------------------------------
                */

                $total =
                    $subTotal
                    + $tax
                    + $serviceCharge
                    - $discountAmount;


                /*
                |--------------------------------------------------------------------------
                | PAYMENT
                |--------------------------------------------------------------------------
                */

                $paymentAmount = $total;


                /*
                |--------------------------------------------------------------------------
                | TRANSACTION TIME
                |--------------------------------------------------------------------------
                */

                $transactionTime =
                    $orderData['date']
                        ->format('Y-m-d\TH:i:s');


                /*
                |--------------------------------------------------------------------------
                | CLIENT ORDER ID
                |--------------------------------------------------------------------------
                */

                $clientOrderId = (string) Str::uuid();


                /*
                |--------------------------------------------------------------------------
                | CREATE ORDER
                |--------------------------------------------------------------------------
                */

                $order = Order::create([

                    'client_order_id' =>
                        $clientOrderId,

                    'member_code' =>
                        null,

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

                    'table_number' =>
                        $orderData['table_number'],

                    'customer_name' =>
                        $orderData['customer_name'],

                    'status' =>
                        'completed',

                    'id_kasir' =>
                        $kasir->id,

                    'nama_kasir' =>
                        $kasir->name,

                    'transaction_time' =>
                        $transactionTime,
                ]);


                /*
                |--------------------------------------------------------------------------
                | CREATE ORDER ITEMS
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | LOG
                |--------------------------------------------------------------------------
                */

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

