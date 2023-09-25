<?php
namespace App\Repositories\Eloquent\Product;

use App\Models\Product;
use App\Repositories\BaseEloquentRepository;

class ProductRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Product::class;
    }
}
