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
            'carts' => CartResource::collection($this->collection),
            'total_amount' => [
                'total_amount' => $totalAmount,
            ],
        ];
    }

    private function calculateTotalAmount()
    {
        return $this->collection->sum(function ($cartItem) {
            return $cartItem->getSubTotal();
        });
    }
}
