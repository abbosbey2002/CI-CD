<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade as PDF;

class PdfService
{
    public function generatePdf($view, $data)
    {
        $pdf = PDF::loadView($view, $data);
        return $pdf->download('report.pdf');
    }
}
