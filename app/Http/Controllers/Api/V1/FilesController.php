<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;

use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class FilesController extends Controller
{

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    /**
     * Display a listing of the resource.
     */

     #[ApiSwagger(summary: 'Get all files', tag: 'Files')]
     #[ApiSwaggerResponse(status: 200, resource: FileResource::class, isPagination: false)]
    public function index(): AnonymousResourceCollection
    {
        $files = $this->fileService->getAllFiles();
        return FileResource::collection($files);
    }
}
