<?php

namespace App\Http\Resources\WishList;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
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
            'user_id' => $this->user_id,
            'product_variant_id' => $this->product_variant_id,
            // 'name' =>  $this->product_variant->name,
            // 'image' => $this->product_variant->image,
            // 'sale_price' => $this->handleSalePrice(),
        ];
    }
    // private function handleSalePrice(){
    //     $productVariant = $this->product_variant;

    //     if (!$productVariant->sale_price || !$productVariant->price) {
    //         return null;
    //     }

    //     if ($productVariant->is_discount_time && $productVariant->sale_price_time){
    //         $now = new DateTime();
    //         $start = new DateTime($productVariant->sale_price_start_at);
    //         $end = new DateTime($productVariant->sale_price_and_at);

    //         if ($now < $start || $now > $end) {
    //             return null;
    //         }
    //     }

    //     return $productVariant->sale_price;
    // }
}
