<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    /**
     * @param Comment $comment
     * @return Comment
     */
    public function create(Comment $comment): Comment;
}
