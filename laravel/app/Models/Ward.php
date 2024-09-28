<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'wards';

    protected $primaryKey = 'code';

    protected $autoincrement = false;

    protected $casts = [
        'code' => 'string',
    ];

    protected $fillable = [
        'name',
    ];

    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'ward_id', 'code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'ward_id', 'code');
    }
}
