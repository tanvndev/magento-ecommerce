<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand->name,
            'publish' => $this->publish,
            'product_type' => $this->product_type,
            'description' => $this->description,
            'excerpt' => $this->excerpt,
            'upsell_ids' => $this->upsell_ids,
            'canonical' => $this->canonical,
            'quantity' => $this->quantity,
            'enable_manage_stock' => $this->enable_manage_stock,
            'stock_status' => $this->stock_status,
            'variants' => ProductVariantResource::collection($this->variants),
            'catalogues' => ProductCatalogueResource::collection($this->catalogues),
        ];
    }
}
