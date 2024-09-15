<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

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
