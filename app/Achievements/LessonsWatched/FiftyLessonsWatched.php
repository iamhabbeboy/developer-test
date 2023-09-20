<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement;
use App\Models\User;

class FiftyLessonsWatched extends Achievement
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct("50 Lessons Watched");
    }

    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 50;
    }
}
