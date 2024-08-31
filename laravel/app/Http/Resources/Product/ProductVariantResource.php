<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Attribute\AttributeValueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'key' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'attribute_value_combine' => $this->attribute_value_combine,
            'image' => $this->image ?? [],
            'album' => $this->album,
            'sku' => $this->sku,
            'price' => $this->price,
            'cost_price' => $this->cost_price ?? null,
            'sale_price' => $this->sale_price ?? null,
            'weight' => ($this->weight ?? null),
            'length' => ($this->length ?? null),
            'width' => ($this->width ?? null),
            'height' => ($this->height ?? null),
            'is_discount_time' => $this->is_discount_time,
            'sale_price_time' => [
                $this->sale_price_start_at,
                $this->sale_price_end_at,
            ],
            'stock' => $this->stock ?? 0,
            'stock_color' => getColorForStock($this->stock ?? null),
            'low_stock_amount' => $this->low_stock_amount,
            'attributes' => AttributeValueResource::collection($this->attribute_values),
            'attribute_values' => $this->attribute_values->pluck('name')->implode(' - ') ?? 'Default',
            'is_used' => $this->is_used,
            'lock_color' => $this->getColorForLock($this->is_used),
            'lock_icon' => $this->getIconLock($this->is_used),

        ];
    }

    private function getColorForLock($is_used)
    {
        if ($is_used) {
            return 'red';
        }

        return '';
    }

    private function getIconLock($is_used)
    {
        if ($is_used) {
            return 'fas fa-lock-alt';
        }

        return 'fas fa-lock-open-alt';
    }
}
