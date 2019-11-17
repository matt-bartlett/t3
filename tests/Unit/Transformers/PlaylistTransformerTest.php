<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use App\Models\Playlist;
use App\T3\Transformers\PlaylistTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlaylistTransformerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public $playlist;

    public function setUp() : void
    {
        parent::setUp();
        $this->playlist = new Playlist;
    }

    /**
     * @return void
     */
    public function test_playlist_model_transforms() : void
    {
        $expected = [
            'data' => [
                'id' => 999,
                'name' => 'T3 Playlist #1',
                'owner' => '999999999',
                'duration' => 0,
                'owner_name' => '999999999',
                'playlist_url' => 'https://api.spotify.com/playlist/123456789',
                'owner_profile_url' => 'https://api.spotify/com/user/999999999',
                'playlist_thumbnail_url' => 'https://mosaic.scdn.co/640/123456789'
            ]
        ];

        $playlist = new Playlist;
        $playlist->id = 999;
        $playlist->name = 'T3 Playlist #1';
        $playlist->owner_id = '999999999';
        $playlist->owner_profile_url = 'https://api.spotify/com/user/999999999';
        $playlist->playlist_url = 'https://api.spotify.com/playlist/123456789';
        $playlist->playlist_thumbnail_url = 'https://mosaic.scdn.co/640/123456789';

        $output = fractal($playlist, new PlaylistTransformer)->toArray();

        $this->assertEquals($output, $expected);
    }

    /**
     * @return void
     */
    public function test_playlist_collection_with_pagination_has_meta_and_data_keys() : void
    {
        $playlists = factory(Playlist::class, 10)->create();

        $paginated = $this->playlist->paginate(5);

        $output = fractal($paginated, new PlaylistTransformer)->toArray();

        $this->assertArrayHasKey('data', $output);
        $this->assertArrayHasKey('meta', $output);

        $this->assertEquals(5, $output['meta']['pagination']['count']);
        $this->assertEquals(5, $output['meta']['pagination']['per_page']);
        $this->assertEquals(1, $output['meta']['pagination']['current_page']);
    }
}
