<?php

namespace App\Http\Resources\Attribute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeCatalogueResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'publish' => $this->publish,
            'attributes' => AttributeResource::collection($this->attributes),
        ];
    }
}
