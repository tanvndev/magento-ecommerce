<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

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
}
