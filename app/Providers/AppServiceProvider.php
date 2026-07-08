<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Otorization for Admin role (Full Access Feature)
        Gate::define('access-admin', function (User $user) {
            return in_array($user->role, ['admin']);
        });

        // Otorization for Staff role (Limited Access / Read Only)
        Gate::define('access-staff', function (User $user) {
            return in_array($user->role, ['admin', 'staff']);
        });
    }
}
