<?php



namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ShippingMethod extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    const COD_ID = "1";
    const FAST_ID = "2";

    protected $fillable = [
        'name',
        'code',
        'base_cost',
        'description',
        'publish',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = self::generateUniqueSlug($model->name);
        });

        static::updating(function ($model) {
            $model->code = self::generateUniqueSlug($model->name, $model->id);
        });
    }

    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $code = Str::slug($name);
        $originalCode = $code;
        $count = 1;

        while (self::where('code', $code)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $code = "{$originalCode}-" . $count++;
        }

        return $code;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
