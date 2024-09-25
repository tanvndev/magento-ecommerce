<?php

namespace App\Http\Resources\Order;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer_email'              => $this->customer_email,
            'customer_phone'             => $this->customer_phone,
            'customer_email'             => $this->customer_email,
            'shipping_address'           => $this->shipping_address,
            'payment_method_name'        => $this->payment_method->name,
            'order_status'               => Order::ORDER_STATUS[$this->order_status],
            'order_status_code'          => $this->order_status,
            'order_status_color'         => $this->getOrderStatusColor(),
            'payment_status'             => Order::PAYMENT_STATUS[$this->payment_status],
            'payment_status_code'        => $this->payment_status,
            'payment_status_color'       => $this->getPaymentStatusColor(),
            'delivery_status'            => Order::DELYVERY_STATUS[$this->delivery_status],
            'delivery_status_code'       => $this->delivery_status,
            'delivery_status_color'      => $this->getDeliveryStatusColor(),
            'payment_method_id'          => $this->payment_method_id,
            'total_price'                => $this->total_price,
            'shipping_fee'               => $this->shipping_fee,
            'discount'                   => $this->discount,
            'final_price'                => $this->final_price,
            'ordered_at'                 => $this->ordered_at,
            'paid_at'                    => $this->paid_at,
            'delivered_at'               => $this->delivered_at,
            'additional_details'         => $this->additional_details,
            'province_name'              => $this->province->full_name,
            'district_name'              => $this->district->full_name,
            'ward_name'                  => $this->ward->full_name,
            'province_code'              => $this->province->code,
            'district_code'              => $this->district->code,
            'ward_code'                  => $this->ward->code,
            'note'                       => $this->note,
            'order_items'                => OrderItemResource::collection($this->order_items),
        ];
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

    private function getPaymentStatusColor()
    {
        switch ($this->payment_status) {
            case Order::PAYMENT_STATUS_PAID:
                return 'green';

            default:
                return 'red';
        }
    }
    private function getDeliveryStatusColor()
    {
        switch ($this->delivery_status) {
            case Order::DELYVERY_STATUS_PENDING:
                return 'orange';
            case Order::DELYVERY_STATUS_FAILED:
                return 'red';
            default:
                return 'green';
        }
    }
}
