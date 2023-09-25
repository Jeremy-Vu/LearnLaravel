<?php
namespace App\Repositories\Eloquent\Order;

use App\Models\Order;
use App\Repositories\BaseEloquentRepository;

class OrderRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Order::class;
    }
}
