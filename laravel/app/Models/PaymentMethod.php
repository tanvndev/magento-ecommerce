<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentMethod extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'order',
        'settings',
        'publish',
    ];

    public $casts = [
        'settings' => 'json',
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
        $code = Str::slug($name);
        $originalCode = $code;
        $count = 1;

        while (self::where('code', $code)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $code = "{$originalCode}-".$count++;
        }

        return $code;
    }
}
