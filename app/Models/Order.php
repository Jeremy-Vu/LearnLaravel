<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'product_id',
        'name_product',
        'quantity',
        'size',
        'color',
        'name_customer',
        'phone',
        'email'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}