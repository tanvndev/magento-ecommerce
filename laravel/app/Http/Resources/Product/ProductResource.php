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
            'id'                        => $this->id,
            'key'                       => $this->id,
            'name'                      => $this->name,
            'brand_id'                  => $this->brand_id,
            'brand_name'                => $this->brand->name,
            'publish'                   => $this->publish,
            'product_type'              => $this->product_type,
            'description'               => $this->description,
            'excerpt'                   => $this->excerpt,
            'upsell_ids'                => $this->upsell_ids,
            'canonical'                 => $this->canonical,
            'meta_title'                => $this->meta_title,
            'meta_description'          => $this->meta_description,
            'shipping_ids'              => $this->shipping_ids ?? [],
            'total_stock'               => $this->variants->sum('stock'), // Sum the stock values
            'total_stock_color'         => getColorForStock($this->variants->sum('stock') ?? null),
            'variants'                  => ProductVariantResource::collection($this->variants),
            'catalogues'                => ProductCatalogueResource::collection($this->catalogues),
            'attribute_not_enabled'     => ProductAttributeResource::collection($this->attributes->where('enable_variation', false)),
            'attribute_not_enabled_ids' => $this->attributes->where('enable_variation', false)->pluck('attribute_id'),
            'attribute_enabled'         => ProductAttributeResource::collection($this->attributes->where('enable_variation', true)),
            'attribute_enabled_ids'     => $this->attributes->where('enable_variation', true)->pluck('attribute_id'),
            'product_catalogue_ids'     => $this->catalogues->pluck('id'),
        ];
    }
}
