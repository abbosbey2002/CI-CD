<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ContentManagement\App\Http\Requests\StoreNewsRequest;
use Modules\ContentManagement\App\Http\Requests\UpdateNewsRequest;
use Modules\ContentManagement\App\Http\Resources\NewsPaginatedResource;
use Modules\ContentManagement\App\Models\News;
use Modules\ContentManagement\App\Services\NewsService;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    #[ApiSwagger(summary: 'Get all news', tag: 'News')]
    #[ApiSwaggerQuery(name: 'is_active', description: 'active or not', required: false, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: News::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function getNewsWithFilter(Request $request): NewsPaginatedResource
    {
        $filter = $request->only(['is_active']);
        $limit = $request->query('per_page', 15);
        $data = $this->newsService->getAll($filter, $limit);

        return new NewsPaginatedResource($data);
    }

    #[ApiSwagger(summary: 'Store news', tag: 'News')]
    #[ApiSwaggerRequest(StoreNewsRequest::class, description: 'News data')]
    #[ApiSwaggerResponse(status: 201, resource: News::class, description: 'News created successfully')]
    #[ApiSwaggerResponse(status: 422, description: 'Validation error')]
    public function store(StoreNewsRequest $request): JsonResponse
    {
        // dd($request->all());
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        return response()->json($this->newsService->create($data), 201);
    }

    #[ApiSwagger(summary: 'Get news by id', tag: 'News')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: News::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function show($id): JsonResponse
    {
        return response()->json($this->newsService->getById($id));
    }

    #[ApiSwagger(summary: 'Update news', tag: 'News')]
    #[ApiSwaggerRequest(UpdateNewsRequest::class, description: 'News data')]
    #[ApiSwaggerResponse(status: 200, resource: News::class, description: 'News updated successfully')]
    #[ApiSwaggerResponse(status: 422, description: 'Validation error')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function update(UpdateNewsRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        return response()->json($this->newsService->update($id, $data));
    }

    #[ApiSwagger(summary: 'Delete news', tag: 'News')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, description: 'Not found')]
    public function destroy($id): JsonResponse
    {
        $this->newsService->delete($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
