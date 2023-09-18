<?php
namespace App\Repositories\Eloquent\Attribute;

use App\Models\Attribute;
use App\Repositories\Eloquent\EloquentRepository;

class AttributeRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Attribute::class;
    }
}
