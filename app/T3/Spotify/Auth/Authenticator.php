<?php

namespace App\T3\Spotify\Auth;

use App\T3\Spotify\Http\Request;
use Illuminate\Session\SessionManager;

class Authenticator
{
    const AUTH_URL = 'https://accounts.spotify.com/api/token';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var App\T3\Spotify\Request
     */
    private $request;

    /**
     * @var Illuminate\Session\SessionManager
     */
    private $session;

    /**
     * Construct the class
     *
     * @param App\T3\Spotify\Request $request
     * @param Illuminate\Session\SessionManager $session
     * @return void
     */
    public function __construct(Request $request, SessionManager $session)
    {
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Retrieve a valid access token from the session, if available.
     * Ping the Spotify API for a fresh access token if none previously
     * stored, or if the access token has expired
     *
     * @return string
     */
    public function getAccessToken()
    {
        if ($this->isAccessTokenValid()) {
            return $this->session->get('access_token');
        }

        $response = $this->authenticate();

        $this->setSessionCredentials($response);

        return $response->access_token;
    }

    /**
     * Set the credentials returned from Spotify to the session
     *
     * @param array $response
     * @return void
     */
    private function setSessionCredentials($response)
    {
        $this->session->put([
            'expires_in' => (time() + $response->expires_in),
            'access_token' => $response->access_token
        ]);
    }

    /**
     * Determine if the stored access token is valid for use
     *
     * @return boolean
     */
    private function isAccessTokenValid()
    {
        $expiresIn = $this->session->get('expires_in', false);
        $accessToken = $this->session->get('access_token', false);

        if ($expiresIn && $accessToken && time() < $expiresIn) {
            return true;
        }

        return false;
    }

    /**
     * Authenticate with Spotify using the Client Credentials Flow
     *
     * @return stdClass
     */
    private function authenticate()
    {
        // Encode the app Client ID & Client Secret for authorization
        $authorization = base64_encode($this->getClientId() . ':' . $this->getClientSecret());

        // Set headers
        $headers = array(
            'Authorization' => 'Basic ' . $authorization
        );

        // Set post params
        $parameters = array(
            'grant_type' => 'client_credentials'
        );

        // Make request for access token
        $response = $this->request->send(self::AUTH_URL, 'POST', $parameters, $headers);

        return $response;
    }
}
