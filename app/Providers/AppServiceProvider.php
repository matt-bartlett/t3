<?php

namespace App\Providers;

use Spotify\Http\Request;
use Illuminate\Session\Store;
use Spotify\Auth\Credentials;
use Spotify\Auth\Authenticator;
use Spotify\Contracts\Store\Session;
use Illuminate\Support\ServiceProvider;
use Spotify\Sessions\LaravelSessionHandler;
use Spotify\Contracts\Auth\Authenticator as AuthInterface;

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
        // Bind Spotify credentials.
        $this->app->singleton(Credentials::class, function ($app) {
            return new Credentials(
                getenv('SPOTIFY_CLIENT_ID'),
                getenv('SPOTIFY_CLIENT_SECRET'),
                getenv('SPOTIFY_REDIRECT_URL')
            );
        });

        // Bind Client Credentials to the Spotify authenticator.
        $this->app->bind(AuthInterface::class, function ($app) {
            return new Authenticator(
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
