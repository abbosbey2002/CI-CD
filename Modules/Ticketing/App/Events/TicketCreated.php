<?php

namespace Modules\Ticketing\App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketCreated implements ShouldBroadcast
{
    use SerializesModels;
    public $ticket;

    /**
     * Create a new event instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('ticket'.$this->ticket->id);
    }

    /**
     * Get the event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.created';
    }
}
