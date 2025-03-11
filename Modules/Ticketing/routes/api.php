<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Ticketing\App\Http\Controllers\TicketAttachmentController;
use Modules\Ticketing\App\Http\Controllers\TicketCommentController;
use Modules\Ticketing\App\Http\Controllers\TicketController;
use Modules\Ticketing\App\Http\Controllers\TicketMessageController;

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
    Route::get('ticketing', fn (Request $request) => $request->user())->name('ticketing');
});

Route::middleware(['auth:api'])->group(function () {
    // Tickets
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    Route::put('/tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);

    // Ticket Comments
    Route::post('/tickets/{ticketId}/comments', [TicketCommentController::class, 'store']);
    Route::put('/tickets/{ticketId}/comments/{commentId}', [TicketCommentController::class, 'update']);
    Route::delete('/tickets/{ticketId}/comments/{commentId}', [TicketCommentController::class, 'destroy']);

    // Ticket Attachments
    Route::post('/tickets/{ticketId}/comments/{commentId}/attachments', [TicketAttachmentController::class, 'store']);
    // or attach to ticket directly
    //    Route::post('/tickets/{ticketId}/attachments', [TicketAttachmentController::class, 'store']);
    Route::delete('/attachments/{attachmentId}', [TicketAttachmentController::class, 'destroy']);


    // Ticket messages
    Route::get('/tickets/{ticketId}/messages', [TicketMessageController::class, 'index']);
    Route::post('/tickets/{ticketId}/messages', [TicketMessageController::class, 'store']);
    Route::put('/tickets/{ticketId}/messages/{messageId}', [TicketMessageController::class, 'update']);
    Route::delete('/tickets/{ticketId}/messages/{messageId}', [TicketMessageController::class, 'destroy']);
});
