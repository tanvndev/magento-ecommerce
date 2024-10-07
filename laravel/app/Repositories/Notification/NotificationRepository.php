<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Notification\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(
        Notification $model
    ) {
        $this->model = $model;
    }
}
