<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\App\Http\Controllers\AdminController;
use Modules\UserManagement\App\Http\Controllers\UserController;

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

Route::post('/login', [AdminController::class, 'login']);
Route::post('/refresh', [AdminController::class, 'refresh']);
// Route::post('/reset-password', [AdminController::class, 'resetPassword']);

// Route::post('/register', [AdminController::class, 'register']);
Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/reset-password', [AdminController::class, 'resetPassword']);
    Route::post('/', [AdminController::class, 'createAdmin']);
    Route::get('/{id}', [AdminController::class, 'showAdmin']);
    Route::put('/{id}', [AdminController::class, 'update']);
    Route::delete('/{id}', [AdminController::class, 'deleteAdmin']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'getUsersByPagination']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'showUser']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});
