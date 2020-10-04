<?php

namespace App\Policies;

use App\User;
use App\Owner;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the owner.
     *
     * @param  \App\User  $user
     * @param  \App\Owner  $owner
     * @return mixed
     */
    public function view(User $user, Owner $owner)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('owner@index', $permissions);
    }


    public function viewAny(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('owner@index', $permissions);
    }

    /**
     * Determine whether the user can create owners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('owner@create', $permissions);
    }

    /**
     * Determine whether the user can update the owner.
     *
     * @param  \App\User  $user
     * @param  \App\Owner  $owner
     * @return mixed
     */
    public function update(User $user, Owner $owner)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('owner@update', $permissions);
    }

    /**
     * Determine whether the user can delete the owner.
     *
     * @param  \App\User  $user
     * @param  \App\Owner  $owner
     * @return mixed
     */
    public function delete(User $user, Owner $owner)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('owner@delete', $permissions);
    }
}
