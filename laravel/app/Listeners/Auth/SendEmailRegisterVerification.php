<?php

namespace App\Listeners\Auth;

use App\Events\Auth\AuthRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailRegisterVerification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(AuthRegisteredEvent $event)
    {
        // Gửi email xác nhận đăng ký
        $event->user->sendEmailVerificationNotification();
    }
}
