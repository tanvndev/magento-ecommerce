<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'parent_id',
        'comment',
        'images',
        'is_published',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProductReview::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductReview::class, 'parent_id');
    }

    protected $cats = [
        'images' => 'array',
        'is_published' => 'boolean',
    ];
}
