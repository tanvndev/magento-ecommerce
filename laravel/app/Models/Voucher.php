<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory, QueryScopes;
    protected $fillable = [
        'name',
        'code',
        'image',
        'description',
        'discount_type',
        'discount_value',
        'quantity',
        'min_order_value',
        'min_quantity',
        'start_at',
        'end_at',
        'publish',
    ];
}
