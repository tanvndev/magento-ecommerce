<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'product_type',
        'brand_id',
        'excerpt',
        'description',
        'upsell_ids',
        'publish',
    ];

    protected $casts = [
        'upsell_ids' => 'json',
        'album' => 'json',
    ];

    public function catalogues()
    {
        return $this->belongsToMany(ProductCatalogue::class, 'product_catalogue_product');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
