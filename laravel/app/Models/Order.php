<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'province_id',
        'district_id',
        'ward_id',
        'shipping_address',
        'note',
        'shipping_method_id',
        'payment_method_id',
        'user_id',
        'voucher_id',
        'order_status',
        'payment_status',
        'delivery_status',
        'total_price',
        'shipping_fee',
        'discount',
        'final_price',
        'ordered_at',
        'paid_at',
        'delivered_at',
        'additional_details',
    ];

    protected $casts = [
        'additional_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }

    public function order_paymentable()
    {
        return $this->hasOne(OrderPaymentable::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
