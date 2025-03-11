<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('ticket.{id}', function ($user, $id) {
//     // Here, you can authorize based on your logic.
//     // For example, allow any authenticated user or check specific roles.
//     return true;
// });


// Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
//     return Ticket::where('id', $ticketId)->exists();
// });

Broadcast::channel('ticket.{ticketId}', fn() => true);
