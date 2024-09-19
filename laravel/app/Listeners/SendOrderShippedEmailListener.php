<?php

namespace App\Listeners;

use App\Events\OrderShippedEvent;
use App\Mail\OrderShippedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderShippedEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

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
