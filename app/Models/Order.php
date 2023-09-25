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
        'order_note',
        'total_amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function historyOrder()
    {
        return $this->hasMany(HistoryOrder::class);
    }

    public function getCreatedAttribute(){
        return $this->attributes['created_at'];
    }

    public function getId(){
        return $this->attributes['id'];
    }


}
