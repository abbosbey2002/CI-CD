<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\ContentManagement\App\Http\Controllers\AboutAndSocialController;
use Modules\ContentManagement\App\Http\Controllers\ContactBranchController;
use Modules\ContentManagement\App\Http\Controllers\FAQCategoryController;
use Modules\ContentManagement\App\Http\Controllers\FAQController;
use Modules\ContentManagement\App\Http\Controllers\NewsController;
use Modules\ContentManagement\App\Http\Controllers\ProductsController;
use Modules\ContentManagement\App\Http\Controllers\TermsConditionController;

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
//     Route::get('contentmanagement', fn (Request $request) => $request->user())->name('contentmanagement');
// });

// // Get About Company
// Route::get('about-company', function () {
//     $about = DB::table('about_company')->first();
//     return response()->json($about);
// });

// // Update About Company
// Route::put('about-company', function (Request $request) {
//     $request->validate([
//         'text' => 'required|string',
//     ]);

//     $data = ['description' => $request->input('text')];
//     DB::table('about_company')->updateOrInsert(['id' => 1], $data);

//     return response()->json(['message' => 'About Company updated successfully']);
// });

Route::middleware(['auth:api', 'role:admin'])->group(function () {

    Route::get('/about-social', [AboutAndSocialController::class, 'index']);
    Route::put('/about-social', [AboutAndSocialController::class, 'update']);

    // FAQ
    // Route::apiResource('faq', FAQController::class);
    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', [FAQController::class, 'getFaqsWithPagination']);
        Route::post('/', [FAQController::class, 'store']);
        Route::get('/{id}', [FAQController::class, 'show']);
        Route::put('/{id}', [FAQController::class, 'update']);
        Route::delete('/{id}', [FAQController::class, 'destroy']);
    });

    // FAQ Category
    Route::group(['prefix' => 'faq-category'], function () {
        Route::get('/', [FAQCategoryController::class, 'index']);
        Route::post('/', [FAQCategoryController::class, 'store']);
        Route::get('/{id}', [FAQCategoryController::class, 'show']);
        Route::put('/{id}', [FAQCategoryController::class, 'update']);
        Route::delete('/{id}', [FAQCategoryController::class, 'destroy']);
    });

    // Terms & Conditions
    // Route::apiResource('terms-conditions', TermsConditionController::class);

    // News
    // Route::apiResource('news', NewsController::class);
    Route::group(['prefix' => 'news'], function () {
        Route::get('/', [NewsController::class, 'getNewsWithFilter']);
        Route::post('/', [NewsController::class, 'store']);
        Route::get('/{id}', [NewsController::class, 'show']);
        Route::put('/{id}', [NewsController::class, 'update']);
        Route::delete('/{id}', [NewsController::class, 'destroy']);
        // Route::get('/download', [NewsController::class, 'downloadFile']);
    });

    // products
    Route::get('/products', [ProductsController::class, 'index']);
    Route::post('/products', [ProductsController::class, 'update']);
    Route::get('/products/download', [ProductsController::class, 'downloadFile']);

    // contact branch
    Route::apiResource('contact-branch', ContactBranchController::class);
});
