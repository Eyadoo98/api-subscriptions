<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('apiGetUser', function (Request $request) {
            return Limit::perMinute(1)->by($request->user()?->id ?: $request->ip());
        });

//        Here
        RateLimiter::for('freeApiMinutelyThrottle', function ($request) {
            return Limit::perMinute(5)->by($request->header('API-Key'));
        });

        RateLimiter::for('freeApiHourlyThrottle', function ($request) {
            return Limit::perHour(30)->by($request->header('API-Key'));
        });

        RateLimiter::for('freeApiDailyThrottle', function ($request) {
            return Limit::perDay(100)->by($request->header('API-Key'));
        });

//        paid
        RateLimiter::for('paidApiMinutelyThrottle', function ($request) {
            return Limit::perMinute(10)->by($request->header('API-Key'));
        });

        RateLimiter::for('paidApiHourlyThrottle', function ($request) {
            return Limit::perHour(40)->by($request->header('API-Key'));
        });

        RateLimiter::for('paidApiDailyThrottle', function ($request) {
            return Limit::perDay(50)->by($request->header('API-Key'));
        });
        //        paid
//        Here

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
