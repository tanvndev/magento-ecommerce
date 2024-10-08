<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'districts';

    protected $primaryKey = 'code';

    protected $autoincrement = false;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'code' => 'string',
    ];

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'district_id', 'code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'district_id', 'code');
    }

    public function user_addresses()
    {
        return $this->hasMany(UserAddress::class, 'district_code', 'code');
    }
}
