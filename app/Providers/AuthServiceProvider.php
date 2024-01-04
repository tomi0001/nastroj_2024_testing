<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
 //$this->registerPolicies();

    // define admin role
    Gate::define('users', function($user) {
         return $user->type == 'user';
         //return 
    });

    // define user role
    Gate::define('doctor', function($user) {
        return $user->type == 'doctor';
    });
        //
    }
}
