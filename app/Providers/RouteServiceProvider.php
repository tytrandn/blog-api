<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use App\Repositories\ConfigRepository;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        $configRepo = app(ConfigRepository::class);

        RateLimiter::for('api', function (Request $request) use ($configRepo) {
            return Limit::perMinute($configRepo->getApiRateLimit())->by($request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

}
