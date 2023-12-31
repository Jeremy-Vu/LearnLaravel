<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product';
    protected $fillable = [
        'name',
        'price',
        'detail_product',
        'category_id',
        'brand_id',
        'slug',
        'image',
        'quantity',
        'description',
        'sku',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function setProductSlug($value)
    {
        $this->attributes['name'] = $value;
        return str()->slug($value);
    }

}
