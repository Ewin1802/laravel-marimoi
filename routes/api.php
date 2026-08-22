<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\MemberBarcodeController;
use App\Http\Controllers\Api\MemberStampController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route otomatis menggunakan prefix /api
|
*/


// ==========================================================================
// AUTHENTICATION
// ==========================================================================

Route::post('/register', [
    AuthController::class,
    'register',
]);

Route::post('/login', [
    AuthController::class,
    'login',
]);


// ==========================================================================
// AUTHENTICATED ROUTES
// ==========================================================================

Route::middleware('auth:sanctum')->group(function () {

    // ======================================================================
    // CURRENT USER
    // ======================================================================

    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user(),
        ]);
    });


    // ======================================================================
    // LOGOUT
    // ======================================================================

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ]);


    Route::post('/member/scan', [
        MemberBarcodeController::class,
        'scan',
    ]);

    // Stamp milik member yang sedang login
    Route::get('/member/stamp', [
        MemberStampController::class,
        'show',
    ]);

    // Riwayat stamp
    Route::get('/member/stamp/history', [
        MemberStampController::class,
        'history',
    ]);
    Route::post(
        '/member/stamp/earn',
        [MemberStampController::class, 'earn']
    );

    /*
    |--------------------------------------------------------------------------
    | REDEEM MYSTERY BOX
    |--------------------------------------------------------------------------
    |
    | Dipanggil aplikasi member.
    |
    | Member menekan:
    |
    | "Buka Mystery Box"
    |
    */

    Route::post('/member/stamp/redeem', [
        MemberStampController::class,
        'redeem',
    ]);


    // ======================================================================
    // PRODUCTS
    // ======================================================================

    Route::get('/products', [ProductController::class,'index',]);
    Route::post('/products', [ProductController::class,'store',]);
    Route::post('/products/edit', [ProductController::class,'update',]);
    Route::delete('/products/{id}', [ProductController::class,'destroy',]);


    // ======================================================================
    // CATEGORIES
    // ======================================================================

    Route::apiResource(
        '/api-categories',
        CategoryController::class
    );


    // ======================================================================
    // ORDERS
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Save Order
    |--------------------------------------------------------------------------
    |
    | POST /api/save-order
    |
    | Endpoint ini yang akan:
    |
    | 1. Membuat order
    | 2. Memastikan idempotency
    | 3. Menyimpan member_code
    | 4. Memberikan stamp jika ada member
    |
    */

    Route::post('/save-order', [
        OrderController::class,
        'saveOrder',
    ]);


    // ======================================================================
    // DISCOUNTS
    // ======================================================================

    Route::get('/api-discounts', [
        DiscountController::class,
        'index',
    ]);

    Route::post('/api-discounts', [
        DiscountController::class,
        'store',
    ]);


    // ======================================================================
    // REPORT
    // ======================================================================

    Route::get('/orders/{date?}', [
        OrderController::class,
        'index',
    ]);

    Route::get('/summary/{date?}', [
        OrderController::class,
        'summary',
    ]);

    Route::get('/order-item/{date?}', [
        OrderItemController::class,
        'index',
    ]);

    Route::get('/order-sales', [
        OrderItemController::class,
        'orderSales',
    ]);

    Route::get(
        '/member/sync',
        [MemberBarcodeController::class, 'sync']
    );

});
