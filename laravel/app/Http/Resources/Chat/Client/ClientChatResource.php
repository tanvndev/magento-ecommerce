<?php

namespace App\Http\Resources\Chat\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'sender_id'     => $this->sender_id,
            'receiver_id'   => $this->receiver_id,
            'fullname'    => $this->fullname,
            'image'       => $this->image,
            'read_at'      => $this->read_at,
            'message'       => $this->message,
            'images'       => $this->images,
            'last_message'       => $this->last_message,
            'last_at'       => $this->last_at,
        ];
    }
}
