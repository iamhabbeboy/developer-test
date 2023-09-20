<?php

namespace App\Badges;

use App\Models\User;

class Intermediate extends Badge
{

    public function __construct()
    {
        parent::__construct('Intermediate', 4);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() >= 4;
    }
}
