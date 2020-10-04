<?php

namespace App\Policies;

use App\User;
use App\Costumer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CostumerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Costumer.
     *
     * @param  \App\User  $user
     * @param  \App\Costumer  $Costumer
     * @return mixed
     */
    public function view(User $user, Costumer $costumer)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('costumer@index', $permissions);
    }

    public function viewAny(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('costumer@index', $permissions);
    }

    /**
     * Determine whether the user can create Costumers.
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

        return in_array('costumer@create', $permissions);
    }

    /**
     * Determine whether the user can update the Costumer.
     *
     * @param  \App\User  $user
     * @param  \App\Costumer  $Costumer
     * @return mixed
     */
    public function update(User $user, Costumer $costumer)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('costumer@update', $permissions);
    }

    /**
     * Determine whether the user can delete the Costumer.
     *
     * @param  \App\User  $user
     * @param  \App\Costumer  $Costumer
     * @return mixed
     */
    public function delete(User $user, Costumer $costumer)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('costumer@delete', $permissions);
    }
}
