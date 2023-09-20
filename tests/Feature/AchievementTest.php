<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\AchievementCommentWrittenListener;
use App\Listeners\AchievementLessonWatchedListener;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementTest extends TestCase
{

    public function test_user_achievements_by_writing_comment()
    {
        Event::fake();
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($comment));

        $this->assertSame(1, $user->achievements->count());
    }

//    public function test_user_achievements_by_watching_lesson()
//    {
//        Event::fake();
//        $user = User::factory()->create();
//        $lesson = Lesson::factory()->create();
//        $user->lessons()->attach($lesson, ['watched' => true]);
//
//        (new AchievementLessonWatchedListener())->handle(new LessonWatched($lesson, $user));
//        $this->assertTrue(true);
//        $this->assertSame(1, $user->achievements->count());
//    }
}
