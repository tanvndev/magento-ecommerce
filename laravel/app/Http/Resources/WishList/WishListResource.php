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
            'product_id' => $this->product_variant->product_id,
            'image' => $this->product_variant->image,
            'name' => $this->product_variant->name,
            'slug' => $this->product_variant->slug,
            'price' => $this->product_variant->price,
            'stock' => $this->product_variant->stock,
            'attributes'         => implode(', ', $this->product_variant->attribute_values->pluck('name')->toArray()) ?? 'Mặc định',
            'sale_price' => $this->handleSalePrice(),
        ];
    }
    private function handleSalePrice()
    {
        $productVariant = $this->product_variant;
        if (! $productVariant->sale_price || ! $productVariant->price) {
            return null;
        }

        if (
            $productVariant->is_discount_time
            && $productVariant->sale_price_start_at
            && $productVariant->sale_price_end_at
        ) {
            $now = new DateTime;
            $start = new DateTime($productVariant->sale_price_start_at);
            $end = new DateTime($productVariant->sale_price_end_at);

            if ($now < $start || $now > $end) {
                return null;
            }
        }

        return $productVariant->sale_price;
    }
}
