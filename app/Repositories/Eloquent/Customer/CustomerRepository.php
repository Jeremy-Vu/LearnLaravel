<?php
namespace App\Repositories\Eloquent\Customer;

use App\Models\Customer;
use App\Repositories\BaseEloquentRepository;

class CustomerRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

}
