<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Location;

use App\Models\Ward;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Location\WardRepositoryInterface;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    protected $model;

    public function __construct(
        Ward $model
    ) {
        $this->model = $model;
    }
}
