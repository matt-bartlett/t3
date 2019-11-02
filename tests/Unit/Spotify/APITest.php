<?php

namespace Tests\Unit\Spotify;

use Tests\TestCase;
use GuzzleHttp\Client;
use App\T3\Spotify\API;
use App\T3\Spotify\Http\Request;
use App\T3\Spotify\Http\Response;

class SpotifyAPITest extends TestCase
{
    public $requestMock;
    public $responseMock;
    public $guzzleClientMock;
    public $accessToken = 'bLXHYJKtHgkrW5bQ8pGet4LD';

    /**
     * @return void
     */
    public function setUp() : void
    {
        // Response Mock
        $this->responseMock = $this->createMock(Response::class);

        // Guzzle Client Mock
        $this->guzzleClientMock = $this->createMock(Client::class);

        // Request Mock
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->setConstructorArgs(array(
                $this->responseMock,
                $this->guzzleClientMock
            ))
            ->setMethods(array('send'))
            ->getMock();

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_access_token_getter_setter()
    {
        // Instantiate API class
        $api = new API($this->requestMock);
        $api->setAccessToken($this->accessToken);

        $this->assertEquals($this->accessToken, $api->getAccessToken());
    }

    /**
     * @return void
     */
    public function test_get_playlist_returns_object()
    {
        $this->requestMock->expects($this->once())
            ->method('send')
            ->willReturn($this->getFixture('playlist.txt'));

        // Instantiate API class
        $api = new API($this->requestMock);
        $response = $api->getPlaylist('1196791157', '1xBKhvSXwCOcXEDyrWXOLf');

        $this->assertInternalType('object', $response);
        $this->assertObjectHasAttribute('tracks', $response);
    }
}
