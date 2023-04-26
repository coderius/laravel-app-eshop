<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        /**
         * Remember, if you create a new service provider to contain your view composer registrations, you will need to add the service provider to the providers array in the config/app.php configuration file.
         */
        // View::composer('layouts.headermenu', function ($view) {
        //     $view->with('items', "hgh");
        // });

        View::composer(
            ['layouts.header', 'layouts.footer', 'layouts.headermenu'],
            'App\Http\View\Composers\HeaderComposer'
        );

    }
}
