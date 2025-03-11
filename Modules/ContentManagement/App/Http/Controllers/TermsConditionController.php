<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Modules\ContentManagement\App\Http\Requests\StoreTermsConditionRequest;
use Modules\ContentManagement\App\Models\TermsCondition;
use Modules\ContentManagement\App\Services\TermsConditionService;

class TermsConditionController extends Controller
{
    protected $termsConditionService;

    public function __construct(TermsConditionService $termsConditionService)
    {
        $this->termsConditionService = $termsConditionService;
    }

    #[ApiSwagger(summary: 'Get all terms and conditions', tag: 'Terms and Conditions')]
    #[ApiSwaggerResponse(status: 200, resource: TermsCondition::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function index(): JsonResponse
    {
        return response()->json($this->termsConditionService->getAll());
    }

    #[ApiSwagger(summary: 'Create a new terms and conditions', tag: 'Terms and Conditions')]
    #[ApiSwaggerRequest(request: StoreTermsConditionRequest::class, description: 'Create a new terms and conditions')]
    #[ApiSwaggerResponse(status: 201, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 422, description: 'Invalid input')]
    public function store(StoreTermsConditionRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('files', 'public');
        }

        return response()->json($this->termsConditionService->create($data), 201);
    }

    #[ApiSwagger(summary: 'Get terms and conditions by id', tag: 'Terms and Conditions')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: TermsCondition::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function show($id): JsonResponse
    {
        return response()->json($this->termsConditionService->getById($id));
    }

    #[ApiSwagger(summary: 'Update terms and conditions', tag: 'Terms and Conditions')]
    #[ApiSwaggerRequest(request: StoreTermsConditionRequest::class, description: 'Update terms and conditions')]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 422, description: 'Invalid input')]
    public function update(StoreTermsConditionRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('files', 'public');
        }

        return response()->json($this->termsConditionService->update($id, $data));
    }

    #[ApiSwagger(summary: 'Delete terms and conditions', tag: 'Terms and Conditions')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function destroy($id): JsonResponse
    {
        $this->termsConditionService->delete($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
