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
        'attribute_catalogue_id',
    ];

    public function attribute_catalogue()
    {
        return $this->belongsTo(AttributeCatalogue::class, 'attribute_catalogue_id', 'id');
    }

    public function product_variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute', 'attribute_id', 'product_variant_id');
    }
}
