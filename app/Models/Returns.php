<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'reason',
        'status',
    ];

    // A return belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // A return belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
