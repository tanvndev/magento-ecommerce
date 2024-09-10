<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCatalogue extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'publish',
        'image',
        'order',
        'meta_title',
        'meta_description',
        'canonical',
        'parent_id',
        'is_featured',
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
            $canonical = "{$originalCanonical}-".$count++;
        }

        return $canonical;
    }

    public function childrens()
    {
        return $this->hasMany(ProductCatalogue::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCatalogue::class, 'parent_id');
    }

    public function scopeWithChildren($query)
    {
        return $query->with('children');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_catalogue_product');
    }
}
