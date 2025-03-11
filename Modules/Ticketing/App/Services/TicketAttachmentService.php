<?php

namespace Modules\Ticketing\App\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Ticketing\App\Repositories\TicketAttachmentRepository;

class TicketAttachmentService
{
    protected $attachmentRepository;

    public function __construct(TicketAttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    public function uploadAttachment($ticketId, $commentId, $file)
    {
        // Save file
        $path = $file->store('attachments', 'public');
        $data = [
            'ticket_id' => $ticketId,
            'comment_id' => $commentId,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ];

        return $this->attachmentRepository->create($data);
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = $this->attachmentRepository->find($attachmentId);
        Storage::disk('public')->delete($attachment->file_path);
        $this->attachmentRepository->delete($attachmentId);
    }
}
