<?php

namespace App\Imports;

use App\Models\Reports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportImport implements ToModel, WithHeadingRow, WithStartRow
{
    public function __construct()
    {
        Reports::query()->truncate();
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
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if (empty($row['data']) || empty($row['dokument']) || empty($row['kontragent']) || empty($row['telefon'])) {
            return null;
        }


         $report = new Reports();
         $report->date = Carbon::parse($row['data']);
         $report->document = trim($row['dokument']);
         $report->contragent = trim($row['kontragent']);
         $report->phone = $row['telefon'];
         $report->contragent_tin = $row['inn'] ? trim($row['inn']) : "";
         $report->outcome =  floatval(str_replace(',', '', $row['summa_debit'] ?? 0));
         $report->income = floatval(str_replace(',', '', $row['summa_kredit'] ?? 0));
         $report->last_update = now();
         $report->save();

        return $report;
    }
}
