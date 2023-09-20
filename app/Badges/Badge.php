<?php

namespace App\Badges;

use App\Models\User;

abstract class Badge
{
    private $model;

    public function __construct(string $badgeName, int $achievements)
    {
        $this->model = \App\Models\Badge::firstOrCreate([
            'name' => $badgeName,
            'achievements' => $achievements,
        ]);
    }

    abstract public function qualify(User $user);

    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
