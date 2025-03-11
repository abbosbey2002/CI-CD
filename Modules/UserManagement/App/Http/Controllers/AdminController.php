<?php

namespace Modules\UserManagement\App\Http\Controllers;

use Tymon\JWTAuth\Token;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use Modules\UserManagement\App\Models\User;
// use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Auth;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Modules\UserManagement\App\Services\AdminService;
use Modules\UserManagement\App\Http\Requests\LoginRequest;
use Modules\UserManagement\App\Http\Requests\AdminStoreRequest;
use Modules\UserManagement\App\Http\Requests\AdminUpdateRequest;
use Modules\UserManagement\App\Http\Requests\ResetPasswordRequest;
/**
 * @OA\Info(title="My First API", version="0.1")
 */
class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    #[ApiSwagger(summary: 'Login', tag: 'Auth Admin')]
    #[ApiSwaggerRequest(request: LoginRequest::class, description: 'Login')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'access_token' => 'string',
        'user' => 'object',
    ], description: 'Successful response')]
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // $refreshToken = auth('api')->setTTL(20160)->refresh();

        return $this->respondWithToken($token);
    }

    #[ApiSwagger(summary: 'Reset password', tag: 'Auth Admin')]
    #[ApiSwaggerRequest(request: ResetPasswordRequest::class, description: 'Reset password')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = Auth::guard('api')->user(); // Agar Sanctum ishlatilsa

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    protected function respondWithToken($token)
    {
        
        return response()->json([
            'access_token' => $token,
            'user' => auth('api')->user(),
            // 'refresh_token' => auth('api')->setTTL(20160)->refresh($token), // Refresh token (optional)
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    #[ApiSwagger(summary: 'Refresh token', tag: 'Auth Admin')]
    #[ApiSwaggerQuery(name: 'token', description: 'Token to refresh', required: true, isId: false)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'access_token' => 'string',
        'user' => 'object',
        'refresh_token' => 'string',
        'token_type' => 'string',
        'expires_in' => 'number',
    ], description: 'Successful response')]

      /**
     * Refresh a Token and return a new Token.
     *
     * @param  \Tymon\JWTAuth\Token  $token
     * @param  bool  $forceForever
     * @param  bool  $resetClaims
     * @return \Tymon\JWTAuth\Token
     */
    public function refresh(Token $token, $forceForever = false, $resetClaims = false)
    {
        $this->setRefreshFlow();

        $claims = $this->buildRefreshClaims($this->decode($token));

        if ($this->blacklistEnabled) {
            // Invalidate old token
            $this->invalidate($token, $forceForever);
        }

        // Return the new token
        return $this->encode(
            $this->payloadFactory->customClaims($claims)->make($resetClaims)
        );
    }

    #[ApiSwagger(summary: 'Create an admin', tag: 'Auth Admin')]
    #[ApiSwaggerRequest(request: AdminStoreRequest::class, description: 'Create an admin')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'user' => 'object',
    ], description: 'Successful response')]
    public function createAdmin(AdminStoreRequest $request)
    {
        $data = $request->validated();

        $user = $this->adminService->createAdmin($data);

        if (! $user) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        $user->assignRole($user->role);

        return response()->json($user, 201);
    }

    #[ApiSwagger(summary: 'Update an admin', tag: 'Auth Admin')]
    #[ApiSwaggerRequest(request: AdminUpdateRequest::class, description: 'Update an admin')]
    #[ApiSwaggerResponse(status: 200, resource: [
        'user' => 'object',
    ], description: 'Successful response')]
    public function update(AdminUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $user = $this->adminService->updateAdmin($id, $data);

        return response()->json($user);
    }

    #[ApiSwagger(summary: 'Get an admin', tag: 'Auth Admin')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'user' => 'object',
    ], description: 'Successful response')]
    public function showAdmin($id): JsonResponse
    {
        $user = $this->adminService->findAdmin($id);

        return response()->json($user);
    }

    #[ApiSwagger(summary: 'Delete an admin', tag: 'Auth Admin')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ], description: 'Successful response')]
    public function deleteAdmin($id): JsonResponse
    {
        $user = $this->adminService->deleteAdmin($id);

        return response()->json($user);
    }
}
