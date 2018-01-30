<?php

namespace Tests\Unit\Services;

use DB;
use Tests\TestCase;
use App\Models\Playlist;
use App\T3\Spotify\API;
use App\T3\Spotify\Client;
use App\T3\Spotify\Auth\Authenticator;
use App\T3\Services\CreatePlaylistService;
use App\Http\Requests\SpotifyPlaylistRequest;

class CreatePlaylistServiceTest extends TestCase
{
    public $service;

    /**
     * @return void
     */
    public function setUp()
    {
        // Playlist Mock
        $playlist = $this->createMock(Playlist::class);

        // Client Mock
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getApi'))
            ->getMock();

        // API Mock
        $apiMock = $this->getMockBuilder(API::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getPlaylist'))
            ->getMock();

        // API Mock returns the Playlist fixture
        $apiMock->expects($this->once())
            ->method('getPlaylist')
            ->willReturn($this->getFixture('playlist.txt'));

        $clientMock->expects($this->once())
            ->method('getApi')
            ->willReturn($apiMock);

        $this->service = new CreatePlaylistService($playlist, $clientMock);

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_service_returns_playlist()
    {
        // DB Mock - Stubbing out, not required as part of the unit test
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn(true);

        // Request Mock
        $spotifyPlaylistRequestMock = $this->getMockBuilder(SpotifyPlaylistRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        // Setting the values of the 'get' method calls on the Request object
        $spotifyPlaylistRequestMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->onConsecutiveCalls('matt.bartlett', '123456', false));

        $playlist = $this->service->make($spotifyPlaylistRequestMock);

        $this->assertInternalType('array', $playlist);
        $this->assertEquals('Uplifting Trance', $playlist['name']);
    }

    /**
     * @return void
     */
    public function test_service_overwrites_playlist_name_if_request_parameter_present()
    {
        // DB Mock - Stubbing out, not required as part of the unit test
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn(true);

        // Request Mock
        $spotifyPlaylistRequestMock = $this->getMockBuilder(SpotifyPlaylistRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        // Setting the values of the 'get' method calls on the Request object
        $spotifyPlaylistRequestMock->expects($this->exactly(4))
            ->method('get')
            ->will($this->onConsecutiveCalls(
                'matt.bartlett', '123456', 'Brand New Playlist Name', 'Brand New Playlist Name'
            ));

        $playlist = $this->service->make($spotifyPlaylistRequestMock);

        $this->assertEquals('Brand New Playlist Name', $playlist['name']);
    }
}
