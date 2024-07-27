<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'description',
        'publish',
        'canonical',
        'image',
        'order',
        'parent_id',
    ];

    public function children()
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
}
