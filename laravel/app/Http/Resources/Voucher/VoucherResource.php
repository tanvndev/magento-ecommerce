<?php

namespace App\Http\Resources\Voucher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'id' => $this->id,
            'key' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'image' => $this->image,
            'description' => $this->description,
            'value_type' => $this->value_type,
            'value' => $this->value,
            'quantity' => $this->quantity,
            'value_limit_amount' => $this->value_limit_amount,
            'subtotal_price' => $this->subtotal_price,
            'min_quantity' => $this->min_quantity,
            'condition_apply' => $this->condition_apply,
            'status' => $this->getStatus(),
            'voucher_time' => [
                $this->start_at,
                $this->end_at,
            ],
            'publish' => $this->publish,
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
                'text' => 'Đã hết lượt sử dụng',
            ];
        }

        if ($this->publish == 2) {
            return [
                'color' => 'red',
                'text' => 'Chưa kích hoạt',
            ];
        }

        if ($start && $end && ($now->lt($start) || $now->gt($end))) {
            return [
                'color' => 'red',
                'text' => 'Đã hết hạn',
            ];
        }

        return [
            'color' => 'green',
            'text' => 'Đang áp dụng',
        ];
    }
}
