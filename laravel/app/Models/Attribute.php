<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $code = Str::upper(Str::slug($model->code));
            $model->code = Str::upper($code);
        });

        static::updating(function ($model) {
            $code = Str::upper(Str::slug($model->code));
            $model->code = Str::upper($code);
        });
    }

    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function products()
    {
        return $this
            ->belongsToMany(Attribute::class, 'product_attribute', 'attribute_id', 'product_id')
            ->withPivot('attribute_value_ids', 'enable_variation');
    }

    public function product_variants()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attribute', 'attribute_id', 'product_variant_id');
    }
}
