<?php

namespace App\Listeners;

use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeListener
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
    public function handle(object $event): void
    {

        $badge = new \App\Services\Badge();
        $badges = $badge->get($event->user);

        $event->user->assignBadges($badges);
    }
}
