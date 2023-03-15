<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\AlStyle;

class AlStyleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Style', AlStyle::class);
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
