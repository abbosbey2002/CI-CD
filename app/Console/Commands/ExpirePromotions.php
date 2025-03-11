<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\TariffsAndPromotions\App\Models\Promotion;

class ExpirePromotions extends Command
{
    protected $signature = 'promotions:expire';
    protected $description = 'Mark expired promotions as inactive';

    public function handle()
    {
        $expiredPromotions = Promotion::where('is_active', true)
            ->whereDate('date_to', '<', now()->toDateString()) // ✅ Sana formatida solishtirish
            ->update(['is_active' => false]);

        $this->info("✅ Expired $expiredPromotions promotions.");
    }
}
