<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, QueryScopes;
    protected $fillable = [
        'code',
        'description',
        'image',
        'order',
        'settings',
        'publish',
    ];
}
