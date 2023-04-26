<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LikeService;
use App\Services\CookieService;
use App\Services\ArrayHelper;
use App\Services\PartnersService;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * $app = app();
     * $likeService = $app->make(LikeService::class);
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LikeService::class, LikeService::class);
        $this->app->bind(CookieService::class, CookieService::class);
        $this->app->bind(ArrayHelper::class, ArrayHelper::class);
        $this->app->bind(PartnersService::class, PartnersService::class);
        $this->app->bind(OrdersService::class, OrdersService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
