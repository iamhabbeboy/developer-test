<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function assignBadges($badges): static
    {
        $this->badges()->syncWithoutDetaching($badges);
        $lastBadge = $this->badges->last();
        BadgeUnlocked::dispatch($this, $lastBadge->name);
        return $this;
    }

    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function awardAchievement($achievements): static
    {
//        if(!$this->achievements->count()) {
//            return $this;
//        }
        $this->achievements()->syncWithoutDetaching($achievements);
        $lastAchievement = $this->achievements->last();
        AchievementUnlocked::dispatch($this, $lastAchievement->title ?? "");
        return $this;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }
}
