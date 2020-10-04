<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    // public function view(User $user, User $user)
    // {
    //     //
    // }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function all(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('user@all', $permissions);
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    // public function edit(User $auth_user, User $user)
    // {
    //     dd($user);
    //     $permissions = [];

    //     foreach ($user->permissions as $per) {
    //         $permissions[] = $per['permit'];
    //     }
        
    //     return in_array('user@all', $permissions);
    // }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    // public function delete(User $user, User $user)
    // {
    //     //
    // }
}
