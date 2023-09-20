<?php
namespace App\Repositories\Eloquent\OrderDetail;

use App\Models\OrderDetail;
use App\Repositories\Eloquent\EloquentRepository;

class OrderDetailReposity extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return OrderDetail::class;
    }
}
