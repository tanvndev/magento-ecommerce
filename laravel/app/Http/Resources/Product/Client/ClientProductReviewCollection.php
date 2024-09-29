<?php

namespace App\Http\Resources\Product\Client;

use App\Http\Resources\Product\ProductReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientProductReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avgRating = $this->collection->avg('rating');

        return [
            'data' => ProductReviewResource::collection($this->collection),
            'avg_rating' => $avgRating,

            'one_star' => $this->collection->where('rating', 1)->count(),
            'two_star' => $this->collection->where('rating', 2)->count(),
            'three_star' => $this->collection->where('rating', 3)->count(),
            'four_star' => $this->collection->where('rating', 4)->count(),
            'five_star' => $this->collection->where('rating', 5)->count(),
            'avg_rating_percentage' => ($avgRating / 5) * 100,
        ];
    }
}
