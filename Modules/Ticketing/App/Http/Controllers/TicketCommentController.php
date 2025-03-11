<?php

namespace Modules\Ticketing\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Modules\Ticketing\App\Events\TicketMessageCreated;
use Modules\Ticketing\App\Services\TicketCommentService;
use Modules\Ticketing\App\Http\Requests\CreateCommentRequest;

class TicketCommentController extends Controller
{
    protected $commentService;

    public function __construct(TicketCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    #[ApiSwagger(summary: 'Create a new comment', tag: 'Comment')]
    #[ApiSwaggerRequest(request: CreateCommentRequest::class, description: 'Create a new comment')]
    #[ApiSwaggerQuery(name: 'ticketId', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 201, resource: [
        'comment' => 'object',
    ])]
    public function store(CreateCommentRequest $request, $ticketId): JsonResponse
    {
        $data = $request->validated();
        $data['ticket_id'] = $ticketId;
        $data['user_id'] = auth()->id();
        $comment = $this->commentService->createComment($data);

        event(new TicketMessageCreated($comment));
        return response()->json($comment, 201);
    }

    #[ApiSwagger(summary: 'Update a comment', tag: 'Comment')]
    #[ApiSwaggerRequest(request: CreateCommentRequest::class, description: 'Update a comment')]
    #[ApiSwaggerQuery(name: 'ticketId', required: true, isId: true)]
    #[ApiSwaggerQuery(name: 'commentId', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'comment' => 'object',
    ])]
    public function update(CreateCommentRequest $request, $ticketId, $commentId)
    {
        // Might check if user is allowed to update
        $updated = $this->commentService->updateComment($commentId, $request->all());

        return response()->json($updated);
    }

    #[ApiSwagger(summary: 'Delete a comment', tag: 'Comment')]
    #[ApiSwaggerQuery(name: 'ticketId', required: true, isId: true)]
    #[ApiSwaggerQuery(name: 'commentId', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ])]
    public function destroy($ticketId, $commentId)
    {
        $this->commentService->deleteComment($commentId);

        return response()->json(['message' => 'Comment deleted']);
    }
}
