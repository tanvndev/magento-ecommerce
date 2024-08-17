<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Warehouse extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'publish',
        'phone',
        'supervisor_name',
        'description',
        'aisles_number',
        'racks_number',
        'shelves_number',
        'compartments_number',
        'total_capacity',
        'used_capacity',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = self::generateUniqueSlug($model->name);
        });

        static::updating(function ($model) {
            $model->code = self::generateUniqueSlug($model->name, $model->id);
        });
    }

    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $code = convertToAcronym(Str::slug($name));
        $originalCanonical = $code;

        $count = 1;

        while (self::where('code', $code)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $code = "{$originalCanonical}-".$count++;
        }

        return Str::upper($code);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_warehouse')
            ->withPivot(
                'in_stock',
                'cog_price',
                'type'
            );
    }

    public function aisles()
    {
        return $this->hasMany(Aisle::class);
    }
}
