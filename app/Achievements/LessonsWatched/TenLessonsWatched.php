<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement;
use App\Models\User;

class TenLessonsWatched extends Achievement
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('10 lessons Watched');
    }

    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 10;
    }
}
