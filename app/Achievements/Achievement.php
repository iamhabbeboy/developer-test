<?php

namespace App\Achievements;

use App\Models\User;
use Illuminate\Support\Facades\DB;

abstract class Achievement
{
    protected $model;
    public string $achievementType;

    public function __construct(string $title)
    {
        $this->model = \App\Models\Achievement::firstOrCreate([
            'title' => $title,
            'achievement_type' => $this->achievementType || '',
        ]);
    }

    abstract public function qualify(User $user): bool;

    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
