<?php
namespace App\Repositories\Eloquent\Brand;

use App\Models\Brand;
use App\Repositories\BaseEloquentRepository;

class BrandRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Brand::class;
    }
}
