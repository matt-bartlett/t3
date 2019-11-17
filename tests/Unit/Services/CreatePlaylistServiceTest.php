<?php

namespace Tests\Unit\Services;

use DB;
use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use App\T3\Services\CreatePlaylistService;
use App\Http\Requests\SpotifyPlaylistRequest;
use Spotify\Resources\Playlist as SpotfiyPlaylist;
use App\T3\Spotify\Transformers\PlaylistTransformer;

class CreatePlaylistServiceTest extends TestCase
{
    public $service;

    /**
     * @return void
     */
    public function setUp() : void
    {
        // Track Mock.
        $trackMock = $this->createMock(Track::class);

        // Playlist Mock.
        $playlistMock = $this->createMock(Playlist::class);

        // Spotify API Mock.
        $apiMock = $this->getMockBuilder(SpotfiyPlaylist::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPlaylist'])
            ->getMock();

        // Spotify API Mock returns the Playlist fixture.
        $apiMock->expects($this->once())
            ->method('getPlaylist')
            ->willReturn($this->getFixture('playlist.txt'));

        // No need to mock the transformer.
        $transformer = new PlaylistTransformer;

        $this->service = new CreatePlaylistService(
            $trackMock,
            $playlistMock,
            $apiMock,
            $transformer
        );

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_service_returns_playlist() : void
    {
        // DB Mock - Stubbing out, not required as part of the unit test
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn(true);

        // Request Mock
        $spotifyPlaylistRequestMock = $this->getMockBuilder(SpotifyPlaylistRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        // Setting the values of the 'get' method calls on the Request object
        $spotifyPlaylistRequestMock->expects($this->exactly(2))
            ->method('get')
            ->will($this->onConsecutiveCalls('matt.bartlett', false));

        $playlist = $this->service->handle($spotifyPlaylistRequestMock);

        $this->assertInternalType('array', $playlist);
        $this->assertEquals('Uplifting Trance', $playlist['name']);
    }

    /**
     * @return void
     */
    public function test_service_overwrites_playlist_name_if_request_parameter_present() : void
    {
        // DB Mock - Stubbing out, not required as part of the unit test
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn(true);

        // Request Mock
        $spotifyPlaylistRequestMock = $this->getMockBuilder(SpotifyPlaylistRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        // Setting the values of the 'get' method calls on the Request object
        $spotifyPlaylistRequestMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->onConsecutiveCalls(
                'matt.bartlett', 'Brand New Playlist Name', 'Brand New Playlist Name'
            ));

        $playlist = $this->service->handle($spotifyPlaylistRequestMock);

        $this->assertEquals('Brand New Playlist Name', $playlist['name']);
    }
}
