<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

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
        Scramble::routes(function (Route $route) {
            $paid = 'api/generate-api-key';
            $free = 'api/update-generate-api-key';
            $register = 'api/createUser';
            $login = 'api/loginUser';
            if (Str::startsWith($route->uri, $paid) || Str::startsWith($route->uri, $free)|| Str::startsWith($route->uri, $register)|| Str::startsWith($route->uri, $login)) {
                return false;
            }
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
