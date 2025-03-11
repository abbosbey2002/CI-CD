<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\App\Http\Requests\UpdateProductRequest;
use Modules\ContentManagement\App\Models\Product;
use Modules\ContentManagement\App\Services\ProductService;

class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[ApiSwagger(summary: 'Get products', tag: 'Products')]
    #[ApiSwaggerResponse(status: 200, resource: Product::class, description: 'Successful response')]
    public function index(): JsonResponse
    {
        return response()->json($this->productService->getProducts());
    }

    #[ApiSwagger(summary: 'Update product', tag: 'Products')]
    #[ApiSwaggerRequest(UpdateProductRequest::class, description: 'Product data')]
    #[ApiSwaggerResponse(status: 200, resource: Product::class, description: 'Product updated successfully')]
    #[ApiSwaggerResponse(status: 422, description: 'Validation error')]
    public function update(UpdateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        // dd($data);
        if ($request->hasFile('file')) {

            // Storage::put( $request->file('file'));
            $data['file'] = $request->file('file')->store('files', 'public');
        }

        return response()->json($this->productService->update($data));
    }

    #[ApiSwagger(summary: 'Download product file', tag: 'Products')]
    #[ApiSwaggerResponse(status: 200, description: 'File downloaded successfully')]
    #[ApiSwaggerResponse(status: 404, description: 'File not found')]
    public function downloadFile()
    {
        // Additional permission checks can be done here if necessary

        return $this->productService->downloadProductFile();
    }
}
