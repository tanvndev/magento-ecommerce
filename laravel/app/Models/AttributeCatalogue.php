<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'publish',
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'attribute_catalogue_id', 'id');
    }
}
