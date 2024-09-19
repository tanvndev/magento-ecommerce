<?php



namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

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
        'subtotal_price',
        'min_quantity',
        'start_at',
        'end_at',
        'publish',
    ];
}
