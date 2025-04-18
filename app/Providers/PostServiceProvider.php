<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Post\Services\PostService;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PostService::class, function ($app) {
            return new PostService();
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
