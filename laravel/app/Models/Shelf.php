<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'rack_id',
        'description',
    ];

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function compartments()
    {
        return $this->hasMany(Compartment::class);
    }
}
