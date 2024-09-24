<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentable extends Model
{
    use HasFactory;

    protected $table = 'order_paymentable';

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'method_name',
        'payment_detail',
    ];

    public $casts = [
        'payment_detail' => 'array',
    ];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
