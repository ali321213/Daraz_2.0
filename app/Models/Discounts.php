<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;
    protected $fillable = ['discount_percentage', 'start_date', 'end_date'];
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}