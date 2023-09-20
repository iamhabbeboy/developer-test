<?php

namespace App\Services;

use App\Badges\Advanced;
use App\Badges\Beginner;
use App\Badges\Intermediate;
use App\Badges\Master;
use App\Models\User;

class Badge
{
    /**
     * @var int[]
     */
    private array $data;

    public function __construct()
    {
        $this->data = [
            Beginner::class,
            Advanced::class,
            Intermediate::class,
            Master::class,
        ];
    }
    public function get(User $user): \Illuminate\Support\Collection
    {
        return collect($this->data)->map(function ($badge) use ($user) {
            $ach = new $badge();
            return $ach->qualify($user) ? $ach->primaryKey(): null;
        })->filter();
    }
}
