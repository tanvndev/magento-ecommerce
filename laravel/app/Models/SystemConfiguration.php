<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfiguration extends Model
{
    use HasFactory;

    protected $table = 'system_configurations';

    protected $fillable = [
        'user_id',
        'code',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
