<?php

namespace App\Http\Resources\Order\Client;

use App\Http\Resources\Product\Client\ClientProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                            => $this->id,
            'order_id'                      => $this->order_id,
            'product_variant_id'            => $this->product_variant_id,
            'uuid'                          => $this->uuid,
            'product_variant_name'          => $this->product_variant_name,
            'quantity'                      => $this->quantity,
            'price'                         => $this->price,
            'sale_price'                    => $this->sale_price,
            // 'variant' => ClientProductVariantResource::collection($this->product_variant),
        ];
    }
}
