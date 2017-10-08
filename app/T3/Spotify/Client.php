<?php

namespace App\T3\Spotify;

use App\T3\Spotify\SpotifyAPI;
use App\T3\Spotify\Auth\Authenticator;
use App\T3\Spotify\Transformers\TransformerInterface;

class Client
{
    /**
     * @var App\T3\Spotify\SpotifyAPI
     */
    private $api;

    /**
     * @var App\T3\Spotify\Auth\Authenticator
     */
    private $authenticator;

    /**
     * Construct the class
     *
     * @param App\T3\Spotify\SpotifyAPI $api
     * @param App\T3\Spotify\Auth\Authenticator $authenticator
     * @return void
     */
    public function __construct(SpotifyAPI $api, Authenticator $authenticator)
    {
        $this->api = $api;
        $this->authenticator = $authenticator;
    }

    /**
     * Retrieve a users playlist
     *
     * @param string $userId
     * @param string $playlistId
     * @return stdClass
     */
    public function getPlaylist($userId, $playlistId)
    {
        $accessToken = $this->retrieveAccessToken();

        $this->api->setAccessToken($accessToken);

        $response = $this->api->getPlaylist($userId, $playlistId);

        return $response;
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
        $this->authenticator->setClientId(env('SPOTIFY_CLIENT_ID'));
        $this->authenticator->setClientSecret(env('SPOTIFY_CLIENT_SECRET'));

        $accessToken = $this->authenticator->getAccessToken();

        return $accessToken;
    }
}
