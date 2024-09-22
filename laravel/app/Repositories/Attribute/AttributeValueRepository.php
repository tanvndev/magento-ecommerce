<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Attribute;

use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Attribute\AttributeValueRepositoryInterface;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryInterface
{
    protected $model;

    public function __construct(
        AttributeValue $model
    ) {
        $this->model = $model;
    }
}
