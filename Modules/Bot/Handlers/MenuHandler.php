<?php

namespace Modules\Bot\Handlers;

use SergiX44\Nutgram\Nutgram;
use Modules\TariffsAndPromotions\App\Services\TariffService;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
// other modules as needed

class MenuHandler
{
    public function tariffs(Nutgram $bot)
    {
        // Retrieve tariffs from TariffService
        $tariffs = app(TariffService::class)->getTariffs(['is_active' => true], 3);

        if ($tariffs->isEmpty()) {
            $bot->sendMessage("Нет доступных тарифов.");
            return;
        }

        // Build inline keyboard
        // Build the inline keyboard
        $markup = ReplyKeyboardMarkup::make();

        // For each item, add a new row with a button
        foreach ($tariffs as $item) {
            $markup->addRow(
                KeyboardButton::make($item['title'])
            );
        }
        //Optionally add a row with "Назад"
        $markup->addRow(KeyboardButton::make('Назад'));

        // Send the message with the keyboard
        $bot->sendMessage('Список тарифов:', reply_markup: $markup);
    }

    // similarly "faqCategory", "aboutCompany", "promotions", "products", "myBalance", "ticket", "faqAll"...
}
