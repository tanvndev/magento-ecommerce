<?php

namespace App\Listeners;

use App\Events\Order\OrderShippedEvent;
use App\Mail\OrderShippedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderShippedEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(OrderShippedEvent $event): void
    {
        Mail::to($event->order->user->email)->send(
            new OrderShippedMail($event->order)
        );
    }
}
