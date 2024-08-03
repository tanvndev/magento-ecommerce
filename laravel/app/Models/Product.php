<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'canonical',
        'product_type',
        'product_catalogue_id',
        'brand_id',
        'supplier_id',
        'sku',
        'excerpt',
        'description',
        'upsell_ids',
        'weight',
        'length',
        'width',
        'height',
        'is_taxable',
        'allow_sell',
        'publish',
        'image',
        'album',
        'input_tax_id',
        'ouput_tax_id',
        'tax_status',
    ];

    protected $casts = [
        'upsell_ids' => 'json',
        'album' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->canonical = self::generateUniqueSlug($model->name);
        });

        static::updating(function ($model) {
            $model->canonical = self::generateUniqueSlug($model->name, $model->id);
        });
    }

    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $canonical = Str::slug($name);
        $originalCanonical = $canonical;
        $count = 1;

        while (self::where('canonical', $canonical)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $canonical = "{$originalCanonical}-" . $count++;
        }

        return $canonical;
    }

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
