<?php

namespace Modules\Ticketing\App\Services;

use Modules\Ticketing\App\Repositories\TicketCommentRepository;

class TicketCommentService
{
    protected $commentRepository;

    public function __construct(TicketCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComment($commentId)
    {
        return $this->commentRepository->find($commentId);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function updateComment($commentId, array $data)
    {
        return $this->commentRepository->update($commentId, $data);
    }

    public function deleteComment($commentId)
    {
        return $this->commentRepository->delete($commentId);
    }
}
