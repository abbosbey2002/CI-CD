<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\TariffsAndPromotions\App\Models\Promotion;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyUserAboutPromotion implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $promotion;

    protected $userTelegramId;

    public function __construct(Promotion $promotion, $userTelegramId)
    {
        $this->promotion = $promotion;
        $this->userTelegramId = $userTelegramId;
    }

    public function handle()
    {
        $message = "⏰ Reminder: The promotion \"{$this->promotion->title}\" will expire on {$this->promotion->date_to}.\n"
            ."Don't miss out on this opportunity!";

        // Telegram::sendMessage([
        //     'chat_id' => $this->userTelegramId,
        //     'text' => $message,
        // ]);
    }
}
