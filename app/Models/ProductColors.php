<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductColors extends Model
{
    protected $fillable = ['product_id', 'color_name', 'hex_code'];
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}