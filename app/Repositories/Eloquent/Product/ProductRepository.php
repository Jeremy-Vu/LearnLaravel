<?php
namespace App\Repositories\Eloquent\Product;

use App\Models\Product;
use App\Repositories\Eloquent\EloquentRepository;

class ProductRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Product::class;
    }
}
