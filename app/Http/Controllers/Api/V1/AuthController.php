<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginFormRequest;
use App\Http\Requests\Api\RegisterFormRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use App\Traits\ResponserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponserTrait;

    public function __construct(
        private AuthService $authService,
    )
    {}

    public function register(RegisterFormRequest $request): JsonResponse
    {
        $auth = $this->authService->register($request);

        return $this->responseCreated(new AuthResource($auth));
    }

    public function login(LoginFormRequest $request): JsonResponse
    {
        $auth = $this->authService->login($request);

        return $this->responseSuccess('success', new AuthResource($auth));
    }
}
