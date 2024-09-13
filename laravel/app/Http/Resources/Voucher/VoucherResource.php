<?php

namespace App\Http\Resources\Voucher;

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
            'id'                => $this->id,
            'code'              => $this->code,
            'discount_type'     => $this->discount_type,
            'discount_value'    => $this->discount_value,
            'quantity'          => $this->quantity,
            'min_order_value'   => $this->min_order_value,
            'min_quantity'      => $this->min_quantity,
            'start_at'          => $this->start_at,
            'end_at'            => $this->end_at,
            'publish'           => $this->publish,
        ];
    }
}
