<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;
    protected $fillable = [
        'name',
        'code',
        'items',
        'setting',
        'publish',
    ];

    protected $casts = [
        'items'     => 'array',
        'setting'   => 'array',
    ];
}
