<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'stock',
        'unit_id',
        'brand_id',
        'category_id',
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
        return $this->belongsTo(Brands::class);
    }

    public function deliveryOptions()
    {
        return $this->hasMany(DeliveryOption::class, 'product_id'); // Fixed relationship
    }

    public function returnWarranty()
    {
        return $this->hasOne(ReturnWarranty::class, 'product_id'); // Fixed relationship
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id'); // Fixed relationship
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'product_id');
    }
}