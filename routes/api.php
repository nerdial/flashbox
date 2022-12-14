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

        // get current user data
        Route::get('user', [UserController::class, 'currentUser'])->name('currentUser');

        // admin routes with role permission protection
        Route::prefix('admin')->group(function () {

            Route::middleware('can:add seller')
                ->get('sellers', [AdminController::class, 'sellerList'])->name('admin.seller.list');

            Route::middleware('can:list seller')
                ->post('sellers/create', [AdminController::class,
                    'storeNewSeller'])->name('admin.seller.create');
        });


        // seller routes with role permission protection
        Route::prefix('seller')
            ->group(function () {

                Route::middleware('can:list shop product')
                    ->get('products',
                        [SellerController::class,
                            'getAllProducts'])->name('seller.product.list');

                Route::middleware('can:add product')
                    ->post('products/create', [SellerController::class,
                        'storeProduct'])->name('seller.product.create');
            });


        // customer routes with role permission protection
        Route::prefix('customer')
            ->group(function () {

                Route::middleware('can:list product')
                    ->get('products', [CustomerController::class, 'getNearbyProducts'])
                    ->name('customer.product.list');

                Route::middleware('can:purchase product')
                    ->post('products/purchase/{product}', [CustomerController::class,
                        'purchaseAnItem'])->name('customer.product.purchase');
            });

    });
});
