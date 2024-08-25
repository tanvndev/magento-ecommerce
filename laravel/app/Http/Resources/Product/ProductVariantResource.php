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
            'image' => $this->image,
            'album' => $this->album,
            'sku' => $this->sku,
            'price' => formatToCommas($this->price) . ' ₫',
            'cost_price' => formatToCommas($this->cost_price ?? 0) . ' ₫',
            'sale_price' => formatToCommas($this->sale_price ?? '-') . ' ₫',
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'is_discount_time' => $this->is_discount_time,
            'sale_price_start_at' => $this->sale_price_start_at,
            'sale_price_end_at' => $this->sale_price_end_at,
            'enable_manage_stock' => $this->enable_manage_stock,
            'stock_status' => $this->stock_status,
            'quantity' => $this->quantity,
            'attributes' => AttributeValueResource::collection($this->attribute_values),
        ];
    }
}
