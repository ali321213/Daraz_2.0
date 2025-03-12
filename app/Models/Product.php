<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'unit_id',
        'brand_id'
    ];
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}