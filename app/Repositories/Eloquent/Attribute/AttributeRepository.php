<?php
namespace App\Repositories\Eloquent\Attribute;

use App\Models\Attribute;
use App\Repositories\BaseEloquentRepository;

class AttributeRepository extends BaseEloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function model()
    {
        return Attribute::class;
    }
}
