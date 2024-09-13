<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this['options']['image'],
            'name' => $this['name'],
            'price' => $this['price'],
            'quantity' => $this['qty'],
            'sale_price' => $this['options']['sale_price'],
            'is_selected' => $this['options']['is_selected'],
            'sub_total' => $this['options']['sub_total'],
            'total_amout' => $this->total_amount,
        ];
    }
}
