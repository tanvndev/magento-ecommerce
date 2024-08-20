<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name',
        'attribute_value_id',
    ];

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id', 'id');
    }

    public function product_variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute', 'attribute_id', 'product_variant_id');
    }
}
