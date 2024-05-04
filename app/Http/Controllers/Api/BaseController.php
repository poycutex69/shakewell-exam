<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * @param  string  $name
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function notFoundErrorResponse(string $name) : JsonResponse
    {
        return $this->httpResponseMessage($name . ' not found.', 404);
    }

    /**
     * @param  string  $message
     * @param  mixed  $exception // preparation to store error logs
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function serverErrorResponse(
        string $message,
        $exception
    ) : JsonResponse {

        return $this->httpResponseMessage($message, 500);
    }

    /**
     * @param  string  $message
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse(string $message) : JsonResponse
    {
        return $this->httpResponseMessage($message, 422);
    }

    /**
     * @param  string  $message
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function successResponse(string $message) : JsonResponse
    {
        return $this->httpResponseMessage($message, 200);
    }

    /**
     * @param  string  $message
     * @param  int  $code
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function httpResponseMessage(
        string $message,
        int $code  = 200
    ) : JsonResponse {

        return response()->json([
            'message' => $message
        ], $code);

    }

    /**
     * DO NOT USE ON PRODUCTION. Only used for HTTP debug
     *
     * @param  mixed  $data
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function dd(...$data) : JsonResponse
    {
        return response()->json($data, 200);
    }

}