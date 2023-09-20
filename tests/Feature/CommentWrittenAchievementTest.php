<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Listeners\AchievementCommentWrittenListener;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentWrittenAchievementTest extends TestCase
{
//    use DatabaseTransactions;

    public function test_achievement_after_posting_a_comment()
    {
        Event::fake();
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($comment));

        $this->assertSame(1, $user->achievements->count());
    }

    public function test_five_achievements_upon_posting_twentiesth_comment()
    {
        Event::fake();
        $user = User::factory()->create();
        Comment::factory()->count(19)->create([
            'user_id' => $user->id
        ]);

        $newComment = Comment::factory()->create([
            'user_id' => $user->id
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($newComment));

        $this->assertSame(5, $user->achievements->count());
    }

    public function test_fire_an_event_when_an_achievement_is_awarded()
    {
        Event::fake();

        $user = User::factory()->create();

        Comment::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $newComment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($newComment));

        $achievement = $user->achievements->last();

        Event::assertDispatched(function(AchievementUnlocked $event) use ($user, $achievement) {
            return $event->user->id === $user->id && $event->achievementName = $achievement->title;
        });
    }
}
