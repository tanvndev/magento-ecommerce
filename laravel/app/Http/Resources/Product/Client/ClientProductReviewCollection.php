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
        $totalReviews = $this->collection->count();

        if ($totalReviews > 0) {
            $oneStarCount = $this->collection->where('rating', 1)->count();
            $twoStarCount = $this->collection->where('rating', 2)->count();
            $threeStarCount = $this->collection->where('rating', 3)->count();
            $fourStarCount = $this->collection->where('rating', 4)->count();
            $fiveStarCount = $this->collection->where('rating', 5)->count();

            return [
                'data' => ProductReviewResource::collection($this->collection),
                'avg_rating' => $this->collection->avg('rating'),

                'one_star' => ($oneStarCount / $totalReviews) * 100,

                'two_star' => ($twoStarCount / $totalReviews) * 100,
                'three_star' => ($threeStarCount / $totalReviews) * 100,
                'four_star' => ($fourStarCount / $totalReviews) * 100,
                'five_star' => ($fiveStarCount / $totalReviews) * 100,
            ];
        }

        return [
            'data' => [],
            'avg_rating' => 0,
            'one_star' => 0,
            'two_star' => 0,
            'three_star' => 0,
            'four_star' => 0,
            'five_star' => 0,
        ];
    }
}
