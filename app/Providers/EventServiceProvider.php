<?php

namespace App\Providers;

use App\Listeners\SendRegistrationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendRegistrationNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
