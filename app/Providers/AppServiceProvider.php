<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MemberBarcode;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ============================================================
        // SIDEBAR: jumlah member (badge notifikasi di menu Member)
        // ============================================================

        View::composer('components.sidebar', function ($view) {
            $view->with('totalMembers', MemberBarcode::count());
        });

        // ============================================================
        // SHARE $setting KE SEMUA VIEW SECARA OTOMATIS
        // ============================================================
        //
        // Biar $setting (nama toko, logo, dll) selalu tersedia di
        // MANA PUN — layout admin, landing page, partial, dst —
        // tanpa perlu tiap controller manual nge-pass compact('setting').
        //
        // Kalau ada view/controller yang SUDAH manual nge-pass $setting
        // sendiri, itu tetap aman — punya controller yang menang.
        //
        // ============================================================

        View::composer('*', function ($view) {

            // Cache sederhana per-request, biar query ke DB cuma
            // sekali walau ada banyak view yang dirender.
            static $setting = null;

            if ($setting === null) {
                $setting = Setting::first();
            }

            $view->with('setting', $setting);

        });
    }
}
