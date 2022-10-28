<?php

namespace App\Exceptions;

use App\Traits\ResponserTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    use ResponserTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        if (request()->is('api/*')) {
            $this->renderable(function (Exception $e, $request) {
                return $this->handleException($request, $e);
            });
        } else {
            $this->reportable(function (Throwable $e) {
                //
            });
        }
    }

    public function handleException($request, Exception $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND, ['message' => 'Not Found']);
        }

        if ($e instanceof NotFoundResourceException) {
            return $this->responseError($e->getMessage(), Response::HTTP_BAD_REQUEST, ['message' => $e->getMessage()]);
        }

        if ($e instanceof ValidationException) {
            return $this->responseError('Validation Error Exception', Response::HTTP_BAD_REQUEST, $this->getCustomErrorMessage($e->errors()));
        }

        if ($e instanceof UnauthorizedException) {
            return $this->responseError('Unauthorized', Response::HTTP_UNAUTHORIZED, ['message' => 'Unauthorized']);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->responseError('Method Not Allowed', Response::HTTP_METHOD_NOT_ALLOWED, ['message' => 'method not allowed']);
        }

        if ($e instanceof CustomException)
        {
            return $this->responseError($e->getMessage(), $e->getCode());
        }
    }

    private function getCustomErrorMessage(array $errors): array
    {
        $customErrors = [];
        foreach ($errors as $key => $error) {
            $custom['key'] = $key;
            $custom['message'] = $error[0];

            array_push($customErrors, $custom);
        }

        return $customErrors;
    }
}
