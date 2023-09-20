<?php

namespace App\Services;

use App\Achievements\CommentsWritten\FirstCommentWritten;
use App\Achievements\CommentsWritten\FiveCommentsWritten;
use App\Achievements\CommentsWritten\TenCommentsWritten;
use App\Achievements\CommentsWritten\ThreeCommentsWritten;
use App\Achievements\CommentsWritten\TwentyCommentsWritten;
use App\Achievements\LessonsWatched\FiftyLessonsWatched;
use App\Achievements\LessonsWatched\FirstLessonWatched;
use App\Achievements\LessonsWatched\FiveLessonsWatched;
use App\Achievements\LessonsWatched\TenLessonsWatched;
use App\Achievements\LessonsWatched\TwentyFiveLessonsWatched;
use App\Achievements\LessonsWatched\TwentyLessonsWatched;
use App\Models\User;

class Achievement
{
    /**
     * @var int[]
     */
    public array $data;

    public function __construct()
    {
        $this->data = [
            FirstLessonWatched::class,
            FiftyLessonsWatched::class,
            FiveLessonsWatched::class,
            TenLessonsWatched::class,
            TwentyLessonsWatched::class,
            TwentyFiveLessonsWatched::class,


            FiftyLessonsWatched::class,
            FirstCommentWritten::class,
            ThreeCommentsWritten::class,
            FiveCommentsWritten::class,
            TenCommentsWritten::class,
            TwentyCommentsWritten::class,
        ];
    }

    public function get(string $type, User $user): \Illuminate\Support\Collection
    {
        return collect($this->data)->filter(function ($achievement) use ($type, $user) {
            $ach = new $achievement();

            return $ach->achievementType === $type && $ach->qualify($user)
                ? $ach->primaryKey()
                : null;
        });
    }
}
