<?php
namespace App\Repositories\Eloquent\OrderDetail;

use App\Models\OrderDetail;
use App\Repositories\BaseEloquentRepository;

class OrderDetailReposity extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return OrderDetail::class;
    }
}
