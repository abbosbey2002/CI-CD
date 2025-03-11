<?php

namespace Modules\UserManagement\App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use Modules\UserManagement\App\Models\User;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Modules\UserManagement\App\Services\UserService;
use Modules\UserManagement\App\Http\Requests\UserStoreRequest;
use Modules\UserManagement\App\Http\Requests\UserUpdateRequest;
use Modules\UserManagement\App\Http\Resources\UsersPaginatedResource;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[ApiSwagger(summary: 'Get users by pagination', tag: 'Auth Admin')]
    //    #[ApiSwaggerRequest(Request::class)]
    #[ApiSwaggerQuery(name: 'role', description: 'Role of the user', required: false, isId: false)]
    #[ApiSwaggerQuery(name: 'type', description: 'Type of the user', required: false, isId: false)]
    #[ApiSwaggerQuery(name: 'name', description: 'Name of the user', required: false, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: User::class, isPagination: true)]
    #[ApiSwaggerResponse(status: 400, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Bad Request')]
    public function getUsersByPagination(Request $request): UsersPaginatedResource
    {
        // Gather possible filters
        $filters = [
            'role' => $request->query('role'),
            'type' => $request->query('type'),
            'name' => $request->query('name'),
        ];
        // Limit per page
        $limit = $request->query('per_page', 15);

        $users = $this->userService->getUsersByPagination($filters, $limit);

        return new UsersPaginatedResource($users);
    }

    #[ApiSwagger(summary: 'Store a new user', tag: 'Auth Users')]
    #[ApiSwaggerRequest(request: UserStoreRequest::class, description: 'Store a new user')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'user' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 400, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Bad Request')]
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->createUser($data);

        return response()->json($user, 201);
    }

    /**
     * Update existing user by ID.
     */
    #[ApiSwagger(summary: 'Update a user', tag: 'Auth Users')]
    #[ApiSwaggerRequest(request: UserUpdateRequest::class, description: 'Update a user')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'user' => 'object',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 400, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Bad Request')]
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $user = $this->userService->updateUser($id, $data);

        return response()->json($user);
    }

    #[ApiSwagger(summary: 'Delete a user', tag: 'Auth Users')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]
    #[ApiSwaggerResponse(status: 400, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Bad Request')]
    public function deleteUser($id)
    {
        $this->userService->deleteUser($id);

        return response()->json(['message' => 'User deleted']);
    }

    #[ApiSwagger(summary: 'Get a user', tag: 'Auth Users')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: User::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 404, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Not found')]
    public function showUser($id)
    {
        $user = $this->userService->showUser($id);

        return response()->json($user);
    }
}
