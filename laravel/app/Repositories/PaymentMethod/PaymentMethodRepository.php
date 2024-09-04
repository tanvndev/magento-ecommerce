<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PaymentMethod\PaymentMethodRepositoryInterface;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    protected $model;

    public function __construct(
        PaymentMethod $model
    ) {
        $this->model = $model;
    }
}
