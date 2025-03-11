<?php


use App\Http\Controllers\Telegram\MenuController;
use SergiX44\Nutgram\Nutgram;

$bot->onCommand('start', [MenuController::class, 'showMainMenu']);
$bot->onText('My balance', [MenuController::class, 'showBalanceMenu']);
$bot->onCallbackQueryData('balance_detail', [MenuController::class, 'balanceDetail']);
$bot->onCallbackQueryData('balance_topup', [MenuController::class, 'balanceTopup']);
$bot->onCallbackQueryData('balance_history', [MenuController::class, 'balanceHistory']);
