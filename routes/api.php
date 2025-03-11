<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ReportsController;
use App\Http\Controllers\Api\V1\BalanceController;
use App\Http\Controllers\Api\V1\FilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('v1')->group(function () {
    Route::post('/import/reports', [ReportsController::class, 'import']);
    Route::post('/import/balances', [BalanceController::class, 'import']);
    Route::get('/imports/files', [FilesController::class, 'index']);
});
