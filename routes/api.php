<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SellerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {


    Route::prefix('app')->group(function () {

        Route::get('user', [UserController::class, 'currentUser']);


        // seller routes
        Route::prefix('seller')->group(function () {
            Route::get('products',
                [SellerController::class,
                    'getAllProducts']);
            Route::post('products/create', [SellerController::class,
                'storeProduct']);
        });


        // admin routes
        Route::prefix('admin/sellers')->group(function () {
            Route::get('/', [AdminController::class, 'sellerList']);
            Route::post('create', [AdminController::class,
                'storeNewSeller']);
        });


        // customer routes
        Route::prefix('customer')->group(function () {
            Route::get('products', [CustomerController::class, 'getNearbyProducts']);
            Route::post('products/purchase/{product}', [CustomerController::class,
                'purchaseAnItem']);
        });

    });
});
