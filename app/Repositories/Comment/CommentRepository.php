<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{

    /**
     * @param Comment $comment
     * @return Comment
     */
    public function create(Comment $comment): Comment
    {
        $comment->save();

        return $comment;
    }
}
