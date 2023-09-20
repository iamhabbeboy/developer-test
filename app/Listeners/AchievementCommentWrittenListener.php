<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementCommentWrittenListener
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
        $achievements = $achievement->get('comment_written', $event->comment->user);

        $event->comment->user->awardAchievement($achievements->keys());
    }
}
