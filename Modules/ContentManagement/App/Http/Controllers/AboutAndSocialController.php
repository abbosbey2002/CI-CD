<?php

namespace Modules\ContentManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Modules\ContentManagement\App\Http\Requests\UpdateAboutAndSocialRequest;
use Modules\ContentManagement\App\Models\AboutAndSocial;
use Modules\ContentManagement\App\Services\AboutAndSocialService;

class AboutAndSocialController extends Controller
{
    protected $service;

    public function __construct(AboutAndSocialService $service)
    {
        $this->service = $service;
    }

    #[ApiSwagger(summary: 'Get about and social', tag: 'About and Social')]
    #[ApiSwaggerResponse(status: 200, resource: AboutAndSocial::class)]
    public function index(): JsonResponse
    {
        $data = $this->service->getAboutAndSocial();

        return response()->json($data);
    }

    #[ApiSwagger(summary: 'Update about and social', tag: 'About and Social')]
    #[ApiSwaggerRequest(request: UpdateAboutAndSocialRequest::class, description: 'Update about and social')]
    #[ApiSwaggerResponse(status: 200, resource: AboutAndSocial::class, description: 'Successful response')]
    #[ApiSwaggerResponse(status: 401, resource: [
        'error' => 'Unauthorized',
        'errors' => [
            'message' => 'Unauthenticated.',
        ],
    ], description: 'Unauthenticated')]

    #[ApiSWaggerResponse(status: 422, resource: [
        'error' => 'UnprocessableEntity',
        'errors' => [
            'message' => 'The given data was invalid.',
            'details' => [
                'social_links' => [
                    'The social links field is required.',
                ],
            ],
        ],
    ], description: 'Unprocessable entity')]
    public function update(UpdateAboutAndSocialRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('terms_file')) {
            $data['terms_file'] = $request->file('terms_file')->store('terms_files', 'public');
        }
        // dd($data);
        $updated = $this->service->updateAboutAndSocial($data);

        return response()->json(['message' => 'About and Social links updated successfully', 'data' => $updated]);
    }
}
