<?php


namespace Modules\Ticketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use AutoSwagger\Attributes\ApiSwagger;
use AutoSwagger\Attributes\ApiSwaggerQuery;
use AutoSwagger\Attributes\ApiSwaggerRequest;
use AutoSwagger\Attributes\ApiSwaggerResponse;
use Modules\Ticketing\App\Http\Requests\CreateMessageRequest;
use Modules\Ticketing\App\Http\Requests\UpdateMessageRequest;;
use Modules\Ticketing\App\Models\TicketMessage;
use Modules\Ticketing\App\Models\Ticket;
use Modules\Ticketing\App\Events\TicketMessageCreated;
use Modules\Bot\App\Services\TicketResponseToUser;

class TicketMessageController extends Controller
{

    protected TicketResponseToUser $ticketResponseToUser;

    // Constructor orqali servisni inject qilamiz
    public function __construct(TicketResponseToUser $ticketResponseToUser)
    {
        $this->ticketResponseToUser = $ticketResponseToUser;
    }
   
    public function index($ticket_id)
    {
        $messages = TicketMessage::where('ticket_id', $ticket_id)->paginate(30);
        return response()->json($messages);
    }

   
    public function store(CreateMessageRequest $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        if(!$ticket){
            return response()->json(['message' => 'Ticket not found']);
        }
        if($ticket->status == 'closed') {
            return response()->json(['message' => 'Ticket is closed']);
        }
        $data = $request->validated();
        $ticketMessage = new TicketMessage();
        $ticketMessage->ticket_id = $ticket->id;
        $ticketMessage->sender_type = 'admin';
        $ticketMessage->message = $request->input('message');
        $ticketMessage->save();
        $ticket->update(['status' => 'in_progress']);

        event(new TicketMessageCreated($ticketMessage));

        $this->ticketResponseToUser->send($ticketMessage);

        return response()->json($ticket, 201);
    }

   
    public function update(UpdateMessageRequest $request, $message_id)
    {
        $data = $request->validated();
        $message = TicketMessage::findOrFail($message_id);
        $message->update($data);
        return response()->json($message, 200);
    }

  
    public function destroy($message_id)
    {
        $message = TicketMessage::findOrFail($message_id);
        $message->delete();
        return response()->json(['message' => 'Message deleted']);
    }
}   