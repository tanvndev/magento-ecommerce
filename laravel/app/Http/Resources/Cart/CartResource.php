<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->product_variant->image,
            'name' => $this->product_variant->name,
            'price' => $this->product_variant->price,
            'quantity' => $this->quantity,
            'sale_price' => $this->product_variant->sale_price,
            'attributes' => implode(' - ', $this->product_variant->attribute_values->pluck('name')->toArray()),
            'is_selected' => $this->is_selected,
            'total' => $this->quantity * $this->product_variant->price,
        ];
    }
}
