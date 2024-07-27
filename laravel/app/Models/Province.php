<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory, QueryScopes;
    protected $table = 'provinces';
    protected $primaryKey = 'code';
    protected $autoincrement = false;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'code' => 'string',
    ];


    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }
}
