<?php

namespace App\Http\Resources\Voucher\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientVoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'code'             => $this->code,
            'image'            => $this->image,
            'description'      => $this->description,
            'value_type'       => $this->value_type,
            'value'            => $this->value,
            'status'           => $this->getStatus(),
            'expired'          => Carbon::parse($this->end_at)->format('d/m/Y H:i'),
            'text_description' => $this->getTextDescription(),
        ];
    }

    public function getStatus()
    {
        $now = Carbon::now();
        $start = $this->start_at ? Carbon::parse($this->start_at) : null;
        $end = $this->end_at ? Carbon::parse($this->end_at) : null;

        if ($this->quantity <= 0) {
            return [
                'color' => 'inactive',
                'text'  => 'Đã hết lượt sử dụng',
            ];
        }

        if ($this->publish == 2) {
            return [
                'color' => 'inactive',
                'text'  => 'Chưa kích hoạt',
            ];
        }

        if ($start && $end) {

            if ($now->lt($start)) {
                return [
                    'color' => 'orange',
                    'text'  => 'Chưa đến hạn',
                ];
            } elseif ($now->gt($end)) {
                return [
                    'color' => 'red',
                    'text'  => 'Đã hết hạn',
                ];
            }
        }

        return [
            'color' => 'active',
            'text'  => 'Sử dụng ngay',
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
