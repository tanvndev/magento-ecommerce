<?php

namespace App\Http\Resources\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'phone' => $this->phone,
            'total_capacity' => formatToCommas(round($this->total_capacity, 0)).' KG',
            'used_capacity' => $this->used_capacity / $this->total_capacity * 100 .'%',
            'row' => $this->row,
            'supervisor_name' => $this->supervisor_name,
            'address' => $this->address,
            'description' => $this->description,
            'publish' => $this->publish,
            'aisles_number' => $this->aisles_number,
            'racks_number' => $this->racks_number,
            'shelves_number' => $this->shelves_number,
            'compartments_number' => $this->compartments_number,
        ];
    }
}
