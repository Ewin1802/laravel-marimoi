<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])
    ->name('landing');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->except(['show']);




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

    });

});