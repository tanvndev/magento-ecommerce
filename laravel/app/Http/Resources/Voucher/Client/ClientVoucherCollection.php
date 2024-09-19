<?php

declare(strict_types=1);

namespace App\Http\Resources\Voucher\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientVoucherCollection extends ResourceCollection
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
                'data' => $this->collection->map(function ($voucher) {
                    return new ClientVoucherResource($voucher);
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
