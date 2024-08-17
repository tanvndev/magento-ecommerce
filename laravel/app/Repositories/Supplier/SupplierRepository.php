<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Supplier;

use App\Models\Supplier;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Supplier\SupplierRepositoryInterface;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    protected $model;

    public function __construct(
        Supplier $model
    ) {
        $this->model = $model;
    }
}
