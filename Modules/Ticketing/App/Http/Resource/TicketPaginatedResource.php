<?php

namespace Modules\Ticketing\App\Http\Resource;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\Ticketing\App\Models\Ticket;

class TicketPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (Ticket $ticket) {
            return $ticket;
        });
    }
}
