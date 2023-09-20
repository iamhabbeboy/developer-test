<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement;
use App\Models\User;

class FiveLessonsWatched extends Achievement
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('5 lessons Watched');
    }

    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 5;
    }
}
