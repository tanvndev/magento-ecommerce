<?php

namespace App\Http\Resources\PaymentMethod;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'image' => $this->image,
            'order' => $this->order,
            'publish' => $this->publish,
            'status' => $this->publish == 1 ? 'Đang sử dụng' : 'Hủy sử dụng',
            'color' => $this->publish == 1 ? 'green' : 'red',
            'settings' => $this->settings,
        ];
    }
}
