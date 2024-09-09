<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'publish',
        'image',
        'canonical',
        'meta_title',
        'is_featured',
        'meta_description',
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
