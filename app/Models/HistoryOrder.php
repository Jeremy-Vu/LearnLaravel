<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOrder extends Model
{
    use HasFactory;

    protected $table = 'history_order';
    protected $fillable = [
        'order_id',
        'customer_id',
        'order_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
