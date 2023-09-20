<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Listeners\BadgeListener;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BadgeUnlockTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_beginner_badge_for_less_than_four_achievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $achievement = $user->achievements->first();

        (new BadgeListener())->handle(new AchievementUnlocked($user, $achievement->title));

        $this->assertSame('Beginner', $user->badges->first()->name);

    }

    public function test_intermediate_badge_for_four_achievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(7)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new BadgeListener())->handle(new AchievementUnlocked($user, $lastAchievement->title));

        $this->assertSame('Intermediate', $user->badges->fresh()->last()->name);
    }
}
