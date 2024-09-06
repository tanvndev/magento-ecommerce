<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'uuid',
        'name',
        'product_id',
        'attribute_value_combine',
        'sku',
        'weight',
        'length',
        'width',
        'height',
        'image',
        'album',
        'price',
        'sale_price',
        'cost_price',
        'stock',
        'is_used',
        'low_stock_amount',
        'is_discount_time',
        'sale_price_start_at',
        'sale_price_end_at',
    ];

    protected $casts = [
        'album' => 'json',
        'is_discount_time' => 'boolean',
        'is_used' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->sale_price_start_at = formatIso8601ToDatetime($model->sale_price_start_at);
            $model->sale_price_end_at = formatIso8601ToDatetime($model->sale_price_end_at);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attribute_value', 'product_variant_id', 'attribute_value_id');
    }

    public function cart_items ()
    {
        return $this->hasMany(CartItem::class);
    }
}
