<?php
namespace App\Repositories\Eloquent\Category;

use App\Models\Category;
use App\Repositories\BaseEloquentRepository;

class CategoryRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Category::class;
    }
}
