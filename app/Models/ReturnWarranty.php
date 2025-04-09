<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnWarranty extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'return_policy', 'warranty'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Fixed relationship
    }
}