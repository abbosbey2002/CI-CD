<?php

namespace Modules\Bot\Conversations;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\Conversation;
use Modules\Ticketing\App\Models\Ticket;
use Modules\UserManagement\App\Models\User;
use Modules\Ticketing\App\Models\TicketMessage;
use Modules\Ticketing\App\Events\TicketMessageCreated;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;


class TicketConversation extends Conversation
{
    protected $name;
    protected ?Ticket $ticket = null;
    protected $description;

    public function start(Nutgram $bot)
    {
        $this->name = $bot->message()->text;

        $chatId = $bot->chat()->id;
        $user = User::where('tg_id', $chatId)->first();

        if (!$user) {
            $bot->sendMessage("❌ Siz tizimda ro‘yxatdan o‘tmagansiz!");
            return $this->end();
        }

        $this->ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => $this->name,
            'description' => $this->description,
            'status' => 'open',
        ]);



        $markup->addRow(KeyboardButton::make('Назад'));

        $bot->sendMessage("✍️  Muammo haqida batafsil yozing:", reply_markup: $markup);

        $this->next('askDescription');
    }

        public function askDescription(Nutgram $bot)
        {

            if( $bot->message()->text == 'Назад' ) {
                $this->end();
                $this->goBack($bot);
                return;
            }


            $description = $bot->message()->text;

            $ticketMessage = new TicketMessage();
            $ticketMessage->ticket_id = $this->ticket->id;
            $ticketMessage->sender_type = 'user';
            $ticketMessage->message = $description;
            $ticketMessage->save();

        event(new TicketMessageCreated($ticketMessage));

        $this->next('askDescription');
    }

    public function confirmTicket(Nutgram $bot)
    {

        $this->end();
    }

    private function goBack(Nutgram $bot)
    {
        // If you want to set mode='main_menu' in DB:
        $user = User::where('tg_id',$bot->userId())->first();
        if ($user) {
            $user->current_mode = 'main_menu';
            $user->save();
        }

        // Re-show main menu. Maybe call a static method or StartHandler
        app(\Modules\Bot\Handlers\StartHandler::class)->goToMainMenu($bot, $user);
    }
}
