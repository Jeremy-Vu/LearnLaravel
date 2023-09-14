<?php
namespace App\Repositories\Eloquent\Brand;

use App\Models\Brand;
use App\Repositories\Eloquent\EloquentRepository;

class BrandRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Brand::class;
    }
}
