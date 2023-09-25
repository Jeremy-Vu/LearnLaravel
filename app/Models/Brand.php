<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brand';

    protected $fillable = [
        'logo',
        'name',
        'slug',
        'phone',
        'image',
        'email',
        'address',
        'description'
    ];

    public function setBrandSlug($value ){
        $this->attributes['name'] = $value;
        return str()->slug($value);
    }
}
