<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponserTrait
{
    /**
     * @param $message
     * @param $data
     * @return JsonResponse
     */
    public function responseSuccess($message = 'successful', $data = []): JsonResponse
    {
        return response()->json([
            'code'  => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'errors' => []
        ], Response::HTTP_OK);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function responseCreated($data = []): JsonResponse
    {
        return response()->json([
            'code'  => Response::HTTP_CREATED,
            'message' => 'successfully created',
            'data' => $data,
            'errors' => []
        ], Response::HTTP_CREATED);
    }

    /**
     * @param $msg
     * @return JsonResponse
     */
    public function responseMsgOnly($msg = 'success'): JsonResponse
    {
        return response()->json([
            'code'  => Response::HTTP_OK,
            'message' => $msg
        ]);
    }

    /**
     * @param $message
     * @param $data
     * @return JsonResponse
     */
    public function responseSuccessWithPaginate($message = 'successful', $data = []): JsonResponse
    {
        return response()->json([
            'code'  => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'links' => [
                'total' => $data->total(),
                'perPage' => $data->perPage(),
                'currentPage' => $data->currentPage(),
                'pageName' => $data->getPageName(),
                'path' => $data->path(),
                'lastPage' => $data->lastPage(),
                'nextPageUrl' =>  $data->nextPageUrl(),
            ]
        ]);
    }

    /**
     * @param $message
     * @param $code
     * @param $errors
     * @return JsonResponse
     */
    public function responseError($message = 'fatal error', $code = 500, $errors = []): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => [],
            'errors' => $errors
        ], $code);
    }
}
