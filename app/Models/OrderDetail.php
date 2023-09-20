<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_details';

    protected $fillable = [
        'product_id',
        'order_id',
        'price',
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
