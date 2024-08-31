<?php

namespace App\Http\Resources\SystemConfig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemConfigResource extends JsonResource
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
            'user_id' => $this->user_id,
            'code' => $this->code,
            'content' => $this->content,
        ];
    }
}
