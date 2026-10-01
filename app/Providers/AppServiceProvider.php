<?php

namespace App\Providers;

use App\Models\Sesion;
use App\Models\User;
use App\Policies\SesionPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define("admin", fn (User $user) => $user->role === "a");
        Gate::policy(Sesion::class, SesionPolicy::class);
        Model::preventLazyLoading(!app()->isProduction());
    }
}
