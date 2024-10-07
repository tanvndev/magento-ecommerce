<?php

namespace App\Listeners\Wishlist;

use App\Events\Wishlist\WishListEvent;
use App\Mail\WishListMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWishListEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(WishListEvent $event): void
    {
        Mail::to($event->user->email)->send(new WishListMail($event->user, $event->data));
    }
}
