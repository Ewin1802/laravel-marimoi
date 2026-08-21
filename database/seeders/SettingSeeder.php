<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS CAFE
            |--------------------------------------------------------------------------
            */

            'store_name' =>
            'Marimoi Cafe',

            'store_tagline' =>
            'Coffee • Eat • Gather',

            'store_description' =>
            'Marimoi Cafe adalah tempat untuk menikmati kopi pilihan, makanan lezat, dan suasana nyaman untuk berkumpul, bekerja, maupun bersantai.',


            /*
            |--------------------------------------------------------------------------
            | HERO
            |--------------------------------------------------------------------------
            */

            'hero_title' =>
            'Secangkir Kopi, Sepiring Cerita.',

            'hero_subtitle' =>
            'Nikmati kopi pilihan, makanan hangat, dan hidangan favorit dalam suasana yang nyaman. Tempat yang pas untuk menikmati pagi, makan siang, hingga menghabiskan waktu bersama orang tersayang.',

            'hero_button' =>
            'Lihat Menu',


            /*
            |--------------------------------------------------------------------------
            | KONTAK
            |--------------------------------------------------------------------------
            */

            'phone' =>
            '081340985993',

            'whatsapp' =>
            '6281340985993',

            'email' =>
            'info@marimoicafe.com',

            'address' =>
            'Kabupaten Bolaang Mongondow Utara',


            /*
            |--------------------------------------------------------------------------
            | SOCIAL MEDIA
            |--------------------------------------------------------------------------
            */

            'facebook' =>
            '#',

            'instagram' =>
            'https://instagram.com/',

            'youtube' =>
            '#',

            'tiktok' =>
            '#',


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' =>
            'Marimoi Cafe | Coffee, Food & Good Moments',

            'meta_description' =>
            'Marimoi Cafe menghadirkan kopi pilihan, minuman segar, makanan ringan, dan makanan berat dalam suasana nyaman untuk menikmati waktu bersama.',

            'meta_keywords' =>
            'Marimoi Cafe,kafe,cafe,kopi,kopi Bolaang Mongondow Utara,makanan,coffee shop,makanan berat,minuman,kuliner Bolmut',


            /*
            |--------------------------------------------------------------------------
            | COPYRIGHT
            |--------------------------------------------------------------------------
            */

            'copyright' =>
            '© ' . date('Y') . ' Marimoi Cafe. All rights reserved.',

        ]);
    }
}
