<?php

namespace App\T3\Spotify;

use App\T3\Spotify\API;
use App\T3\Spotify\Auth\Authenticator;
use App\T3\Spotify\Transformers\TransformerInterface;

class Client
{
    /**
     * @var App\T3\Spotify\API
     */
    private $api;

    /**
     * @var App\T3\Spotify\Auth\Authenticator
     */
    private $authenticator;

    /**
     * Construct the class
     *
     * @param App\T3\Spotify\API $api
     * @param App\T3\Spotify\Auth\Authenticator $authenticator
     * @return void
     */
    public function __construct(API $api, Authenticator $authenticator)
    {
        $this->api = $api;
        $this->authenticator = $authenticator;
    }

    /**
     * Return the API class
     *
     * @return App\T3\Spotify\API
     */
    public function getApi()
    {
        $accessToken = $this->retrieveAccessToken();

        $this->api->setAccessToken($accessToken);

        return $this->api;
    }

    /**
     * Transform the response into a custom format
     *
     * @param stdClass $response
     * @param App\T3\Spotify\Transformers\TransformerInterface $transformer
     * @return array
     */
    public function transform($response, TransformerInterface $transformer)
    {
        return $transformer->transform($response);
    }

    /**
     * Get an access token to perform requests to the Spotify API
     *
     * @return string
     */
    private function retrieveAccessToken()
    {
        $this->authenticator->setClientId(getenv('SPOTIFY_CLIENT_ID'));
        $this->authenticator->setClientSecret(getenv('SPOTIFY_CLIENT_SECRET'));

        $accessToken = $this->authenticator->getAccessToken();

        return $accessToken;
    }
}
