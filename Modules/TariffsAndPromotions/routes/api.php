<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\TariffsAndPromotions\App\Http\Controllers\PromotionController;
use Modules\TariffsAndPromotions\App\Http\Controllers\TariffController;

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

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('tariffsandpromotions', fn (Request $request) => $request->user())->name('tariffsandpromotions');
// });

Route::middleware(['auth:api', 'role:admin'])->group(function () {

    // tariffs
    Route::prefix('tariffs')->group(function () {
        Route::get('/', [TariffController::class, 'getTariffsByFilter']);
        Route::post('/', [TariffController::class, 'store']);
        Route::get('/{id}', [TariffController::class, 'show']);
        Route::put('/{id}', [TariffController::class, 'update']);
        Route::delete('/{id}', [TariffController::class, 'destroy']);
    });

    // promotions
    Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'getPromotionsByFilters']);
        Route::post('/', [PromotionController::class, 'store']);
        Route::get('/{id}', [PromotionController::class, 'show']);
        Route::put('/{id}', [PromotionController::class, 'update']);
        Route::delete('/{id}', [PromotionController::class, 'destroy']);
    });

});
