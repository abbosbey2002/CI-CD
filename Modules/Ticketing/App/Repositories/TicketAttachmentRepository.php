<?php

namespace Modules\Ticketing\App\Repositories;

use Modules\Ticketing\App\Models\TicketAttachment;

class TicketAttachmentRepository
{
    public function create(array $data)
    {
        return TicketAttachment::create($data);
    }

    public function find($attachmentId)
    {
        return TicketAttachment::findOrFail($attachmentId);
    }

    public function delete($attachmentId)
    {
        $attachment = $this->find($attachmentId);

        return $attachment->delete();
    }
}
