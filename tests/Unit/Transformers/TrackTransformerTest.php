<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use App\T3\Transformers\TrackTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackTransformerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_track_model_transforms() : void
    {
        $expected = array(
            'data' => array(
                'title' => 'Sanctuary - Ben Gold Remix',
                'album' => 'Sanctuary Remixes',
                'artist' => 'Gareth Emery',
                'duration' => 408358,
                'spotify_url' => 'https://open.spotify.com/track/3IclZs4N6q5iKZ35vr9Jxe',
                'spotify_track_id' => '3IclZs4N6q5iKZ35vr9Jxe',
                'duration_formatted' => '6:48',
                'spotify_preview_url' => 'https://p.scdn.co/mp3-preview/af5bc221004848f44f96eef3196cfe11755639df?cid=8897482848704f2a8f8d7c79726a70d4',
                'spotify_thumbnail_url' => 'https://i.scdn.co/image/9d9995440c5446b4d4edc4a1fac1c913e8a2aded'
            )
        );

        $track = new Track;
        $track->id = 999999;
        $track->title = 'Sanctuary - Ben Gold Remix';
        $track->artist = 'Gareth Emery';
        $track->album = 'Sanctuary Remixes';
        $track->duration = 408358;
        $track->spotify_track_id = '3IclZs4N6q5iKZ35vr9Jxe';
        $track->spotify_url = 'https://open.spotify.com/track/3IclZs4N6q5iKZ35vr9Jxe';
        $track->spotify_preview_url = 'https://p.scdn.co/mp3-preview/af5bc221004848f44f96eef3196cfe11755639df?cid=8897482848704f2a8f8d7c79726a70d4';
        $track->spotify_thumbnail_url = 'https://i.scdn.co/image/9d9995440c5446b4d4edc4a1fac1c913e8a2aded';

        $output = fractal($track, new TrackTransformer)->toArray();

        $this->assertEquals($output, $expected);
    }

    /**
     * @return void
     */
    public function test_track_transform_includes_playlist_collection() : void
    {
        $expected = array(
            'data' => array(
                'title' => 'Sanctuary - Ben Gold Remix',
                'album' => 'Sanctuary Remixes',
                'artist' => 'Gareth Emery',
                'duration' => 408358,
                'spotify_url' => 'https://open.spotify.com/track/3IclZs4N6q5iKZ35vr9Jxe',
                'spotify_track_id' => '3IclZs4N6q5iKZ35vr9Jxe',
                'duration_formatted' => '6:48',
                'spotify_preview_url' => 'https://p.scdn.co/mp3-preview/af5bc221004848f44f96eef3196cfe11755639df?cid=8897482848704f2a8f8d7c79726a70d4',
                'spotify_thumbnail_url' => 'https://i.scdn.co/image/9d9995440c5446b4d4edc4a1fac1c913e8a2aded',
                'playlists' => array(
                    'data' => array(
                        array(
                            'id' => 999999,
                            'name' => 'T3 Playlist #1',
                            'duration' => 6,
                            'owner' => '999999999',
                            'owner_name' => '999999999',
                            'owner_profile_url' => 'https://api.spotify/com/user/999999999',
                            'playlist_url' => 'https://api.spotify.com/playlist/123456789',
                            'playlist_thumbnail_url' => 'https://mosaic.scdn.co/640/123456789'
                        )
                    )
                )
            )
        );

        $playlist = new Playlist;
        $playlist->id = 999999;
        $playlist->name = 'T3 Playlist #1';
        $playlist->owner_id = '999999999';
        $playlist->owner_profile_url = 'https://api.spotify/com/user/999999999';
        $playlist->playlist_url = 'https://api.spotify.com/playlist/123456789';
        $playlist->playlist_thumbnail_url = 'https://mosaic.scdn.co/640/123456789';
        $playlist->save();

        $track = new Track;
        $track->id = 999999;
        $track->title = 'Sanctuary - Ben Gold Remix';
        $track->artist = 'Gareth Emery';
        $track->album = 'Sanctuary Remixes';
        $track->duration = 408358;
        $track->spotify_track_id = '3IclZs4N6q5iKZ35vr9Jxe';
        $track->spotify_url = 'https://open.spotify.com/track/3IclZs4N6q5iKZ35vr9Jxe';
        $track->spotify_preview_url = 'https://p.scdn.co/mp3-preview/af5bc221004848f44f96eef3196cfe11755639df?cid=8897482848704f2a8f8d7c79726a70d4';
        $track->spotify_thumbnail_url = 'https://i.scdn.co/image/9d9995440c5446b4d4edc4a1fac1c913e8a2aded';
        $track->save();

        // Attach Playlist to Track
        $track->playlists()->attach($playlist);

        // Transform Track
        $output = fractal($track, new TrackTransformer)
            ->includePlaylists()
            ->toArray();

        $this->assertEquals($output, $expected);
    }
}
