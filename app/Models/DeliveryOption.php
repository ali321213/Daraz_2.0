<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_name', 'price'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id'); // Fixed relationship
    }
}
