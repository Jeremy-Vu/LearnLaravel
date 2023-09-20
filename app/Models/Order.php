<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $fillable = [
        'name_customer',
        'product_id',
        'address',
        'payment_method',
        'phone',
        'customer_id',
        'order_code',
        'order_note',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
