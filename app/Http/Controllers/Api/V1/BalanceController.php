<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\Balance\BalanceRequest;
use App\Http\Controllers\Controller;

use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;

use App\Services\ImportSheets;
use App\Services\FileService;


/**
 * Class BalanceController
 * @package App\Http\Controllers
 */
class BalanceController extends Controller
{
    protected ImportSheets $importSheets;
    protected FileService $fileService;
    public function __construct(ImportSheets $importSheets, FileService $fileService)
    {
        $this->importSheets = $importSheets;
        $this->fileService = $fileService;

    }


    #[ApiSwagger(summary: 'Import balance', tag: 'Balance')]
    #[ApiSwaggerRequest(request: BalanceRequest::class, description: 'Import balance')]
    public function import(BalanceRequest $request): \Illuminate\Http\JsonResponse
    {
        $title = "Balance";

        $filePath =  $this->fileService->createFile($request->file('file'), $title = 'Balance');

        $this->importSheets->UploadFile($filePath);

        return response()->json([
            'message' => '✅ Мой баланс (Balance) ma’lumotlari yuklandi!'
        ], 200);

    }
}
