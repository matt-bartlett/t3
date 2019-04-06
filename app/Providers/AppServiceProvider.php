<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\T3\Utils\Format\TrackDurationFormatter;
use App\T3\Utils\Format\PlaylistDurationFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind TrackDurationFormatter to Container
        $this->app->bind('TrackDurationFormatter', function ($app) {
            return new TrackDurationFormatter;
        });

        // Bind PlaylistDurationFormatter to Container
        $this->app->bind('PlaylistDurationFormatter', function ($app) {
            return new PlaylistDurationFormatter;
        });
    }
}
