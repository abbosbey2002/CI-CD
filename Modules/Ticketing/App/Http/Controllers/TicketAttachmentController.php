<?php

namespace Modules\Ticketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Illuminate\Http\JsonResponse;
use Modules\Ticketing\App\Http\Requests\CreateCommentRequest;
use Modules\Ticketing\App\Services\TicketAttachmentService;

class TicketAttachmentController extends Controller
{
    protected $attachmentService;

    public function __construct(TicketAttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    #[ApiSwagger(summary: 'Upload a new attachment', tag: 'Comment')]
    #[ApiSwaggerRequest(request: CreateCommentRequest::class, description: 'Upload a new attachment')]
    #[ApiSwaggerQuery(name: 'ticketId', required: true, isId: true)]
    #[ApiSwaggerQuery(name: 'commentId', required: false, isId: true)]
    #[ApiSwaggerResponse(status: 201, resource: [
        'attachment' => 'object',
    ])]
    public function store(CreateCommentRequest $request, $ticketId, $commentId = null): JsonResponse
    {
        $attachment = $this->attachmentService->uploadAttachment(
            $ticketId,
            $commentId,
            $request->file('file')
        );

        return response()->json($attachment, 201);
    }

    #[ApiSwagger(summary: 'Delete an attachment', tag: 'Comment')]
    #[ApiSwaggerQuery(name: 'attachmentId', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ])]
    public function destroy($attachmentId)
    {
        $this->attachmentService->deleteAttachment($attachmentId);

        return response()->json(['message' => 'Attachment deleted']);
    }
}
