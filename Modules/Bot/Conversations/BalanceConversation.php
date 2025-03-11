<?php

namespace Modules\Bot\Conversations;

use App\Services\BalanceService;
use Modules\UserManagement\App\Models\User;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use Illuminate\Support\Facades\Log;


class BalanceConversation extends Conversation
{
    protected BalanceService $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    public function start(Nutgram $bot)
{
    $markup = ReplyKeyboardMarkup::make(resize_keyboard: true)
        ->addRow(
            KeyboardButton::make('Мой баланс'),
            KeyboardButton::make('Приход денег'),
            KeyboardButton::make('Акт сверки'),
        )
        ->addRow(KeyboardButton::make('Назад'));

    $bot->sendMessage('Выберите действие:', reply_markup: $markup);
    $this->next('handleUserSelection');
}


    public function handleUserSelection(Nutgram $bot)
    {
        $text = $bot->message()->text;

        $user = User::where('tg_id',$bot->userId())->first();

        match ($text) {
            'Мой баланс' => $this->sendBalance($bot,  $user->phone),
            'Акт сверки' => $this->sendReport($bot, $user->phone),
            'Приход денег' => $this->income($bot, $user->phone),
            'Назад' => $this->goBack($bot),
            default => $bot->sendMessage('❌ Неверный выбор. Пожалуйста, выберите действие из меню.')
        };
    }

    public function income(Nutgram $bot, $phone)
    {
        $bot->sendMessage('📄 Генерируем ваш отчет...');

        $pdfData = $this->balanceService->generaincomePdf($phone);

        if(!$pdfData){
            $bot->sendMessage("💰 *Ваш баланс:*\n" .
            "Извините, у вас нет баланса.\n",
             parse_mode: 'Markdown'
            );

            $this->next('handleUserSelection');
        }else{

            Log::info($pdfData);
            if (file_exists($pdfData['file_path'])) {
                $bot->sendDocument(InputFile::make($pdfData['file_path']),  caption : 'Ваш отчет');

            } else {
                $bot->sendMessage('❌ Ошибка при генерации PDF.');
            }

            if ($pdfData['exceeded_limit']) {
                $bot->sendMessage("⚠️ Внимание! Ваш отчет содержит более 500 записей. Для получения полного отчета обратитесь к вашему менеджеру.");
            }
        }

        $this->next('handleUserSelection'); // ✅ Keyingi harakatga o‘tish
    }

    private function sendBalance(Nutgram $bot, $phone)
    {
        $userId = $bot->userId();
        $balance = $this->balanceService->getBalance($phone);

        if(!$balance){

            $bot->sendMessage("💰 *Ваш баланс:*\n" .
            "Извините, у вас нет баланса.\n",
             parse_mode: 'Markdown'
            );

            $this->next('handleUserSelection');
        }else{
            $bot->sendMessage("💰 *Ваш баланс:*\n" .
            "🏢 *" . $balance->contragent . "*\n".
            "📊 Баланс: *" . number_format($balance->total_balance, 2, ',', ' ') . " сум*\n" .
            "🎁 Бонусы: *" . number_format($balance->total_bonus, 2, ',', ' ') . " сум*",
             parse_mode: 'Markdown'
        );
        }



        $this->next('handleUserSelection');
    }

    private function sendReport(Nutgram $bot, $phone)
    {
        $bot->sendMessage('📄 Генерируем ваш отчет...');

        $pdfData = $this->balanceService->generatePdf($phone);

        if(!$pdfData){
            $bot->sendMessage("💰 *Ваш баланс:*\n" .
            "Извините, у вас нет баланса.\n",
             parse_mode: 'Markdown'
            );

            $this->next('handleUserSelection');
        }else{

            if (file_exists($pdfData['file_path'])) {
                $bot->sendDocument(InputFile::make($pdfData['file_path']),  caption : 'Ваш отчет');

            } else {
                $bot->sendMessage('❌ Ошибка при генерации PDF.');
            }

            if ($pdfData['exceeded_limit']) {
                $bot->sendMessage("⚠️ Внимание! Ваш отчет содержит более 500 записей. Для получения полного отчета обратитесь к вашему менеджеру.");
            }

        }

        $this->next('handleUserSelection'); // ✅ Keyingi harakatga o‘tish
    }

    private function goBack(Nutgram $bot)
    {
        $user = User::where('tg_id', $bot->userId())->first();
        if ($user) {
            $user->current_mode = 'main_menu';
            $user->save();
        }

        app(\Modules\Bot\Handlers\StartHandler::class)->goToMainMenu($bot, $user);
        $this->end();
    }
}
