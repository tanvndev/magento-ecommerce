<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCatalogueResource extends JsonResource
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
            'key' => $this->key,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'publish' => $this->publish,
            'users_count' => $this->users_count,
            'permissions' => PermissionResource::collection($this->permissions),
        ];
    }
}
