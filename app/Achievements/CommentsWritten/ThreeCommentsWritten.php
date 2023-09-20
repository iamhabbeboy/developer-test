<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement;
use App\Models\User;

class ThreeCommentsWritten extends Achievement
{
    public string $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('3 Comments Written');
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function qualify(User $user): bool
    {
        return $user->comments()->count() >= 3;
    }
}
