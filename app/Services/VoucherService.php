<?php

namespace App\Services;

use App\Models\User;
use App\Models\Voucher;

class VoucherService
{
    public function create(User $user )
    {        

        $model = Voucher::create([
            'code' => $this->generateCode(),
            'user_id' => $user->id
        ]);

        return $model->refresh();
    }

    private function generateCode()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';        
        return substr(str_shuffle($permitted_chars), 0, 5);
    }
}