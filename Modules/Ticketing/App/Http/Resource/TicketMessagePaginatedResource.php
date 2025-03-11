<?php

namespace Modules\Ticketing\App\Http\Resource;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\Ticketing\App\Models\TicketMessage; 

class TicketMessagePaginatedResource extends PaginatedResource
{
    public function toArray($request): array
    {
        return [
            'data' => TicketMessageResource::collection($this->collection),
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
            ],
        ];
    }
}