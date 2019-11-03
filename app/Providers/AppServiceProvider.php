<?php

namespace App\Providers;

use Spotify\Http\Request;
use Spotify\Auth\Credentials;
use Illuminate\Session\Store;
use Spotify\Contracts\Store\Session;
use Illuminate\Support\ServiceProvider;
use Spotify\Auth\Flows\ClientCredentials;
use Spotify\Contracts\Auth\Authenticator;
use Spotify\Sessions\LaravelSessionHandler;
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

        // Bind Spotify credentials.
        $this->app->singleton(Credentials::class, function ($app) {
            return new Credentials(
                getenv('SPOTIFY_CLIENT_ID'),
                getenv('SPOTIFY_CLIENT_SECRET'),
                getenv('SPOTIFY_REDIRECT_URL')
            );
        });

        // Bind Client Credentials to the Spotify authenticator.
        $this->app->bind(Authenticator::class, function ($app) {
            return new ClientCredentials(
                $app->make(Request::class),
                $app->make(Credentials::class)
            );
        });

        // Bind the Laravel Session handler.
        $this->app->bind(Session::class, function ($app) {
            return new LaravelSessionHandler(
                $app->make(Store::class)
            );
        });
    }
}
