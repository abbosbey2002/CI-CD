<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\Request;
use Modules\ContentManagement\App\Http\Requests\ContactBranchRequest;
use Modules\ContentManagement\App\Http\Requests\UpdateContactBranchRequest;
use Modules\ContentManagement\App\Http\Resources\ContactBranchPaginatedResource;
use Modules\ContentManagement\App\Models\ContactBranch;
use Modules\ContentManagement\App\Services\ContactBranchService;

class ContactBranchController extends Controller
{
    protected $service;

    public function __construct(ContactBranchService $service)
    {
        $this->service = $service;
    }

    #[ApiSwagger(summary: 'Get all branches', tag: 'Branches')]
    // #[ApiSwaggerQuery()]
    #[ApiSwaggerResponse(status: 200, resource: ContactBranch::class, description: 'Successful response')]

    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Unauthenticated')]
    public function index(Request $request): ContactBranchPaginatedResource
    {

        $perPage = $request->query('per_page', 15);

        // Optionally validate the per_page value
        if (! is_numeric($perPage) || $perPage <= 0) {
            $perPage = 15;
        }

        $contactAndBranches = $this->service->getAllBranches($perPage);

        return new ContactBranchPaginatedResource($contactAndBranches);
    }

    #[ApiSwagger(summary: 'Get a branch', tag: 'Branches')]
    #[ApiSwaggerQuery(name: 'contact_branch', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'branch' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function show($id)
    {
        return response()->json($this->service->getBranch($id));
    }

    #[ApiSwagger(summary: 'Store a new branch', tag: 'Branches')]
    #[ApiSwaggerRequest(request: ContactBranchRequest::class, description: 'Store a new branch')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'branch' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function store(ContactBranchRequest $request)
    {
        return response()->json($this->service->createBranch($request->validated()), 201);
    }

    #[ApiSwagger(summary: 'Update a branch', tag: 'Branches')]
    #[ApiSwaggerQuery(name: 'contact_branch', required: true, isId: true)]
    #[ApiSwaggerRequest(request: UpdateContactBranchRequest::class, description: 'Update a branch')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'branch' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function update(UpdateContactBranchRequest $request, $id)
    {
        return response()->json($this->service->updateBranch($id, $request->validated()));
    }

    #[ApiSwagger(summary: 'Delete a branch', tag: 'Branches')]
    #[ApiSwaggerQuery(name: 'contact_branch', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
    ], description: 'Unauthorized')]
    public function destroy($id)
    {
        $this->service->deleteBranch($id);

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
