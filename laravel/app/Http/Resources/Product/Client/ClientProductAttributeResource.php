<?php

namespace App\Http\Resources\Product\Client;

use App\Http\Resources\Attribute\AttributeValueResource;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attributeValueIds = $this->attribute_value_ids ?? [];
        $attributeValues = AttributeValue::whereIn('id', $attributeValueIds)->get();

        return [
            'product_id' => $this->product_id,
            'attribute_id' => $this->attribute_id,
            'attribute_name' => $this->attribute->name,
            'attribute_value_ids' => AttributeValueResource::collection($attributeValues),
            'enable_variation' => $this->enable_variation,
        ];
    }
}
