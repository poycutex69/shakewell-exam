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

            $user = $this->service->create($request);
            
            //needs to be moved to Event listener
            $voucher = $user->vouchers()->first();
            Mail::to($user->email)
                ->send(new WelcomeEmail($user, $voucher));
            
            return $this->httpResponseMessage('You have successfully registered!');
            
        } catch (Exception $ex) {

            return $this->serverErrorResponse($ex->getMessage());
        }
    }
}
