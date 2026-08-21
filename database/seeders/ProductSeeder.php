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

            // COFFEE
            [
                'name' => 'Espresso',
                'category' => 'Coffee',
                'description' => 'Espresso dengan karakter rasa kuat dan aroma kopi yang khas.',
                'price' => 18000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Cafe Latte',
                'category' => 'Coffee',
                'description' => 'Espresso dengan susu creamy dan rasa yang lembut.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Americano',
                'category' => 'Coffee',
                'description' => 'Espresso dan air dengan rasa kopi yang clean dan menyegarkan.',
                'price' => 22000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            // NON COFFEE
            [
                'name' => 'Chocolate',
                'category' => 'Non Coffee',
                'description' => 'Minuman cokelat creamy dengan rasa manis yang pas.',
                'price' => 23000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Matcha Latte',
                'category' => 'Non Coffee',
                'description' => 'Matcha latte lembut dengan aroma matcha yang khas.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            // MAKANAN
            [
                'name' => 'Nasi Goreng Marimoi',
                'category' => 'Makanan',
                'description' => 'Nasi goreng spesial dengan bumbu khas Marimoi dan topping pilihan.',
                'price' => 32000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Ayam Geprek',
                'category' => 'Makanan',
                'description' => 'Ayam crispy dengan sambal pedas dan nasi hangat.',
                'price' => 30000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            // SNACK
            [
                'name' => 'French Fries',
                'category' => 'Snack',
                'description' => 'Kentang goreng renyah yang cocok untuk teman ngopi.',
                'price' => 18000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

        ];

        foreach ($products as $product) {

            $category = Category::where(
                'name',
                $product['category']
            )->firstOrFail();

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
                    'image' => null,
                ]
            );
        }
    }
}
