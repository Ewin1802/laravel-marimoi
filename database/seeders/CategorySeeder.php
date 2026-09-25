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
                'name' => 'Es Kopi Series',
                'description' => 'Kopi susu kekinian dengan berbagai pilihan rasa, tersedia hot dan ice.',
                'image' => null,
            ],
            [
                'name' => 'Non Kopi Series',
                'description' => 'Minuman segar tanpa kopi dengan berbagai pilihan rasa, hot dan ice.',
                'image' => null,
            ],
            [
                'name' => 'Kopi Klasik',
                'description' => 'Racikan kopi klasik seperti latte, cappuccino, dan americano.',
                'image' => null,
            ],
            [
                'name' => 'Signature',
                'description' => 'Minuman andalan dan khas Marimoi yang tidak ada di tempat lain.',
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
