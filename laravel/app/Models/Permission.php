<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, QueryScopes;

    public $fillable = [
        'name',
        'canonical',
    ];

    public function user_catalogues()
    {
        return $this->belongsToMany(UserCatalogue::class);
    }
}
