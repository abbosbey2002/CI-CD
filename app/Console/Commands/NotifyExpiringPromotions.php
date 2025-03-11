<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUserAboutPromotion;
use App\Models\User;
use Illuminate\Console\Command;
use Modules\TariffsAndPromotions\App\Models\Promotion;

class NotifyExpiringPromotions extends Command
{
    protected $signature = 'promotions:notify-expiring';

    protected $description = 'Notify users about promotions expiring in 1 day';

    public function handle()
    {
        $promotions = Promotion::where('is_active', true)
            ->whereDate('date_to', '=', now()->addDay()->toDateString())
            ->get();

        foreach ($promotions as $promotion) {
            // $users = $promotion->subscribedUsers(); // Assume this method exists to get users
            $users = User::all();
            foreach ($users as $user) {
                NotifyUserAboutPromotion::dispatch($promotion, $user->telegram_id);
            }
        }

        $this->info('Notifications for expiring promotions have been dispatched.');
    }
}
