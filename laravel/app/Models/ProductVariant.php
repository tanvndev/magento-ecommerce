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
        'low_stock_amount',
        'is_discount_time',
        'sale_price_start_at',
        'sale_price_end_at',
    ];

    protected $casts = [
        'album' => 'json',
        'attributes' => 'json',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attribute', 'product_variant_id', 'attribute_id');
    }

    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attribute', 'product_variant_id', 'attribute_value_id');
    }
}
