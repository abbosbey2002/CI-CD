<?php

namespace Modules\Ticketing\App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Ticketing\App\Models\Ticket;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketUpdated implements ShouldBroadcast
{
    use Dispatchable,SerializesModels;
    public $ticket;
    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('ticket'.$this->ticket->id);
    }

    public function broadcastAs()
    {
        return 'TicketUpdated';
    }
}
