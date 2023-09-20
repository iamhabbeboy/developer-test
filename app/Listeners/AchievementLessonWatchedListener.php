<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementLessonWatchedListener
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
        $achievement = new \App\Services\Achievement();
        $achievements = $achievement->get('lesson_watched', $event->user);

        $event->user->awardAchievement($achievements->keys());
    }
}
