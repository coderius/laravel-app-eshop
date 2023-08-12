<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Widgets\BaseWidget;
use \App\Widgets\Frontend\AdminPanel;
use Illuminate\Contracts\Foundation\Application;

class WidgetServiceProvider extends ServiceProvider
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
        $this->app->bind(AdminPanel::class, function (Application $app, $params = []) {
            return new AdminPanel($params);
        });
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
