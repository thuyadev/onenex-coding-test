<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentFormRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Traits\ResponserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ResponserTrait;
    /**
     * @param CommentService $commentService
     */
    public function __construct(
        private CommentService $commentService,
    )
    {}

    /**
     * @param CommentFormRequest $request
     * @return JsonResponse
     */
    public function store(CommentFormRequest $request): JsonResponse
    {
        $comment = $this->commentService->create($request);

        return $this->responseCreated(new CommentResource($comment));
    }
}
