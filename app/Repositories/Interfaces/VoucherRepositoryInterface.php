<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface VoucherRepositoryInterface extends BaseRepositoryInterface
{
    public function countVouchers();

    public function search(
        array $parameters = []
    );

}
