<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
