<?php

namespace App\Policies;

use App\User;
use App\Transportation;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransportationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the transportation.
     *
     * @param  \App\User  $user
     * @param  \App\Transportation  $transportation
     * @return mixed
     */
    public function view(User $user, Transportation $transportation)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('transportation@index', $permissions);
    }


    public function viewAny(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('transportation@index', $permissions);
    }

    /**
     * Determine whether the user can create transportations.
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
        
        return in_array('transportation@create', $permissions);
    }

    /**
     * Determine whether the user can update the transportation.
     *
     * @param  \App\User  $user
     * @param  \App\Transportation  $transportation
     * @return mixed
     */
    public function update(User $user, Transportation $transportation)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('transportation@update', $permissions);
    }

    /**
     * Determine whether the user can delete the transportation.
     *
     * @param  \App\User  $user
     * @param  \App\Transportation  $transportation
     * @return mixed
     */
    public function delete(User $user, Transportation $transportation)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('transportation@delete', $permissions);
    }
}
