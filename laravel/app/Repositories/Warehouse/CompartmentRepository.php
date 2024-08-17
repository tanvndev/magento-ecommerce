<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Warehouse;

use App\Models\Compartment;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Warehouse\CompartmentRepositoryInterface;

class CompartmentRepository extends BaseRepository implements CompartmentRepositoryInterface
{
    protected $model;

    public function __construct(
        Compartment $model
    ) {
        $this->model = $model;
    }
}
