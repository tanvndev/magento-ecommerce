<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'ward_id' => $this->ward_id,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'description' => $this->description,
            'image' => $this->image,
            'publish' => $this->publish,
            'user_catalogue_id' => $this->user_catalogue_id,
            'user_catalogue' => $this->user_catalogue->code,
        ];
    }
}
