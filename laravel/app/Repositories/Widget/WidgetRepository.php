<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Widget;

use App\Models\Widget;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Widget\WidgetRepositoryInterface;

class WidgetRepository extends BaseRepository implements WidgetRepositoryInterface
{
    protected $model;

    public function __construct(
        Widget $model
    ) {
        $this->model = $model;
    }
}
