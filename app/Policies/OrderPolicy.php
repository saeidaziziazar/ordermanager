<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('order@index', $permissions);
    }

    public function viewAny(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }
        
        return in_array('order@index', $permissions);
    }

    /**
     * Determine whether the user can create orders.
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

        return in_array('order@create', $permissions);
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('order@update', $permissions);
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user)
    {
        $permissions = [];

        foreach ($user->permissions as $per) {
            $permissions[] = $per['permit'];
        }

        return in_array('order@delete', $permissions);
    }

}
