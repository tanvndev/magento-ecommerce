<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\ShippingMethod;

use App\Models\ShippingMethod;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;

class ShippingMethodRepository extends BaseRepository implements ShippingMethodRepositoryInterface
{
    protected $model;

    public function __construct(
        ShippingMethod $model
    ) {
        $this->model = $model;
    }
}
