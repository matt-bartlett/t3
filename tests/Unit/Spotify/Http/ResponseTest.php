<?php

namespace Tests\Unit\Spotify\Http;

use Tests\TestCase;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Handler\MockHandler;
use App\T3\Spotify\Http\Response;
use App\T3\Spotify\Exceptions\BadRequestException;
use App\T3\Spotify\Exceptions\SpotifyRequestException;
use App\T3\Spotify\Exceptions\AuthenticationException;


class ResponseTest extends TestCase
{
    public $response;

    /**
     * @return void
     */
    public function setUp()
    {
        // Instantiate Response class
        $this->response = new Response;

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_response_throws_exception()
    {
        $this->expectException(SpotifyRequestException::class);
        $this->expectExceptionMessage('Internal Server Error');

        $guzzleResponse = new GuzzleResponse(500);

        $this->response->parse($guzzleResponse);
    }

    /**
     * @return void
     */
    public function test_response_throws_bad_request_exception()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Your request is invalid or has missing paramters');

        $guzzleResponse = new GuzzleResponse(400);

        $this->response->parse($guzzleResponse);
    }

    /**
     * @return void
     */
    public function test_response_throws_authentication_exception()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Your access token is invalid or has expired');

        $guzzleResponse = new GuzzleResponse(401);

        $this->response->parse($guzzleResponse);
    }

    /**
     * @return void
     */
    public function test_response_successfully_parses()
    {
        $data = json_encode([
            'tracks' => [
                'name' => 'Sanctuary',
                'artist' => 'Gareth Emery',
                'album' => 'Northen Lights'
            ]
        ]);

        $stream = Psr7\stream_for($data);
        $guzzleResponse = new GuzzleResponse(200, [], $stream);

        $response = $this->response->parse($guzzleResponse);

        $this->assertEquals($response, json_decode($data));
        $this->assertInternalType('object', $response);
        $this->assertObjectHasAttribute('tracks', $response);
    }
}
