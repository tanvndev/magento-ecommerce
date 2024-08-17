<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tax extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'rate',
        'publish',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::upper($model->code);
        });

        static::updating(function ($model) {
            $model->code = Str::upper($model->code);
        });
    }
}
