<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\User;

class UserService
{
    public function create($request)
    {        
        $model = User::create([
            'first_name' => $request->first_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);        

        $vs = new VoucherService();
        $vs->create($model);

        UserRegistered::dispatch($model);

        return $model->refresh();
    }
}