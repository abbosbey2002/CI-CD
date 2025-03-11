<?php

namespace App\Imports;

use App\Models\Balance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;

class BalanceImport implements ToModel, WithHeadingRow, WithStartRow
{
    public function __construct()
    {
        Balance::query()->truncate(); // ✅ Model orqali truncate qilish
    }
    /**
     * Ustun nomlari qaysi qatorda ekanligini belgilash
     */
    public function headingRow(): int
    {
        return 3; // ✅ 3-qator ustun nomlari uchun
    }

    /**
     * Import qatorlari qaysi qatordan boshlanishini belgilash
     */
    public function startRow(): int
    {
        return 4; // ✅ 4-qatordan boshlab ma’lumotlar yuklanadi
    }

    /**
     * Excel ma’lumotlarini `balances` jadvaliga yuklash
     */
    public function model(array $row)
    {

        try {
            return new Balance([
                'contragent' => trim($row['kontragent']),
                'outcome' => floatval(str_replace(',', '', $row['summa_debit'] ?? 0)),
                'income' => floatval(str_replace(',', '', $row['summa_kredit'] ?? 0)),
                'bonus' => 500,
                'phone' => "+998999999999",
                'last_update' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Balance import error: ' . $e->getMessage());
            return null;
        }
    }
}
