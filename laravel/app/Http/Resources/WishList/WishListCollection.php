<?php

namespace App\Http\Resources\WishList;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WishListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (
            $this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator ||
            $this->resource instanceof \Illuminate\Pagination\Paginator
        ) {
            return [
                'items' => $this->collection->map(function ($wishList) {
                    return new WishListResource($wishList);
                }),
                'total'        => $this->total(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page'    => $this->lastPage(),
                'next_page'    => $this->currentPage() + 1,
            ];
        }

        return parent::toArray($request);
    }
}
