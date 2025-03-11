<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;

use App\Services\ImportSheets;
use App\Services\FileService;

class ReportsController extends Controller
{
    protected ImportSheets $importSheets;
    protected FileService $fileService;

    public function __construct(ImportSheets $importSheets, FileService $fileService)
    {
        $this->importSheets = $importSheets;
        $this->fileService = $fileService;

    }



    #[ApiSwagger(summary: 'Import reports', tag: 'Reports')]
    #[ApiSwaggerRequest(request: ReportRequest::class, description: 'Import reports')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]

    public function import(ReportRequest $request)
    {

        $title = "Report";


        $filePath =  $this->fileService->createFile($request->file('file'), $title = 'Report');


        $this->importSheets->UploadFile($filePath);

        return response()->json([
            'message' => '✅ Акт-Сверки (Report) ma’lumotlari yuklandi!'
        ], 200);
    }
}

