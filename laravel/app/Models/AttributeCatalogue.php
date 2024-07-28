<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AttributeCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'publish',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::upper($model->code);
        });

        static::updating(function ($model) {
            $model->code =  Str::upper($model->code);
        });
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'attribute_catalogue_id', 'id');
    }
}
