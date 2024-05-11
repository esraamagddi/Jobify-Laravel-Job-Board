<?php

namespace App\Providers;

use App\Events\AppNotificationEvent;
use App\Listeners\AppNotificationListener;
use App\Listeners\AppNotificationSubscriber;
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Symfony\Contracts\EventDispatcher\Event as EventDispatcherEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

    }
    protected $subscribe = [
        AppNotificationSubscriber::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Event::listen(
            AppNotificationEvent::class,
            AppNotificationListener::class
        );
    }
}
