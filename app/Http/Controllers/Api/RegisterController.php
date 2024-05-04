<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    protected $service;
    /**     
     * @param  \App\Services\RegisterService  $service
     *
     * @return void
     */
    public function __construct(
        RegisterService $service
    ) {
        $this->service = $service;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {            

            if ($this->service->create($request)) {
                return $this->httpResponseMessage('You have successfully registered!');
            }
        } catch (\Exception $e) {

        }

        return $this->httpResponseMessage(
            'An error has occurred when sending the contact form',
            500
        );
    }
}
