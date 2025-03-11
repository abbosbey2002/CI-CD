<?php

namespace Modules\Bot\Conversations;

use SergiX44\Nutgram\Nutgram;
use Modules\UserManagement\Models\NewUser;
use Modules\UserManagement\App\Models\User;
use SergiX44\Nutgram\Conversations\Conversation;
use Modules\TariffsAndPromotions\App\Services\TariffService;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class TariffConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        // 1) set user->mode = 'in_tariffs' for top-level tracking
        $user = User::where('tg_id',$bot->userId())->first();
        if ($user) {
            $user->current_mode = 'in_tariffs';
            $user->save();
        }

        // 2) fetch tariffs
        $tariffs = app(TariffService::class)->getTariffs(['is_active' => true], 3);
        if ($tariffs->isEmpty()) {
            $bot->sendMessage("Нет доступных тарифов.");
            $this->end();
            return;
        }

        // 3) build a dynamic reply keyboard
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true);
        foreach($tariffs as $t) {
            $keyboard->addRow(KeyboardButton::make($t->title));
        }
        $keyboard->addRow(KeyboardButton::make('Назад'));

        $bot->sendMessage("Выберите тариф:", reply_markup: $keyboard);

        // 4) Next step => onTariffSelected
        $this->next('onTariffSelected');
    }

    public function onTariffSelected(Nutgram $bot)
    {
        $text = $bot->message()?->text;

        // If user typed 'Назад', end conversation + return main menu
        if ($text === 'Назад') {
            $this->goBack($bot);
            return;
        }

        // Otherwise, interpret $text as a Tariff title
        $tariff = app(TariffService::class)->getTariffByTitle($text);
        if (!$tariff) {
            $bot->sendMessage("Тариф не найден. Попробуйте снова или нажмите 'Назад'.");
            // keep same step
            return;
        }

        // Show Tariff info
        $msg = "Название: {$tariff->title}\nЦена: {$tariff->price}\nОписание: {$tariff->description}";
        $bot->sendMessage($msg);

        // conversation ends
        $this->end();
        // Optionally return user to main menu
        $this->goBack($bot);
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
