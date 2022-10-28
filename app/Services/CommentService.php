<?php

namespace App\Services;

use App\Http\Requests\Api\CommentFormRequest;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
    )
    {}

    public function create(CommentFormRequest $request): Comment
    {
        $data = $request->validated();

        $to_comment = $request->toComment($data);

        $comment = $this->commentRepository->create($to_comment);

        return $comment;
    }
}
