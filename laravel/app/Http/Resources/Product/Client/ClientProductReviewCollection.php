<?php

namespace App\Http\Resources\Product\Client;

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

        $starCounts = $this->collection->groupBy('rating')->map->count();
        $avgRating = $totalReviews > 0 ? round($this->collection->avg('rating'), 2) : 0;

        $percentages = [];
        for ($i = 1; $i <= 5; $i++) {
            $percentages["_{$i}_star"] = $totalReviews > 0 ? round(($starCounts->get($i, 0) / $totalReviews) * 100, 2) : 0;
        }

        return [
            'items' => ClientProductReviewResource::collection($this->collection),
            'avg_rating' => $avgRating,
            'avg_rating_percent' => starsToPercent($avgRating),
        ] + $percentages;
    }
}
