<?php

namespace App\Http\Resources\ShippingMethod;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
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
            'status' => $this->publish == 1 ? 'Đang sử dụng' : 'Hủy sử dụng',
            'color' => $this->publish == 1 ? 'green' : 'red',
            'publish' => $this->publish,
            'image' => $this->image,
            'base_cost' => $this->base_cost,
        ];
    }
}
