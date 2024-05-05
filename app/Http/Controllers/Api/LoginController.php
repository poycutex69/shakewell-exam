<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $request->validate($request->rules(), $request->messages());   

            if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $success['name'] =  $user->first_name;
       
                return $this->successResponse('User login successful.', $success);
            } 
            else{ 
                return $this->httpResponseMessage('Unauthorised.', ['error'=>'Unauthorised'], 403);
            }
        } catch (Exception $ex) {
            return $this->serverErrorResponse(
                'An error has occurred in registration.',
                $ex->getMessage()
            );
        }
         
    }
}
