<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Enregistre directives Blade et configurations globales applicatives.
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
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);

        Gate::define('manage-animals', function (?User $user): bool {
            return in_array($user?->role, ['admin', 'manager'], true);
        });

        Gate::define('permission', function (?User $user, string $permission): bool {
            return $user !== null && $user->hasPermission($permission);
        });

        Blade::if('role', function (string ...$roles): bool {
            $user = Auth::user();

            return $user !== null && in_array($user->role, $roles, true);
        });
    }
}
