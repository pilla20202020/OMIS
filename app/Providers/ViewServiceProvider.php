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
        // Using closure based composers...
        View::composer('*', function ($view) {
            if (auth()->user()) {
                $view->with('permissions', getUserPermissions(auth()->user()->id));
            } else {
                $view->with('permissions', []);
            }
        });
    }
}
