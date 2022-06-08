<?php

namespace App\Policies;

use App\Year;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class YearPolicy
{
    use HandlesAuthorization;

    public function all(User $user, Year $year)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('year@all', $permissions);
    }
}
