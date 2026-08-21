<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Coffee',
                'description' => 'Berbagai pilihan kopi klasik dan kopi spesialti.',
                'image' => null,
            ],

            [
                'name' => 'Non Coffee',
                'description' => 'Minuman segar tanpa kopi untuk menemani waktu santai.',
                'image' => null,
            ],

            [
                'name' => 'Makanan',
                'description' => 'Pilihan makanan berat yang cocok untuk makan siang dan malam.',
                'image' => null,
            ],

            [
                'name' => 'Snack',
                'description' => 'Camilan ringan untuk menemani kopi dan waktu berkumpul.',
                'image' => null,
            ],

        ];

        foreach ($categories as $category) {

            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );

        }
    }
}
