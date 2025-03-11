<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Bot\App\Http\Controllers\BotController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('bot', fn (Request $request) => $request->user())->name('bot');
});


Route::post('bot-webhook', [BotController::class, 'webhook']);


// curl -X POST "https://api.telegram.org/8021915861:AAHOAoAC7TuCyuxUTZZHuojOLfFrYRn2HdA/setWebhook?url=https://kind-relevant-oyster.ngrok-free.app/api/bot-webhook/"
