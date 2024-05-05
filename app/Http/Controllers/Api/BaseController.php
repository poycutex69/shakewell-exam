<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * @param  string  $name
     * @param  array  $data
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function notFoundErrorResponse(string $name, array $data = null) : JsonResponse
    {
        return $this->httpResponseMessage($name . ' not found.', $data, 404);
    }

    /**
     * @param  string  $message
     * @param  string  $exception // preparation to store error logs
     * @param  array  $data
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function serverErrorResponse(
        string $message,
        $exception,
        array $data = null        
    ) : JsonResponse {
        Log::error('Server Error:', $message);
        return $this->httpResponseMessage($message, $data, 500);
    }

    /**
     * @param  string  $message
     * @param  array  $data
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse(string $message, array $data = null) : JsonResponse
    {
        return $this->httpResponseMessage($message, $data, 422);
    }

    /**
     * @param  string  $message
     * @param  array  $data
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function successResponse(string $message, array $data = null) : JsonResponse
    {
        return $this->httpResponseMessage($message, $data, 200);
    }

    /**
     * @param  string  $message
     * @param  array  $data
     * @param  int  $code
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    protected function httpResponseMessage(
        string $message,
        array $data = null,
        int $code  = 200
    ) : JsonResponse {

        return response()->json([
            'message' => $message,
            'data' => $data
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