<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\AchievementCommentWrittenListener;
use App\Listeners\AchievementLessonWatchedListener;
use App\Listeners\BadgeListener;
use App\Listeners\StoreLessonAndCommentData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentWritten::class => [
            AchievementCommentWrittenListener::class,
        ],
        LessonWatched::class => [
            AchievementLessonWatchedListener::class,
        ],
        AchievementUnlocked::class => [
            BadgeListener::class,
        ],
        BadgeUnlocked::class => [
            BadgeListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
