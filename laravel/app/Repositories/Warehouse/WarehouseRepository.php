<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Warehouse;

use App\Models\Warehouse;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Warehouse\WarehouseRepositoryInterface;

class WarehouseRepository extends BaseRepository implements WarehouseRepositoryInterface
{
    protected $model;

    public function __construct(
        Warehouse $model
    ) {
        $this->model = $model;
    }
}
