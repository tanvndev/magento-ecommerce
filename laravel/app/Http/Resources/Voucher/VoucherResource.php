<?php



namespace App\Http\Resources\Voucher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'key'                => $this->id,
            'name'               => $this->name,
            'code'               => $this->code,
            'image'              => $this->image,
            'description'        => $this->description,
            'value_type'         => $this->value_type,
            'value'              => $this->value,
            'quantity'           => $this->quantity,
            'value_limit_amount' => $this->value_limit_amount,
            'subtotal_price'     => $this->subtotal_price,
            'min_quantity'       => $this->min_quantity,
            'condition_apply'    => $this->condition_apply,
            'status'             => $this->getStatus(),
            'voucher_time'       => [
                $this->start_at,
                $this->end_at,
            ],
            'publish' => $this->publish,
            'text_description' => $this->getTextDescription()
        ];
    }

    public function getStatus()
    {
        $now = Carbon::now();
        $start = $this->start_at ? Carbon::parse($this->start_at) : null;
        $end = $this->end_at ? Carbon::parse($this->end_at) : null;

        if ($this->quantity <= 0) {
            return [
                'color' => 'red',
                'text'  => 'Đã hết lượt sử dụng',
            ];
        }

        if ($this->publish == 2) {
            return [
                'color' => 'red',
                'text'  => 'Chưa kích hoạt',
            ];
        }

        if ($start && $end && ($now->lt($start) || $now->gt($end))) {
            return [
                'color' => 'red',
                'text'  => 'Đã hết hạn',
            ];
        }

        return [
            'color' => 'green',
            'text'  => 'Đang áp dụng',
        ];
    }

    public function getTextDescription(): string
    {
        $valueType = $this->value_type;
        $value = $this->value;
        $valueLimitAmount = $this->value_limit_amount;
        $conditionApply = $this->condition_apply;
        $minQuantity = $this->min_quantity;
        $subtotalPrice = $this->subtotal_price;

        $texts = '';

        if ($valueType === 'percentage') {
            $formattedValue = round($value, 0);
            $texts .= "Giảm {$formattedValue}% ";

            if ($valueLimitAmount) {
                $formattedValueLimitAmount = formatCurrency($valueLimitAmount);
                $texts .= "tối đa {$formattedValueLimitAmount} cho toàn bộ đơn hàng.";
            }
        } else {
            $formattedValue = formatCurrency($value);
            $texts .= "Giảm {$formattedValue} cho toàn bộ đơn hàng.";
        }

        if ($conditionApply === 'min_quantity' && $minQuantity) {
            $texts .= " • Số lượng sản phẩm ≥ {$minQuantity}.";
        }

        if ($conditionApply === 'subtotal_price' && $subtotalPrice) {
            $formattedSubtotalPrice = formatCurrency($subtotalPrice);
            $texts .= " • Tổng giá trị sản phẩm được khuyến mại ≥ {$formattedSubtotalPrice}.";
        }

        return $texts;
    }
}
