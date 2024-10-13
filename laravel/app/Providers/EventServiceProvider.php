<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        'Registered'::class => [
            'Illuminate\Auth\Listeners\SendEmailVerificationNotification',
        ],
        'App\Events\Auth\AuthRegisteredEvent'::class => [
            'App\Listeners\Auth\SendEmailRegisterVerification',
        ],
        'App\Events\Auth\AuthForgotEvent' => [
            'App\Listeners\Auth\SendEmailResetPassword',
        ],
        'App\Events\Order\OrderShippedEvent' => [
            'App\Listeners\Order\SendOrderShippedEmailListener',
        ],
<<<<<<< HEAD
=======
        'App\Events\Wishlist\WishListEvent' => [
            'App\Listeners\Wishlist\SendWishListEmailListener',
        ],
        'App\Events\Voucher\VoucherCreatedEvent' => [
            'App\Listeners\Voucher\SendVoucherNotificationListener',
        ],
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void {}

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
