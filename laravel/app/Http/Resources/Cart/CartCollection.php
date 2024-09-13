<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalAmount = $this->calculateTotalAmount();

        return [
            'items' => CartResource::collection($this->collection),
            'total_amount' => $totalAmount ?? 0,
        ];
    }

    private function calculateTotalAmount()
    {
        return $this->collection
            ->filter(function ($cartItem) {
                return $cartItem->is_selected == true;
            })
            ->sum(function ($cartItem) {
                return $cartItem->getSubTotal();
            });
    }
}
