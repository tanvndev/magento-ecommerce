<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'user_id'           => $this->user->id,
            'user_name'         => $this->user->fullname,
            'name'              => $this->name,
            'image'             => $this->image,
            'description'       => $this->description,
            'content'           => $this->content,
            'canonical'         => $this->canonical,
            'icon'              => $this->icon,
            'order'             => $this->order,
            'meta_title'        => $this->meta_title,
            'meta_keyword'      => $this->meta_keyword,
            'meta_description'  => $this->meta_description,
            'publish'           => $this->publish,
        ];
    }
}
