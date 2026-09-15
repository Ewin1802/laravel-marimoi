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
                'name' => 'Marimoi Signature Espresso',
                'category' => 'Coffee',
                'description' => 'Espresso dengan karakter bold, aroma intens, dan aftertaste yang elegan.',
                'price' => 18000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Velvet Cream Latte',
                'category' => 'Coffee',
                'description' => 'Perpaduan espresso dengan steamed milk yang creamy, lembut, dan silky.',
                'price' => 25000,
                'stock' => 20,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Midnight Americano',
                'category' => 'Coffee',
                'description' => 'Espresso premium dengan air pilihan, menghadirkan rasa clean dan bold yang menyegarkan.',
                'price' => 22000,
                'stock' => 20,
                'is_favorite' => 0,
            ],

            // NON COFFEE
            [
                'name' => 'Royal Belgian Chocolate',
                'category' => 'Non Coffee',
                'description' => 'Cokelat premium dengan tekstur creamy dan rasa cocoa yang rich dan memanjakan.',
                'price' => 23000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Matcha Velvet',
                'category' => 'Non Coffee',
                'description' => 'Premium matcha dengan susu creamy, menghasilkan rasa earthy yang lembut dan seimbang.',
                'price' => 25000,
                'stock' => 15,
                'is_favorite' => 0,
            ],

            // MAKANAN
            [
                'name' => 'Marimoi Signature Fried Rice',
                'category' => 'Makanan',
                'description' => 'Nasi goreng signature Marimoi dengan racikan bumbu khas dan topping pilihan.',
                'price' => 32000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            [
                'name' => 'Crispy Sambal Chicken',
                'category' => 'Makanan',
                'description' => 'Ayam crispy golden dengan sambal khas yang pedas, gurih, dan menggugah selera.',
                'price' => 30000,
                'stock' => 15,
                'is_favorite' => 1,
            ],

            // SNACK
            [
                'name' => 'Golden Truffle Fries',
                'category' => 'Snack',
                'description' => 'Kentang goreng golden yang renyah dengan sentuhan gurih dan aroma yang menggoda.',
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

