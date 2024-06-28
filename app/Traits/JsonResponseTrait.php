<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait JsonResponseTrait
{
    /**
     * Success response method.
     *
     * @param  mixed       $data
     * @param  int         $statusCode
     * @return JsonResponse
     */
    public function success(string $message = null, $response = [], int $code = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'status'    => true,
            'message'   => $message,
            'status_code' => $code,
            'data'      => $response
        ], $code);
    }

    /**
     * Error response method.
     *
     * @param  string      $message
     * @param  int         $status_code
     * @return JsonResponse
     */
    public function error(string $message = null, $cause = null, $errors = [], int $code = Response::HTTP_INTERNAL_SERVER_ERROR) : JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'cause' => $cause,
            'errors' => $errors,
            'status_code' => $code
        ], $code);
    }

}