<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AppNotificationEvent;

class AppNotificationSubscriber implements ShouldQueue
{
    /**
     * Handle application created event.
     */
    public function handleApplicationCreated($event)
    {
        // Dispatch AppNotificationEvent
        event(new AppNotificationEvent('New application created: ' . $event->applicationId));
    }

    /**
     * Handle application updated event.
     */
    public function handleApplicationUpdated($event)
    {
        // Dispatch AppNotificationEvent
        event(new AppNotificationEvent('Application updated: ' . $event->applicationId));
    }

    /**
     * Subscribe to the events.
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\ApplicationCreated',
            'App\Listeners\AppNotificationSubscriber@handleApplicationCreated'
        );

        $events->listen(
            'App\Events\ApplicationUpdated',
            'App\Listeners\AppNotificationSubscriber@handleApplicationUpdated'
        );
    }
}
