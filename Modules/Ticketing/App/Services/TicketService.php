<?php

namespace Modules\Ticketing\App\Services;

use Modules\Ticketing\App\Repositories\TicketRepository;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllTickets()
    {
        // Possibly filter by user role here
        return $this->ticketRepository->getAll();
    }

    public function findTicket($id)
    {
        return $this->ticketRepository->getById($id);
    }

    public function createTicket(array $data)
    {
        // Default status to open
        $data['status'] = $data['status'] ?? 'open';

        return $this->ticketRepository->create($data);
    }

    public function updateTicket($id, array $data)
    {
        return $this->ticketRepository->update($id, $data);
    }

    public function deleteTicket($id)
    {
        return $this->ticketRepository->delete($id);
    }
}
