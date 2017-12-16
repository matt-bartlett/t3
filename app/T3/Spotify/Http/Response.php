<?php

namespace App\T3\Spotify\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use App\T3\Spotify\Exceptions\BadRequestException;
use App\T3\Spotify\Exceptions\SpotifyRequestException;
use App\T3\Spotify\Exceptions\AuthenticationException;

class Response
{
    /**
     * Determine if response was successful, returning the data as an array.
     * Throw an exception if the response resulted in an error
     *
     * @param GuzzleHttp\Psr7\Response $response
     * @return stdClass
     * @throws App\T3\Spotify\Exceptions\SpotifyRequestException|BadRequestException|AuthenticationException
     */
    public function parse(GuzzleResponse $response)
    {
        $status = $response->getStatusCode();

        if ($status >= 200 && $status <= 299) {
            return $this->success($response);
        }

        if ($status === 400) {
            throw new BadRequestException;
        } elseif ($status === 401) {
            throw new AuthenticationException;
        } else {
            throw new SpotifyRequestException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }
    }

    /**
     * Retrieve the data from the response
     *
     * @param GuzzleHttp\Psr7\Response $response
     * @return stdClass
     */
    private function success(GuzzleResponse $response)
    {
        $raw = $response->getBody()->getContents();

        $parsed = json_decode($raw);

        return $parsed;
    }
}
