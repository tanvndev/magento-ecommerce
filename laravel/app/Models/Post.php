<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'user_id',
        // 'post_catalogue_id',
        'name',
        'image',
        'description',
        'content',
        'canonical',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'publish',
        'is_featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}
