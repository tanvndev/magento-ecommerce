<?php

namespace App\Http\Resources\UserAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'province'         => $this->province->name,
            'district'         => $this->district->name,
            'ward'             => $this->ward->name,
            'fullname'         => $this->fullname,
            'shipping_address' => $this->shipping_address,
            'phone'            => $this->phone,
            'is_primary'       => $this->is_primary,
        ];
    }
}