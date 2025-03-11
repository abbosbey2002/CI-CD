<?php


namespace Modules\Bot\App\Services;

use Modules\Ticketing\App\Models\TicketMessage;
use SergiX44\Nutgram\Nutgram;

class TicketResponseToUser
{
    protected Nutgram $bot;

    public function __construct()
    {
        $this->bot = new Nutgram(env('TELEGRAM_BOT_TOKEN'));
    }
    public function send(TicketMessage $ticketMessage): void
    {
        $user = $ticketMessage->ticket->user;

        if ($user && $user->tg_id) {
            $this->bot->sendMessage(
                chat_id: $user->tg_id,
                text: "📨 Sizga yangi javob berildi:\n\n{$ticketMessage->message}"
            );
        }
    }
}
