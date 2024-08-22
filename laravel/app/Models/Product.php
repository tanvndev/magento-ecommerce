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
        'product_type',
        'brand_id',
        'excerpt',
        'description',
        'upsell_ids',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'canonical',
        'publish',
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

    public function attributes()
    {
        return $this
            ->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id')
            ->withPivot('attribute_value_ids', 'enable_variation');
    }
}
