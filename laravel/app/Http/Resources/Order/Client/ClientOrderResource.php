<?php

namespace App\Http\Resources\Order\Client;

use App\Models\Order;
use App\Models\PaymentMethod;
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
            'id'                         => $this->id ?? '',
            'code'                       => $this->code,
            'customer_name'              => $this->customer_name,
            'customer_phone'             => $this->customer_phone,
            'customer_email'             => $this->customer_email,
            'shipping_address'           => $this->shipping_address,
            'order_status'               => $this->getOrderStatus(),
            'order_status_color'         => $this->getOrderStatusColor(),
            'payment_status'             => Order::PAYMENT_STATUS[$this->payment_status],
            'delivery_status'            => Order::SHIPPING_STATUS[$this->delivery_status],
            'total_price'                => $this->total_price,
            'shipping_fee'               => $this->shipping_fee,
            'discount'                   => $this->discount,
            'final_price'                => $this->final_price,
            'ordered_at'                 => $this->ordered_at,
            'paid_at'                    => $this->paid_at,
            'delivered_at'               => $this->delivered_at,
            'additional_details'         => $this->additional_details,
            'additional_details'         => $this->additional_details,
            'note'                       => $this->note,
            'order_items'                => ClientOrderItemResource::collection($this->order_items),
        ];
    }

    private function getOrderStatus()
    {
        if (
            $this->payment_method_id != PaymentMethod::COD_ID
            && $this->payment_status == Order::PAYMENT_STATUS_UNPAID
        ) {
            return Order::PAYMENT_STATUS[Order::PAYMENT_STATUS_UNPAID];
        }

        return Order::ORDER_STATUS[$this->order_status];
    }

    private function getOrderStatusColor()
    {
        switch ($this->order_status) {
            case Order::ORDER_STATUS_CANCELED:
                return 'red';

            case Order::ORDER_STATUS_PENDING:
                return 'orange';

            default:
                if (
                    $this->payment_method_id != PaymentMethod::COD_ID &&
                    $this->payment_status == Order::PAYMENT_STATUS_UNPAID
                ) {
                    return 'orange';
                }

                return 'green';
        }
    }
}
