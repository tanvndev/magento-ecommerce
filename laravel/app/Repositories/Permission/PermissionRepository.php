<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Permission\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function __construct(
        Permission $model
    ) {
        $this->model = $model;
    }
}
