<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_stats_generation()
    {
        $tracks = factory(Track::class, 30)->create([
            'duration' => 20000
        ]);

        $playlist = factory(Playlist::class)->create();

        // Attach all Tracks to Playlist
        $playlist->tracks()->attach($tracks->pluck('id'));

        $response = $this->json('GET', 'api/stats')->decodeResponseJson();

        $this->assertEquals($response['data']['total_playlist_count'], 1);
        $this->assertEquals($response['data']['total_track_count'], 30);
        $this->assertEquals($response['data']['total_track_duration'], 10);
    }
}
