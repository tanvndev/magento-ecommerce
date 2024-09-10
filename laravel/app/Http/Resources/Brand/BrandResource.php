<?php

namespace App\Http\Resources\Brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'canonical' => $this->canonical,
            'name' => $this->name,
            'description' => $this->description,
            'publish' => $this->publish,
            'is_featured' => $this->is_featured,
            'image' => $this->image,
        ];
    }
}
