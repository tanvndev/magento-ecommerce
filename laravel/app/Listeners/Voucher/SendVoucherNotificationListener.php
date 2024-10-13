<?php

namespace App\Listeners\Voucher;

use App\Models\User;
use App\Notifications\NewVoucherNotification;
use Exception;
use Illuminate\Support\Facades\Notification;

class SendVoucherNotificationListener
{
    // Thoi gian cho job
    public $timeout = 60;

    // Lan thu lai neu that bai
    public $tries = 3;

    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        try {
            User::chunk(1000, function ($users) use ($event) {
                Notification::send($users, new NewVoucherNotification($event->voucher));
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
