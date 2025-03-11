<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ContentManagement\App\Http\Requests\StoreFAQCategoryRequest;
use Modules\ContentManagement\App\Http\Requests\UpdateFAQCategoryRequest;
use Modules\ContentManagement\App\Http\Resources\FAQCategoryPaginatedResource;
use Modules\ContentManagement\App\Models\FAQCategory;
use Modules\ContentManagement\App\Services\FAQCategoryService;

class FAQCategoryController extends Controller
{
    protected $faqCategoryService;

    public function __construct(FAQCategoryService $faqCategoryService)
    {
        $this->faqCategoryService = $faqCategoryService;
    }

    #[ApiSwagger(summary: 'Get all faq categories', tag: 'FAQ Categories')]
    #[ApiSwaggerQuery(name: 'is_active', description: 'active or not', required: false, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: FAQCategory::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function index(Request $request): FAQCategoryPaginatedResource
    {
        $filter = $request->only(['is_active']);
        $limit = $request->query('per_page', 15);

        return new FAQCategoryPaginatedResource($this->faqCategoryService->getAll($filter, $limit));
    }

    #[ApiSwagger(summary: 'Get a faq category', tag: 'FAQ Categories')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: FAQCategory::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function show($id): JsonResponse
    {
        return response()->json($this->faqCategoryService->getById($id), 201);
    }

    #[ApiSwagger(summary: 'Create a faq category', tag: 'FAQ Categories')]
    #[ApiSwaggerRequest(request: StoreFAQCategoryRequest::class, description: 'Create a faq category')]
    #[ApiSwaggerResponse(status: 201, resource: FAQCategory::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 422, description: 'Unexpected parameters')]
    public function store(StoreFAQCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('faq_categories', 'public');
        }

        return response()->json($this->faqCategoryService->create($data), 201);
    }

    #[ApiSwagger(summary: 'Update a faq category', tag: 'FAQ Categories')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerRequest(request: UpdateFAQCategoryRequest::class, description: 'Update a faq category')]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    #[ApiSwaggerResponse(status: 422, description: 'Unexpected parameters')]
    public function update(UpdateFAQCategoryRequest $request, $id): JsonResponse
    {
        $allowedKeys = ['title', 'description', 'image', 'parent_category_id', 'is_active',"_method"];
        $extraKeys = array_diff(array_keys($request->all()), $allowedKeys);

        if (! empty($extraKeys)) {
            return response()->json([
                'error' => 'Unexpected parameters: '.implode(', ', $extraKeys),
            ], 422);
        }

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('faq_categories', 'public');
        }

        $this->faqCategoryService->update($id, $validatedData);

        return response()->json(['message' => 'FAQ category updated successfully']);
    }

    #[ApiSwagger(summary: 'Delete a faq category', tag: 'FAQ Categories')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function destroy($id): JsonResponse
    {
        $this->faqCategoryService->delete($id);

        return response()->json(['message' => 'FAQ category deleted successfully']);
    }
}
