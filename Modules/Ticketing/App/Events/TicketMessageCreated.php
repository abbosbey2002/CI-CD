<?php

namespace Modules\Ticketing\App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Modules\Ticketing\App\Models\TicketMessage;

class TicketMessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TicketMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(TicketMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Event qaysi channelda broadcast qilinishi.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('ticket.' . $this->message->ticket_id);
    }

    /**
     * Frontend uchun event nomi.
     */
    public function broadcastAs(): string
    {
        return 'ticket.message.created';
    }

    /**
     * Frontendga yuboriladigan ma'lumotlar.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'ticket_id' => $this->message->ticket_id,
                'sender_type' => $this->message->sender_type,
                'message' => $this->message->message,
                'updated_at' => $this->message->updated_at->toDateTimeString(),
                'created_at' => $this->message->created_at->toDateTimeString(),
            ],
        ];
    }
}
