<?php

namespace Modules\Bot\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;
use SergiX44\Nutgram\Nutgram;
use Modules\Bot\Conversations\TicketConversation;

class BotController extends Controller
{
    public function webhook(Request $request)
    {
        $bot = app(Nutgram::class);
        
        // $bot->onCommand('start', function (Nutgram $bot) {
        //     $bot->sendMessage("🎟 Assalomu alaykum! Ticket yaratishingiz yoki ko‘rishingiz mumkin.");
        // });
        

        $bot->run();
        
        return Response::json(['status' => 'success']);
    }
}
