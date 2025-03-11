<?php

namespace Modules\Ticketing\App\Repositories;

use Modules\Ticketing\App\Models\TicketComment;

class TicketCommentRepository
{
    public function create(array $data)
    {
        return TicketComment::create($data);
    }

    public function find($commentId)
    {
        return TicketComment::findOrFail($commentId);
    }

    public function update($id, array $data)
    {
        $comment = $this->find($id);
        $comment->update($data);

        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->find($id);

        return $comment->delete();
    }
}
