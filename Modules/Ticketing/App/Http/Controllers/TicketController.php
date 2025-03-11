<?php

namespace Modules\Ticketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use Modules\Ticketing\App\Models\Ticket;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Modules\Ticketing\App\Events\TicketCreated;
use Modules\Ticketing\App\Events\TicketUpdated;
use Modules\Ticketing\App\Services\TicketService;
use Modules\Ticketing\App\Http\Requests\CreateTicketRequest;
use Modules\Ticketing\App\Http\Resource\TicketPaginatedResource;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    #[ApiSwagger(summary: 'Get all tickets', tag: 'Tickets')]
    #[ApiSwaggerResponse(status: 200, resource: TicketPaginatedResource::class, isPagination: true)]
    public function index(): TicketPaginatedResource
    {
        // For admin/dealer: show all tickets
        // For user: show only user's tickets (in service or here)
        $tickets = $this->ticketService->getAllTickets();

        return new TicketPaginatedResource($tickets);
    }

    #[ApiSwagger(summary: 'Create a new ticket', tag: 'Tickets')]
    #[ApiSwaggerRequest(request: CreateTicketRequest::class, description: 'Create a new ticket')]
    #[ApiSwaggerResponse(status: 201, resource: [
        'ticket' => 'object',
    ])]
    public function store(CreateTicketRequest $request)
    {
        $data = $request->validated();
        // Set user_id to the authenticated user
        $data['user_id'] = auth()->id();
        $ticket = $this->ticketService->createTicket($data);

        event(new TicketCreated($ticket));
        return response()->json($ticket, 201);
    }

    #[ApiSwagger(summary: 'Get a ticket', tag: 'Tickets')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'ticket' => 'object',
    ])]
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $ticket = $this->ticketService->findTicket($id);

        return response()->json($ticket);
    }

    #[ApiSwagger(summary: 'Update a ticket', tag: 'Tickets')]
    #[ApiSwaggerRequest(request: CreateTicketRequest::class, description: 'Update a ticket')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'ticket' => 'object',
    ])]
    public function update(CreateTicketRequest $request, $id)
    {
        // e.g., update status or priority
        $updated = $this->ticketService->updateTicket($id, $request->all());

        event(new TicketUpdated($updated));

        return response()->json($updated);
    }

    #[ApiSwagger(summary: 'Delete a ticket', tag: 'Tickets')]
    #[ApiSwaggerQuery(name: 'id', required: true, isId: true)]
    #[ApiSwaggerResponse(status: 200, resource: [
        'message' => 'string',
    ])]
    public function destroy($id)
    {
        $this->ticketService->deleteTicket($id);

        return response()->json(['message' => 'Ticket deleted']);
    }
}
