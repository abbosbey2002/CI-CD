<?php

namespace Modules\Ticketing\App\Repositories;

use Modules\Ticketing\App\Models\Ticket;

class TicketRepository
{
    public function getAll()
    {
        return Ticket::with(['comments'])->latest()->paginate();
    }

    public function getById($id)
    {
        return Ticket::with(['comments', 'messages', 'attachments'])->find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = $this->getById($id);
        $ticket->update($data);

        return $ticket;
    }

    public function delete($id)
    {
        $ticket = $this->getById($id);

        return $ticket->delete();
    }
}
