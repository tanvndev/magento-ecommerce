<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Product;

use App\Models\ProductReview;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Product\ProductReviewRepositoryInterface;

class ProductReviewRepository extends BaseRepository implements ProductReviewRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductReview $model
    ) {
        $this->model = $model;
    }
}
