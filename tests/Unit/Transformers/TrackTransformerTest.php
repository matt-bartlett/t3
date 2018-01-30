<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use App\Models\Track;
use App\T3\Transformers\TrackTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackTransformerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_track_model_transforms()
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
        $track->id = 999;
        $track->playlist_id = 1;
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
}

