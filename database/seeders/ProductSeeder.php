<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // ============================================================
            // ESKOPI SERIES
            // ============================================================

            [
                'name' => 'Kopi Aren (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu gula aren khas Marimoi, manis legit dan hangat.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Kopi Aren (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu gula aren dingin yang segar, manis legit khas Marimoi.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Kopi Pandan (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan aroma pandan yang wangi dan khas.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kopi Pandan (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dingin beraroma pandan, segar dan wangi.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Kopi Butterscotch (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan cita rasa butterscotch yang manis karamel.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kopi Butterscotch (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dingin dengan cita rasa butterscotch manis karamel.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Kopi Hazelnut (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan aroma hazelnut yang khas dan nikmat.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kopi Hazelnut (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dingin beraroma hazelnut yang khas dan nikmat.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Kopi Onde-Onde',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan cita rasa onde-onde yang unik dan manis gurih.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Kopi Vanilla (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan aroma vanilla yang lembut dan manis.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kopi Vanilla (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dingin beraroma vanilla yang lembut dan manis.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Kopi Caramel (Hot)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dengan cita rasa karamel manis yang menggoda.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kopi Caramel (Ice)',
                'category' => 'Es Kopi Series',
                'description' => 'Kopi susu dingin dengan cita rasa karamel manis yang menggoda.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            // ============================================================
            // NONKOPI SERIES
            // ============================================================

            [
                'name' => 'Cokelat (Hot)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman cokelat creamy dan rich, cocok tanpa kafein.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Cokelat (Ice)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman cokelat dingin yang creamy dan menyegarkan.',
                'price' => 27000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Matcha (Hot)',
                'category' => 'Non Kopi Series',
                'description' => 'Matcha premium dengan susu creamy, rasa earthy yang lembut.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Matcha (Ice)',
                'category' => 'Non Kopi Series',
                'description' => 'Matcha dingin dengan susu creamy, rasa earthy yang segar.',
                'price' => 27000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Taro (Hot)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman taro creamy dengan rasa ubi ungu yang khas.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Taro (Ice)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman taro dingin creamy dengan rasa ubi ungu yang khas.',
                'price' => 27000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Red Velvet (Hot)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman red velvet creamy dengan cita rasa manis lembut.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Red Velvet (Ice)',
                'category' => 'Non Kopi Series',
                'description' => 'Minuman red velvet dingin creamy dengan cita rasa manis lembut.',
                'price' => 27000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Matcha Coconut',
                'category' => 'Non Kopi Series',
                'description' => 'Perpaduan matcha dan santan kelapa yang unik dan menyegarkan.',
                'price' => 28000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            // ============================================================
            // KOPI KLASIK
            // ============================================================

            [
                'name' => 'Spanish Latte (Hot)',
                'category' => 'Kopi Klasik',
                'description' => 'Espresso dengan susu kental manis, creamy dan manis pas.',
                'price' => 22000,
                'stock' => 20,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Spanish Latte (Ice)',
                'category' => 'Kopi Klasik',
                'description' => 'Espresso dingin dengan susu kental manis, creamy dan segar.',
                'price' => 24000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'White (Cappucino/Latte/Magic) - Hot',
                'category' => 'Kopi Klasik',
                'description' => 'Racikan white coffee khas Marimoi, pilih varian cappuccino, latte, atau magic.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'White (Cappucino/Latte/Magic) - Ice',
                'category' => 'Kopi Klasik',
                'description' => 'Racikan white coffee dingin khas Marimoi, pilih varian cappuccino, latte, atau magic.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Americano (Hot)',
                'category' => 'Kopi Klasik',
                'description' => 'Espresso dengan air panas, rasa clean dan bold.',
                'price' => 22000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Americano (Ice)',
                'category' => 'Kopi Klasik',
                'description' => 'Espresso dengan air dingin, rasa clean dan menyegarkan.',
                'price' => 24000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            [
                'name' => 'Americano Peach',
                'category' => 'Kopi Klasik',
                'description' => 'Americano segar dipadukan dengan sirup peach yang manis asam.',
                'price' => 27000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            // ============================================================
            // SIGNATURE
            // ============================================================

            [
                'name' => 'Pineapple',
                'category' => 'Signature',
                'description' => 'Minuman signature Marimoi dengan rasa nanas yang segar.',
                'price' => 28000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            // ============================================================
            // MAKANAN
            // ============================================================

            [
                'name' => 'Nasi Ayam Lalapan',
                'category' => 'Makanan',
                'description' => 'Nasi dengan ayam goreng dan lalapan segar khas Marimoi.',
                'price' => 35000,
                'stock' => 15,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Nasi Ayam Kampung Lalapan',
                'category' => 'Makanan',
                'description' => 'Nasi dengan ayam kampung goreng dan lalapan segar.',
                'price' => 40000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Nasi Iga Bakar',
                'category' => 'Makanan',
                'description' => 'Nasi dengan iga bakar bumbu khas yang gurih dan lezat.',
                'price' => 40000,
                'stock' => 15,
                'is_favorite' => 1,
                'base_unit' => 'PCS',
            ],
            [
                'name' => 'Ikan Bakar',
                'category' => 'Makanan',
                'description' => 'Ikan bakar segar dengan bumbu khas Marimoi, dijual per ons sesuai berat timbangan.',
                'price' => 5000, // harga per 1 ons (100gr)
                'stock' => 50, // stok dalam satuan ons
                'is_favorite' => 0,
                'base_unit' => 'ONS',
            ],
            [
                'name' => 'Nasi Ikan Mujair Goreng Tepung',
                'category' => 'Makanan',
                'description' => 'Nasi dengan ikan mujair goreng tepung yang renyah.',
                'price' => 35000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Nasi Udang Goreng Tepung',
                'category' => 'Makanan',
                'description' => 'Nasi dengan udang goreng tepung yang renyah dan gurih.',
                'price' => 30000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Nasi Ayam Geprek',
                'category' => 'Makanan',
                'description' => 'Nasi dengan ayam geprek sambal pedas khas Marimoi.',
                'price' => 20000,
                'stock' => 15,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Nasi Goreng Kampung',
                'category' => 'Makanan',
                'description' => 'Nasi goreng kampung dengan bumbu khas yang gurih.',
                'price' => 20000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Tinutuan',
                'category' => 'Makanan',
                'description' => 'Bubur Manado khas dengan sayuran segar, hangat dan mengenyangkan.',
                'price' => 18000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Mie Cakalang',
                'category' => 'Makanan',
                'description' => 'Mie dengan suwiran ikan cakalang khas, gurih dan lezat.',
                'price' => 20000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Mie Ayam + Bakso',
                'category' => 'Makanan',
                'description' => 'Mie ayam lengkap dengan bakso, hangat dan mengenyangkan.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Mie Goreng Spesial',
                'category' => 'Makanan',
                'description' => 'Mie goreng dengan topping spesial dan bumbu khas Marimoi.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            // ============================================================
            // SNACK
            // ============================================================

            [
                'name' => 'Pisang Goreng',
                'category' => 'Snack',
                'description' => 'Pisang goreng renyah khas Marimoi, cocok temani ngopi.',
                'price' => 15000,
                'stock' => 20,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Pisang Goroho',
                'category' => 'Snack',
                'description' => 'Pisang goroho khas Manado yang gurih dan renyah.',
                'price' => 15000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Marimoi Platter',
                'category' => 'Snack',
                'description' => 'Sajian snack andalan Marimoi dalam satu platter.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Kentang Goreng',
                'category' => 'Snack',
                'description' => 'Kentang goreng renyah dengan taburan bumbu gurih.',
                'price' => 20000,
                'stock' => 20,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Roti Kampung Marimoi',
                'category' => 'Snack',
                'description' => 'Roti kampung hangat khas Marimoi, cocok untuk teman santai.',
                'price' => 20000,
                'stock' => 20,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Roti Kampung Nutella Keju',
                'category' => 'Snack',
                'description' => 'Roti kampung dengan topping nutella dan keju yang manis gurih.',
                'price' => 30000,
                'stock' => 20,
                'is_favorite' => 1,
            ],
            [
                'name' => 'Marimoi Mix Platter',
                'category' => 'Snack',
                'description' => 'Kombinasi lengkap snack favorit Marimoi dalam satu platter besar.',
                'price' => 50000,
                'stock' => 15,
                'is_favorite' => 0,
            ],
            [
                'name' => 'Tahu Garing',
                'category' => 'Snack',
                'description' => 'Tahu garing renyah dengan bumbu gurih khas Marimoi.',
                'price' => 15000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

        ];

        foreach ($products as $product) {

            // ============================================================
            // firstOrCreate (BUKAN firstOrFail): kalau kategori
            // ("Es Kopi Series", "Non Kopi Series", "Kopi Klasik",
            // "Signature") belum ada di database, otomatis dibuatkan —
            // gak perlu update CategorySeeder terpisah dulu.
            // ============================================================

            $category = Category::firstOrCreate([
                'name' => $product['category'],
            ]);

            Product::updateOrCreate(
                [
                    'name' => $product['name'],
                ],
                [
                    'category_id' => $category->id,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'status' => 1,
                    'is_favorite' => $product['is_favorite'],
                    'base_unit' => $product['base_unit'] ?? 'PCS',
                    'image' => null,
                ]
            );
        }
    }
}
