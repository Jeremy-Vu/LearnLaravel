<?php
namespace App\Repositories\Eloquent\HistoryOrder;

use App\Models\HistoryOrder;
use App\Repositories\BaseEloquentRepository;
class HistoryOrderRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return HistoryOrder::class;
    }
}
