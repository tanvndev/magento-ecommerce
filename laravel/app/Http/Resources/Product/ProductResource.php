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
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'canonical' => $this->canonical,
            'total_stock' => $this->variants->sum('stock'), // Sum the stock values
            'total_stock_color' => getColorForStock($this->variants->sum('stock')),
            'variants' => ProductVariantResource::collection($this->variants),
            'catalogues' => ProductCatalogueResource::collection($this->catalogues),
            'product_catalogue_ids' => $this->catalogues->pluck('id'),
        ];
    }
}
