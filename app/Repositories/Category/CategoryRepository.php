<?php
namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Eloquent\EloquentRepository;

class CategoryRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Category::class;
    }
}
