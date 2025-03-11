<?php

namespace Modules\Bot\Handlers;

use SergiX44\Nutgram\Nutgram;
use Modules\UserManagement\App\Models\User;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartHandler
{
    /**
     * Handle the /start command.
     */
    public function start(Nutgram $bot)
    {
        $tgId = $bot->userId();

        // Find or create user in new_users
        $user = User::firstOrCreate(['tg_id' => $tgId], [
            'role' => 'user', // default role
            'name' => "User $tgId",
        ]);

        // If user->phone is null, request phone
        if (!$user->phone) {
            // Build reply keyboard with contact request
            $contactBtn = KeyboardButton::make('Поделиться телефоном');
            $contactBtn->request_contact = true;

            $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true)
                ->addRow($contactBtn);

            $bot->sendMessage(
                text: 'Здравствуйте! Пожалуйста, поделитесь вашим номером телефона:',
                reply_markup: $keyboard
            );

            // Optionally set mode "waiting_for_phone"
            $user->current_mode = 'waiting_for_phone';
            $user->save();
        } else {
            // Already have phone, show main menu
            $bot->sendMessage('Добро пожаловать! Ваш номер уже сохранён.');
            $this->goToMainMenu($bot, $user);
        }
    }

    /**
     * Called when user shares contact
     */
    public function savePhone(Nutgram $bot)
    {
        $contact = $bot->message()?->contact;
        if (!$contact) {
            $bot->sendMessage("Не удалось получить номер телефона. Попробуйте еще раз.");
            return;
        }

        $phoneNumber = $contact->phone_number;
        $tgId = $bot->userId();

        $user = User::where('tg_id', $tgId)->first();
        if (!$user) {
            $bot->sendMessage("Ошибка: не могу найти пользователя в базе.");
            return;
        }

        // Save phone
        $user->phone = $phoneNumber;
        // Clear or set mode, e.g. to "main_menu"
        $user->current_mode = 'main_menu'; 
        $user->save();

        $bot->sendMessage("Спасибо! Ваш телефон сохранён: $phoneNumber");

        // Now show main menu
        $this->goToMainMenu($bot, $user);
    }

    /**
     * Show main menu with a reply keyboard
     */
    public function goToMainMenu(Nutgram $bot, User $user)
    {
        // Build a reply keyboard with your main menu items
        // For example:
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make('Тарифы'),
                KeyboardButton::make('FAQ category')
            )
            ->addRow(
                KeyboardButton::make('О компании'),
                KeyboardButton::make('Акции')
            )
            ->addRow(
                KeyboardButton::make('Продукты'),
                KeyboardButton::make('Мой Баланс')
            )
            ->addRow(
                KeyboardButton::make('Тикет'),
                KeyboardButton::make('FAQ')
            );

        $bot->sendMessage(
            text: 'Главное меню. Выберите действие:',
            reply_markup: $keyboard
        );
    }
}
