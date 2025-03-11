<?php

namespace Modules\TariffsAndPromotions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\TariffsAndPromotions\App\Http\Requests\StoreTariffRequest;
use Modules\TariffsAndPromotions\App\Http\Requests\UpdateTariffRequest;
use Modules\TariffsAndPromotions\App\Http\Resource\TariffPaginatedResource;
use Modules\TariffsAndPromotions\App\Services\TariffService;

class TariffController extends Controller
{
    protected $tariffService;

    public function __construct(TariffService $tariffService)
    {
        $this->tariffService = $tariffService;
    }

    #[ApiSwagger(summary: 'Get all tariffs', tag: 'Tariffs')]
    #[ApiSwaggerQuery(name: 'is_active', description: 'active or not', required: false, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: TariffPaginatedResource::class, description: 'Successful response')]
    public function getTariffsByFilter(Request $request): TariffPaginatedResource
    {

        $filter = $request->only(['is_active']);
        $limit = $request->query('per_page', 15);

        $tariffs = $this->tariffService->getTariffs($filter, $limit);

        // dd(new TariffPaginatedResource($tariffs));
        return new TariffPaginatedResource($tariffs);
    }

    #[ApiSwagger(summary: 'Store a new tariff', tag: 'Tariffs')]
    #[ApiSwaggerRequest(request: StoreTariffRequest::class, description: 'Store a new tariff')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'tariff' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function store(StoreTariffRequest $request): JsonResponse
    {
        $data = $request->validated();
        // Retrieve the file if provided.
        $file = $request->file('image');

        $tariff = $this->tariffService->create($data, $file);

        return response()->json($tariff, 201);
    }

    #[ApiSwagger(summary: 'Get a tariff', tag: 'Tariffs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'tariff' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, resource: [
        'error' => 'NotFound',
    ], description: 'Not found')]
    public function show(int $id): JsonResponse
    {
        $tariff = $this->tariffService->getById($id);

        return response()->json($tariff);
    }

    #[ApiSwagger(summary: 'Update a tariff', tag: 'Tariffs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerRequest(request: UpdateTariffRequest::class, description: 'Update a tariff')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'tariff' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function update(UpdateTariffRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        // Retrieve the file if provided.
        $file = $request->file('image');

        $tariff = $this->tariffService->update($id, $data, $file);

        return response()->json($tariff);
    }

    #[ApiSwagger(summary: 'Delete a tariff', tag: 'Tariffs')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, resource: [
        'error' => 'NotFound',
    ], description: 'Not found')]
    public function destroy($id): JsonResponse
    {
        $this->tariffService->delete($id);

        return response()->json(['message' => 'Tariff deleted successfully']);
    }
}
