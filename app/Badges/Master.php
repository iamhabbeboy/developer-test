<?php

namespace App\Badges;

use App\Models\User;

class Master extends Badge
{

    public function __construct()
    {
        parent::__construct('Master', 10);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() >= 10;
    }
}
