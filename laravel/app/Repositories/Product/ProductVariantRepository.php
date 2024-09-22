<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Product;

use App\Models\ProductVariant;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;

class ProductVariantRepository extends BaseRepository implements ProductVariantRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductVariant $model
    ) {
        $this->model = $model;
    }
}
