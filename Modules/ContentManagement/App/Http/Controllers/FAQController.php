<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ContentManagement\App\Http\Requests\StoreFAQRequest;
use Modules\ContentManagement\App\Http\Requests\UpdateFAQRequest;
use Modules\ContentManagement\App\Http\Resources\FAQPaginatedResource;
use Modules\ContentManagement\App\Models\FAQ;
use Modules\ContentManagement\App\Services\FAQService;

class FAQController extends Controller
{
    protected $faqService;

    public function __construct(FAQService $faqService)
    {
        $this->faqService = $faqService;
    }

    #[ApiSwagger(summary: 'Get all faqs', tag: 'FAQs')]
    #[ApiSwaggerQuery(name: 'is_active', description: 'active or not', required: false, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: FAQ::class, isPagination: true)]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function getFaqsWithPagination(Request $request)
    {
        $filter = $request->only(['is_active']);
        $limit = $request->query('per_page', 15);
        $faqs = $this->faqService->getAll($filter, $limit);

        return new FAQPaginatedResource($faqs);
    }

    #[ApiSwagger(summary: 'Get a faq', tag: 'FAQs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: FAQ::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function show($id): JsonResponse
    {
        // dd($id);
        $faq = $this->faqService->getById($id);

        return response()->json($faq);
    }

    #[ApiSwagger(summary: 'Create a new faq', tag: 'FAQs')]
    #[ApiSwaggerRequest(request: StoreFAQRequest::class, description: 'Create a new faq')]
    #[ApiSwaggerResponse(status: 201, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 422, description: 'Invalid input')]
    public function store(StoreFAQRequest $request): JsonResponse
    {
        $this->faqService->create($request->validated());

        return response()->json(['message' => 'FAQ created successfully']);
    }

    #[ApiSwagger(summary: 'Update a faq', tag: 'FAQs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerRequest(request: UpdateFAQRequest::class, description: 'Update a faq')]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function update(UpdateFAQRequest $request, $id): JsonResponse
    {
        $this->faqService->update($id, $request->validated());

        return response()->json(['message' => 'FAQ updated successfully']);
    }

    #[ApiSwagger(summary: 'Delete a faq', tag: 'FAQs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function destroy($id): JsonResponse
    {
        $this->faqService->delete($id);

        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
