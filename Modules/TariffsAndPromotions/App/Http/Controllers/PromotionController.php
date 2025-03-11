<?php

namespace Modules\TariffsAndPromotions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\Request;
use Modules\TariffsAndPromotions\App\Http\Requests\StorePromotionRequest;
use Modules\TariffsAndPromotions\App\Http\Requests\UpdatePromotionRequest;
use Modules\TariffsAndPromotions\App\Http\Resource\PromotionPaginatedResource;
use Modules\TariffsAndPromotions\App\Services\PromotionService;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    #[ApiSwagger(summary: 'Get all promotions', tag: 'Promotions')]
    #[ApiSwaggerQuery(name: 'is_active', description: 'active or not', required: false, isId: false)]

    #[ApiSwaggerResponse(status: 200, resource: PromotionPaginatedResource::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, resource: [
        'error' => 'NotFound',
    ], description: 'Not found')]
    public function getPromotionsByFilters(Request $request): PromotionPaginatedResource
    {
        $filters = $request->only(['is_active']);
        $limit = $request->query('per_page', 15);
        $promotions = $this->promotionService->getAllWithFilters($filters, $limit);

        return new PromotionPaginatedResource($promotions);
    }

    #[ApiSwagger(summary: 'Store a new promotion', tag: 'Promotions')]
    #[ApiSwaggerRequest(request: StorePromotionRequest::class, description: 'Store a new promotion')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'promotion' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function store(StorePromotionRequest $request)
    {
        $data = $request->validated();
        $file = $request->file('image');

        return response()->json($this->promotionService->create($data, $file), 201);
    }

    #[ApiSwagger(summary: 'Get a promotion', tag: 'Promotions')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'promotion' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function show($id)
    {
        return response()->json($this->promotionService->getById($id));
    }

    #[ApiSwagger(summary: 'Update a promotion', tag: 'Promotions')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerRequest(request: UpdatePromotionRequest::class, description: 'Update a promotion')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'promotion' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function update(UpdatePromotionRequest $request, $id)
    {

        $data = $request->validated();
        $file = $request->file('image');

        return response()->json($this->promotionService->update($id, $data, $file));

    }

    #[ApiSwagger(summary: 'Delete a promotion', tag: 'Promotions')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function destroy($id)
    {
        $this->promotionService->delete($id);

        return response()->json(['message' => 'Promotion deleted successfully']);
    }
}
