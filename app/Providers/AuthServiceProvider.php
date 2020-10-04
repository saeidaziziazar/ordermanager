<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Order;
use App\Costumer;
use App\Owner;
use App\Transportation;
use App\User;
use App\Policies\OrderPolicy;
use App\Policies\CostumerPolicy;
use App\Policies\OwnerPolicy;
use App\Policies\TransportationPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Order::class => OrderPolicy::class,
        Costumer::class => CostumerPolicy::class,
        Owner::class => OwnerPolicy::class,
        Transportation::class => TransportationPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
