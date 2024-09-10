<?php

namespace App\Http\Resources\Widget;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
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
            'type' => $this->type,
            'model' => $this->model,
            'model_ids' => $this->model_ids ?? [],
            'description' => $this->description,
            'publish' => $this->publish,
            'order' => $this->order,
            'advertisement_banners' => $this->advertisement_banners ?? [],
            'items' => $this->items ?? [],
        ];
    }
}
