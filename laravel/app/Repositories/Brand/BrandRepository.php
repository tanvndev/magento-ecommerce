<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Brand\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(
        Brand $model
    ) {
        $this->model = $model;
    }
}
