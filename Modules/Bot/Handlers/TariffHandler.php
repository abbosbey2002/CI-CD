<?php

namespace Modules\Bot\Handlers;

use SergiX44\Nutgram\Nutgram;
use Modules\TariffsAndPromotions\App\Services\TariffService;

class TariffHandler
{
    protected TariffService $tariffService;

    public function __construct(TariffService $tariffService)
    {
        $this->tariffService = $tariffService;
    }

    public function showTariff(Nutgram $bot, int $tariffId)
    {
        $tariff = $this->tariffService->getById($tariffId);
        if (!$tariff) {
            $bot->sendMessage('Тариф не найден.');
            return;
        }
        $msg = "Название: {$tariff->title}\nЦена: {$tariff->price}\nОписание: {$tariff->description}";
        $bot->sendMessage($msg);
    }
}
