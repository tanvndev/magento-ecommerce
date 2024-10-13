<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Chat;

use App\Models\Chat;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Chat\ChatRepositoryInterface;

class ChatRepository extends BaseRepository implements ChatRepositoryInterface
{
    protected $model;

    public function __construct(
        Chat $model
    ) {
        $this->model = $model;
    }
}
