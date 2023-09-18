<?php
namespace App\Repositories\Eloquent\Customer;

use App\Models\Customer;
use App\Repositories\Eloquent\EloquentRepository;

class CustomerRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Customer::class;
    }
}
