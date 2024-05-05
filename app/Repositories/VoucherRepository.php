<?php

namespace App\Repositories;

use App\Models\Voucher;
use App\Repositories\Interfaces\VoucherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Pachealth\Core\Models\FaqCategory;

class VoucherRepository extends BaseRepository implements
    VoucherRepositoryInterface
{
    protected $model;

    /**
     * Repository constructor
     */
    public function __construct(Voucher $model)
    {
        $this->model = $model;
    }

    public function countVouchers() 
    {
        $user = Auth::user();
        return $user->vouchers()->count();
    }

    /**
     * @param array $parameters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(
        array $parameters = []
    ) {

        $query = $this->getFillables(
            new Voucher(),
            $this->model->query(),
            $parameters
        );

        if (!empty($parameters['code'])) {
            $query->where('code',$parameters['code']);
        }

        return $query->get();
    }
}
