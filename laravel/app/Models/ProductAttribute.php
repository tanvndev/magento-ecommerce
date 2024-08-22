<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    public $table = 'product_attribute';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_ids',
        'enable_variation',
    ];

    protected $casts = [
        'attribute_value_ids' => 'json',
    ];
}
