<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    // Order.php
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
    // OrderItem.php
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
