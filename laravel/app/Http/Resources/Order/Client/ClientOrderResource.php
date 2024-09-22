<?php

namespace App\Http\Resources\Order\Client;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'code'         => $this->code,
            'customer_name'         => $this->customer_name,
            'customer_phone'         => $this->customer_phone,
            'customer_email'         => $this->customer_email,
            'shipping_address'         => $this->shipping_address,
            'order_status'         => $this->order_status,
            'payment_status'         => $this->payment_status,
            'delivery_status'         => $this->delivery_status,
            'total_price'         => $this->total_price,
            'shipping_fee'         => $this->shipping_fee,
            'discount'         => $this->discount,
            'final_price'         => $this->final_price,
            'ordered_at'         => $this->ordered_at,
            'paid_at'         => $this->paid_at,
            'delivered_at'         => $this->delivered_at,
            'additional_details'         => $this->additional_details,
            'note'         => $this->note,
            'order_items'         => ClientOrderItemResource::collection($this->order_items),
        ];
    }
}
