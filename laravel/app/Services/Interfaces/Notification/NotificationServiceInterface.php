<?php

namespace App\Services\Interfaces\Notification;

interface NotificationServiceInterface
{
    public function getNotificationByUser();

    public function readNotification(string $id);
}
