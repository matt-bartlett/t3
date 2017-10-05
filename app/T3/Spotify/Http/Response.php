<?php

namespace App\T3\Spotify\Http;

class Response
{
    /**
     * Parse the raw response from the Spotify into an object
     *
     * @param GuzzleHttp\Psr7\Response $response
     * @return stdClass
     */
    public function parse($response)
    {
        $raw = $response->getBody()->getContents();

        $parsed = json_decode($raw);

        return $parsed;
    }
}
