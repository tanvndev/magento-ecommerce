<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, QueryScopes;

    const ORDER_STATUS = [
        'pending' => 'Chờ xác nhận',
        'delivering' => 'Đang giao',
        'completed' => 'Hoàn thành',
        'canceled' => 'Đã huỷ',
        'returned' => 'Trả hàng',
    ];

    const PAYMENT_STATUS = [
        'paid' => 'Đã thanh toán',
        'unpaid' => 'Chưa thanh toán',
    ];

    const SHIPPING_STATUS = [
        'pending' => 'Chờ giao',
        'delivering' => 'Đang giao',
        'delivered' => 'Đã giao hàng',
        'failed' => 'Giao thất bại',
    ];

    const ORDER_STATUS_PENDING = 'pending';

    const ORDER_STATUS_DELIVERING = 'delivering';

    const ORDER_STATUS_COMPLETED = 'completed';

    const ORDER_STATUS_CANCELED = 'canceled';

    const ORDER_STATUS_RETURNED = 'returned';

    const PAYMENT_STATUS_PAID = 'paid';

    const PAYMENT_STATUS_UNPAID = 'unpaid';

    const SHIPPING_STATUS_PENDING = 'pending';

    const SHIPPING_STATUS_DELIVERING = 'delivering';

    const SHIPPING_STATUS_DELIVERED = 'delivered';

    const SHIPPING_STATUS_FAILED = 'failed';


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
