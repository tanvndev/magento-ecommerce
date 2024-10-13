<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Notification;

use App\Repositories\Interfaces\Notification\NotificationRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Notification\NotificationServiceInterface;

class NotificationService extends BaseService implements NotificationServiceInterface
{
    protected $notificationRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
    ) {
        $this->notificationRepository = $notificationRepository;
    }

    public function getNotificationByUser()
    {
        // return $data;
    }

    public function readNotification(string $id) {}
}
