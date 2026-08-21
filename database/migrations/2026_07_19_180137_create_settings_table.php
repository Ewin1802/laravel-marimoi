<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Informasi Toko
            |--------------------------------------------------------------------------
            */

            $table->string('store_name');
            $table->string('store_tagline')->nullable();
            $table->text('store_description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Logo
            |--------------------------------------------------------------------------
            */

            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Hero Landing Page
            |--------------------------------------------------------------------------
            */

            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_button')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Kontak
            |--------------------------------------------------------------------------
            */

            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();

            $table->text('address')->nullable();
            $table->longText('google_maps')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Social Media
            |--------------------------------------------------------------------------
            */

            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Footer
            |--------------------------------------------------------------------------
            */

            $table->string('copyright')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Website
            |--------------------------------------------------------------------------
            */

            $table->boolean('maintenance_mode')->default(false);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
