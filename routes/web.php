<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberRegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])
    ->name('landing');
Route::get('/daftar-member', [MemberRegisterController::class, 'create'])
    ->name('member.register');
Route::post('/daftar-member', [MemberRegisterController::class, 'store'])
    ->name('member.register.store');
Route::get('/daftar-member/sukses', [MemberRegisterController::class, 'success'])
    ->name('member.register.success');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {



    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    |
    | Semua route di bawah ini hanya bisa diakses oleh user
    | dengan role "admin", termasuk Dashboard.
    |
    */

    Route::middleware('role:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | DISCOUNTS
        |--------------------------------------------------------------------------
        */

        Route::resource('discounts', DiscountController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | EXPENSES
        |--------------------------------------------------------------------------
        */

        Route::resource('expenses', ExpenseController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | MEMBERS
        |--------------------------------------------------------------------------
        */

        Route::get('members/generate-code', [MemberController::class, 'generateCode'])
            ->name('members.generate-code');

        Route::resource('members', MemberController::class);

        /*
        |--------------------------------------------------------------------------
        | ORDER REPORT
        |--------------------------------------------------------------------------
        |
        | GET /orders
        | Menampilkan daftar transaksi
        |
        */

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        /*
        |--------------------------------------------------------------------------
        | ORDER SUMMARY
        |--------------------------------------------------------------------------
        |
        | GET /orders/summary
        | Digunakan untuk mengambil ringkasan transaksi
        |
        */

        Route::get('/orders/summary', [OrderController::class, 'summary'])
            ->name('orders.summary');

        /*
        |--------------------------------------------------------------------------
        | ORDER DETAIL
        |--------------------------------------------------------------------------
        |
        | GET /orders/{id}
        | Digunakan oleh modal detail transaksi
        |
        */

        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->whereNumber('id')
            ->name('orders.show');

        Route::get('settings', [SettingController::class, 'edit'])
            ->name('settings.edit');

        Route::put('settings', [SettingController::class, 'update'])
            ->name('settings.update');

            /*
            |--------------------------------------------------------------------------
            | ANNOUNCEMENTS (INFORMASI MEMBER)
            |--------------------------------------------------------------------------
            */

            Route::resource('announcements', AnnouncementController::class)
                ->except(['show']);
    });

});
