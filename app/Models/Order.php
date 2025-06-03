<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
