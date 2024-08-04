<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'shelf_id',
        'unique_identifier',
        'description',
        'max_weight_capacity',
        'current_weight_used',
    ];

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }
}
