<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reviews extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'review',
        'rating',
        'image',
        'parent_id',
        'upvotes',
        'downvotes'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Reviews::class, 'parent_id');
    }
    public function replies()
    {
        return $this->hasMany(Reviews::class, 'parent_id');
    }
    public function likes()
    {
        return $this->hasMany(ReviewLike::class, 'review_id');
    }
}
