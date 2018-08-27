<?php

namespace App\T3\Spotify\Http;

use GuzzleHttp\Client;
use App\T3\Spotify\Http\Response;

class Request
{
    /**
     * @var App\T3\Spotify\Response
     */
    private $response;

    /**
     * @var GuzzleHttp\Client
     */
    private $guzzleClient;

    /**
     * Construct the class
     *
     * @param App\T3\Spotify\Response $response
     * @param GuzzleHttp\Client $guzzleClient
     * @return void
     */
    public function __construct(Response $response, Client $guzzleClient)
    {
        $this->response = $response;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Send the request using the Guzzle HTTP Client
     *
     * @param string $url
     * @param string $method
     * @param array $parameters
     * @param array $headers
     * @return stdClass
     */
    public function send($url, $method, $parameters = [], $headers = [])
    {
        if (is_array($parameters) && count($parameters) > 0) {
            $parameters = array('form_params' => $parameters);
        }

        if (is_array($headers) && count($headers) > 0) {
            $headers = array('headers' => $headers);
        }

        // Set any configuration options for Guzzle
        $config = array('http_errors' => false);

        $payload = array_merge($parameters, $headers, $config);

        $response = $this->guzzleClient->request($method, $url, $payload);

        $parsedResponse = $this->response->parse($response);

        return $parsedResponse;
    }
}
