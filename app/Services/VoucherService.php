<?php

namespace App\Services;

use App\Models\User;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;

class VoucherService
{
    public function create(User $user )
    {        

        $model = Voucher::create([
            'code' => $this->generateCode(),
            'user_id' => $user->id
        ]);

        return $model;
    }

    /**
     * @param  \App\Models\Voucher  $model
     *
     * @return  void
     */
    public function delete(Voucher $model)
    {
        return $model->delete();
    }

    private function generateCode()
    {
        $repo = new VoucherRepository(new Voucher());
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $res = true;
        while($res) {
            $code = substr(str_shuffle($permitted_chars), 0, 5);
            if ($repo->search(['code'=>$code])->count() === 0) {
                return $code;
            }
            $res = true;
        }
    }
}