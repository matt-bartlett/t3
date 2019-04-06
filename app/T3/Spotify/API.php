<?php

namespace App\T3\Spotify;

use App\T3\Spotify\Http\Request;

class API
{
    const API_BASE_URL = 'https://api.spotify.com/v1';
    const ACCOUNT_BASE_URL = 'https://accounts.spotify.com';

    /**
     * @var App\T3\Spotify\Http\Request
     */
    private $request;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * Construct the class
     *
     * @param App\T3\Spotify\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Request a users playlist from Spotify
     *
     * @param string $userId
     * @param string $playlistId
     * @return array
     */
    public function getPlaylist($userId, $playlistId)
    {
        $headers = $this->getAuthorizationHeader();

        $url = vsprintf('%s/users/%s/playlists/%s', [
            self::API_BASE_URL,
            $userId,
            $playlistId
        ]);

        $response = $this->request->send($url, 'GET', [], $headers);

        return $response;
    }

    /**
     * Get the authorization header key/value for making Spotify API requests
     *
     * @return array
     */
    private function getAuthorizationHeader()
    {
        return array(
            'Authorization' => 'Bearer ' . $this->getAccessToken()
        );
    }
}
