<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\HeaderMenuRepositoryInterface;
use App\Interfaces\FooterMenuRepositoryInterface;
use App\Repositories\HeaderMenuRepository;
use App\Repositories\FooterMenuRepository;
use App\Repositories\CategoryRepository;

use App\Services\LikeService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HeaderMenuRepositoryInterface::class, HeaderMenuRepository::class);
        $this->app->bind(FooterMenuRepositoryInterface::class, FooterMenuRepository::class);
        $this->app->bind(CategoryRepository::class, CategoryRepository::class);
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
