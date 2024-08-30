<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'attribute_id' => $this->attribute_id,
            'attribute_name' => $this->attribute->name,
            'attribute_value_ids' => $this->attribute_value_ids,
            'enable_variation' => $this->enable_variation,
        ];
    }
}
