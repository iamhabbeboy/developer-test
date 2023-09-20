<?php

namespace App\Badges;

use App\Models\User;

class Advanced extends Badge
{

    public function __construct()
    {
        parent::__construct('Advance', 8);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() >= 8;
    }
}
