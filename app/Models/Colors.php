<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    
    use HasFactory;
    protected $fillable = ['name', 'hex_code'];
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
