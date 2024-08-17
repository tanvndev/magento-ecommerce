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
        'product_type',
        'product_catalogue_id',
        'brand_id',
        'excerpt',
        'description',
        'upsell_ids',
        'is_taxable',
        'publish',
        'input_tax_id',
        'output_tax_id',
        'tax_status',
    ];

    protected $casts = [
        'upsell_ids' => 'json',
        'album' => 'json',
        'shipping_class_id' => 'json',
        'payment_method_id' => 'json',
    ];

    public function catalogue()
    {
        return $this->belongsTo(ProductCatalogue::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
            ->withPivot(
                'in_stock',
                'cog_price',
                'type'
            );
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
