<?php

namespace App\Badges;

use App\Models\User;

class Beginner extends Badge
{

    public function __construct()
    {
        parent::__construct('Beginner', 0);
    }

    public function qualify(User $user)
    {
        return !!$user->achievements()->count();
    }
}
