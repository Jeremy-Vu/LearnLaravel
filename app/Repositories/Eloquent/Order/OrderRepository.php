<?php
namespace App\Repositories\Eloquent\Order;

use App\Models\Order;
use App\Repositories\Eloquent\EloquentRepository;

class OrderRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Order::class;
    }
}
