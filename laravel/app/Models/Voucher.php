<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Voucher extends Model
{
    use HasFactory, Notifiable, QueryScopes, SoftDeletes;

    const SUBTOTAL_PRICE = 'subtotal_price';

    const MIN_QUANTITY = 'min_quantity';

    const ALL = 'all';

    const TYPE_FIXED = 'fixed';

    const TYPE_PERCENT = 'percentage';

    protected $fillable = [
        'name',
        'code',
        'image',
        'description',
        'value_type',
        'value',
        'value_limit_amount',
        'quantity',
        'condition_apply',
        'usage_limit',
        'subtotal_price',
        'min_quantity',
        'start_at',
        'end_at',
        'publish',
    ];

    public function voucher_usages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function getUserUsageCount($userId)
    {
        return $this->voucher_usages()->where('user_id', $userId)->count();
    }

    public function canBeUsedByUser($userId)
    {
        // Nếu không có giới hạn số lần sử dụng
        if (is_null($this->usage_limit)) {
            return true;
        }

        // Kiểm tra số lần đã sử dụng
        $usageCount = $this->getUserUsageCount($userId);

        return $usageCount < $this->usage_limit;
    }
}
