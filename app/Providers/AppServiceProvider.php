<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        //
        Paginator::useBootstrapFive();
        RateLimiter::for('login',function(Request $request){
        return[
            Limit::perMinute(5)
                ->by($request->ip()),
                //عداد لكل مستخدم بتعرف عليه من خلال ال ip
            Limit::perHour(100)
                ->by($request->ip()),
            Limit::perDay(300)
                ->by($request->ip()),
    ];
        });
        RateLimiter::for('users',function(Request $request){
        return[
            Limit::perMinute(5)
                ->by($request->user()->id),
                //عداد لكل مستخدم بتعرف عليه من خلال ال id
            Limit::perHour(100)
                ->by($request->user()->id),
            Limit::perDay(300)
                ->by($request->user()->id),
    ];
        });
    }
}
