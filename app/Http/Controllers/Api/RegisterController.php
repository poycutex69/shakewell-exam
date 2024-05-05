<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Mail\WelcomeEmail;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends BaseController
{

    /**     
     * @param  App\Services\UserService  $service
     *
     * @return void
     */
    public function __construct(
        protected UserService $service
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        
        try{
            $request->validate($request->rules(), $request->messages());        

            if ($user = $this->service->create($request)) {                
                return $this->httpResponseMessage('You have successfully registered!');
            } else {
                return $this->validationErrorResponse('Validation failed.', $request->er);
            }
        } catch (Exception $ex) {        

            return $this->serverErrorResponse(
                'An error has occurred in registration.',
                $ex->getMessage()
            );
        }
    }

    public function test(){
        dd('xxxx');
    }
}
