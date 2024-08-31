<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, QueryScopes;
    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'description',
        'button_link',
        'status',
    ];
}
