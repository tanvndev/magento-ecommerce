<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Attribute;

use App\Models\Attribute;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Attribute\AttributeRepositoryInterface;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
    protected $model;

    public function __construct(
        Attribute $model
    ) {
        $this->model = $model;
    }
}
