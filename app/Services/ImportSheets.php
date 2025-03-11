<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BalanceImport;

class ImportSheets
{
    public function UploadFile($filePath)
    {
        Excel::import(new BalanceImport, storage_path('app/public/' . $filePath));
    }
}
