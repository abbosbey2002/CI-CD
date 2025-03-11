<?php

namespace App\Services;

use App\Models\Balance;
use App\Models\Reports;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BalanceService
{
    /**
     * Foydalanuvchi balansini hisoblash.
     *
     * @param string $phone Foydalanuvchi telefon raqami
     * @return object
     */
    public function getBalance($phone)
    {
        $totalBalance = 0;
        $totalBonus = 0;
        $contragent = null;

      $balances = Balance::query()
            ->where('phone', $phone)
            ->orderBy('id')
            ->chunk(1000, function ($balances) use (&$totalBalance, &$totalBonus, &$contragent) {
                foreach ($balances as $balance) {
                    $totalBalance += ($balance->outcome - $balance->income);
                    $totalBonus += $balance->bonus;

                    // ✅ Birinchi "contragent" ni olish
                    if (!$contragent && $balance->contragent) {
                        $contragent = $balance->contragent;
                    }
                }
            });


            if ($totalBalance === 0) {
                Log::info('Found balances: ' . $totalBalance);
                return null;
            }


        // ✅ Natijani qaytarish
        return (object)[
            'contragent' => $contragent,
            'total_balance' => $totalBalance,
            'total_bonus' => $totalBonus
        ];
    }

    /**
     * Акт-Сверки bo‘yicha PDF yaratish.
     *
     * @return string PDF fayl yo‘li
     */
    public function generatePdf($phone)
{
    try {
        // ✅ Timeout boshlash
        $timeout = 5; // sekund
        $startTime = microtime(true);

        $limit = 500;

        $reports = Reports::query()
        ->where('phone', $phone)
        ->select('date', 'document', 'outcome', 'income', 'contragent', 'contragent_tin')
        ->orderBy('date', 'desc')
        ->limit($limit)
        ->get();

        $totalReports = $reports->count();

        $exceededLimit = $totalReports > $limit;

        // ✅ Agar hech qanday ma’lumot bo‘lmasa, PDF yaratmaslik
        if ($reports->isEmpty()) {
            return null;
        }

        // ✅ PDF yaratish
        $pdf = Pdf::loadView('pdf.balance_report', compact('reports'))->setPaper('a3', 'landscape');

        // ✅ Timeout tekshirish (agar 5 sek ichida bajarilmasa)
        if ((microtime(true) - $startTime) > $timeout) {
            Log::error("❌ PDF генерация заняла слишком много времени (> {$timeout} сек)");
            return null;
        }

        // ✅ Faylni nomlash
        $fileName = 'Акт_сверки_' . now()->format('Ymd_His') . '.pdf';
        $filePath = 'public/pdf/' . $fileName;

        // ✅ Faylni saqlash
        Storage::put($filePath, $pdf->output());

        // ✅ Fayl yo‘lini qaytarish
        return [
            'file_path' => Storage::path($filePath),
            'exceeded_limit' => $exceededLimit
        ];

    } catch (\Exception $e) {
        Log::error("❌ Ошибка при генерации PDF: " . $e->getMessage());
        return null;
    }
}

public function generaincomePdf($phone)
{
    try {
        // ✅ Timeout boshlash
        $timeout = 5; // sekund
        $startTime = microtime(true);

        $limit = 500;


        $reports = Reports::query()
        ->where('phone', $phone)
        ->select('date', 'document', 'income', 'contragent', 'contragent_tin')
        ->where('income', '>', 0) // ✅ income = 0 bo'lganlarni chiqarib tashlaydi
        ->orderBy('date', 'desc')
        ->limit($limit)
        ->get();

        $totalReports = $reports->count();

        $exceededLimit = $totalReports > $limit;


        // ✅ Agar hech qanday ma’lumot bo‘lmasa, PDF yaratmaslik
        if ($reports->isEmpty()) {
            return null;
        }

        // ✅ PDF yaratish
        $pdf = Pdf::loadView('pdf.balance_income', compact('reports'))->setPaper('a3', 'landscape');

        // ✅ Timeout tekshirish (agar 5 sek ichida bajarilmasa)
        if ((microtime(true) - $startTime) > $timeout) {
            Log::error("❌ PDF генерация заняла слишком много времени (> {$timeout} сек)");
            return null;
        }

        // ✅ Faylni nomlash
        $fileName = 'Приход_денег_' . now()->format('Ymd_His') . '.pdf';
        $filePath = 'public/pdf/' . $fileName;

        // ✅ Faylni saqlash
        Storage::put($filePath, $pdf->output());

        // ✅ Fayl yo‘lini qaytarish
        return [
            'file_path' => Storage::path($filePath),
            'exceeded_limit' => $exceededLimit
        ];

    } catch (\Exception $e) {
        Log::error("❌ Ошибка при генерации PDF: " . $e->getMessage());
        return null;
    }
}

}
