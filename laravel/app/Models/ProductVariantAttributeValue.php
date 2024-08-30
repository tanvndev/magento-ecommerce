<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttributeValue extends Model
{
    use HasFactory;

    public $table = 'product_variant_attribute_value';

    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
    ];

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
